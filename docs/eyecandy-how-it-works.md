# Eyecandy: How It Works

## Overview

The eyecandy library uses either the Windows WASAPI multimedia API or OpenAL to open a "capture device" which normally means "microphone". However, because the goal is to capture music as it is being played, if you use OpenAL, you will need to configure the computer for "loopback" audio (loopback configuration is internal and automatic on Windows using WASAPI). In the old days, a loopback plug was literally a short loop of cable which plugged into an audio-out jack, and the other end _looped back_ into the audio-in (or "mic") jack. With modern computers, we can do this with software.

Once this is done and eyecandy has connected to the loopback capture device, the API periodically sends digitized audio data buffers to eyecandy. This data is Pulse-Code Modulated (PCM) data, more commonly known as "wave" data, which is the same format used by audio compact discs. By default, eyecandy requests monaural (one channel) data at 44.1kHz into a buffer composed of a 1024 element `short` array. Even though the source data is multi-channel (such as 2-channel stereo or 5.1 surround), the API is configured to combine the channels. 44,100 samples per second in 1024 sample increments means the buffer is updated approximately 43 times per second (44100 / 1024 = 43.06), which means each sample represents about 23ms of data (1000 / 43 = 23.25).

One interesting quirk of using the NAudio library for WASAPI loopback on Windows is that an exact 1024-sample buffer is not possible. NAudio automatically creates a buffer based on a _milliseconds_ value, and since that's an integer, we can't specify 23.25. Instead, the library specifies 23ms which _should_ be 1014 samples -- although in practice, sometimes NAudio triggers the processing event with far fewer samples, and other times with many more. It was therefore necessary to implement an interpolation algorithm so that 1024 samples results. Visually, this is still the fastest, smoothest, lowest-latency audio-sampling option (consider reading directly from the Windows multimedia API, versus the other alternative: reading from OpenAL-Soft, which is "routed" through OpenAL, which is reading from a third-party capture driver like VB-Audio CABLE, which in turn is receiving data from a pass-through playback driver).

All of this work takes place in the `AudioCaptureBase` class (and either WASAPI- or OpenAL-oriented concrete implementations), and the resulting data buffers are made available in an `AudioData` object held by that class. (Technically, since audio capture happens on a background thread, audio data is double-buffered to minimize locking requirements by data consumers -- the code which converts the audio data to texture graphic buffers.)

Currently, eyecandy supports four types of audio post-processing: RMS Volume, FFT Frequency Magnitude, FFT Frequency Decibels, and something similar to the way the browser WebAudio API produces Decibel data. All, some, or none of the post-processing calcs are performed, based on the requirements of the program consuming the data. The requirements are controlled by a simple set of flags in an instance of the `AudioProcessingRequirements` record. These can be changed as the program runs.

## PCM Wave Data

The raw PCM data is buffered as an array of 1,024 16-bit short integers, which means the supplied data will be in the +/-32767 range. The true values you'll see are actually about half of that range, min/max. Since this is a zero-crossing signal (think of a sine wave), you will see both negative and positive values in the data.

Library users can read this from `AudioData.Wave`.

## RMS Volume

A common audio volume calculation is Root-Mean-Squared, or RMS. There are other ways to calculate volume, but RMS is reasonably accurate and far less computationally-costly to produce. It is simply the square root of the averaged absolute-value of the past 300ms of PCM samples. That represents a single realtime "point in time" volume measurement. Human beings tend to require about 300ms to perceive a change in volume. The library uses a 13,230-sample array as a circular buffer for volume calculation (300ms / 1000ms = 0.3 * 44100kHz = 13230 samples).

Library users can read this from `AudioData.RealtimeRMSVolume`.

## Fast-Fourier Transforms

FFT is a mathematical analysis technique which is able to break down a complex waveform into the relative strengths of the frequencies which make up the sample. As a rule of thumb, you need twice as much input data to produce output of a given size (for somewhat [complicated](https://github.com/swharden/FftSharp/issues/25#issuecomment-687653093) reasons), so the library maintains a 2,048 sample buffer which yields frequency data the same size as the PCM buffer. (Technically 1,025 values are output, not 1,024, but the [reason](https://github.com/swharden/FftSharp/issues/69) is technical, and I believe it is unimportant for our purposes.)

The library relies on Scott Harden's excellent [FftSharp](https://github.com/swharden/FftSharp) library.

## FFT Frequency Magnitude

Once we have run the FFT calculations, the FftSharp library can output signal power data as Frequency Magnitude. This is a measurement _relative_ to the other frequency components of the signal. It is probably the most accurate measurement, but the data is "subtle" and it can be difficult to work with in the context of audio visualization.

Although magnitude data is represented as an array of `double` values, in practice the range of values you'll see is zero to about 6500.

Library users can read this from `AudioData.FrequencyMagnitude`.

## FFT Frequency Decibels

Decibels (dB) are a measurement of sound intensity, or the power level of a signal. There is a direct relationship between Frequency Magnitude and Decibel data, but dB data is "stronger" in the sense that the range of values and variation is larger. This makes it easier to work with in the context of audio visualization.

Although decibel data is represented as an array of `double` values, in practice the range of values you'll see is zero to about 90. Although this is a much smaller range of possible values than you'll see in the equivalent magnitude data, the _majority_ of the magnitude data will show much, much smaller numbers.

Library users can read this from `AudioData.FrequencyDecibels`.

## WebAudio

The WebAudio specification is highly technical, but [this](https://gist.github.com/soulthreads/2efe50da4be1fb5f7ab60ff14ca434b8) claims to "translate" those formulas, and has additional information about how Shadertoy uses WebAudio data. I'm not sure if that "translation" is accurate, because the result doesn't look anything like Shadertoy data, so currently the library's WebAudio output is just the standard FFT Decibel Power calculation with the "smoothing" step applied from that document, and a different divisor for normalization. Running the "frag" demo side-by-side with my Shadertoy code using the same shader, the output is very similar. This data also usually produces good results with VertexShaderArt adaptations.

Library users can read this from `AudioData.FrequencyWebAudio`.

## Frequency and Beat Detection

Audio visualization common requires some form of "beat detection". There are many ways to tackle this problem, but the easiest is to simply focus on the bass ranges of the frequency spectrum. A strong bass-note is a relatively reliable indication of the beat. The FFT section explained that frequency calculations require 2048 audio samples to produce frequency power values. We can use this to calculate that each frequency data point represents 10.77Hz (44100 / 2 / 2048 = 22050 / 2048 = 10.77Hz). If we define "bass" as 100Hz or less, this means approximately the first 9 or 10 array indices are the bass frequencies (100 / 10.77 = 9.29).

Since shader texture samplers are accessed as a 0.0 to 1.0 floating point range, bass up to 100H is 0.0 to 0.0929, although it is simpler to use 0.0 to 0.1. In practice, you will find that exactly 0.0 often has an undesirably strong signal, so it's common to add a small offset like 0.001.

## Audio to Texture Conversion

The audio data fed to the shaders as texture buffers is actually a nearly-direct copy of the audio buffers described above, normalized to a 0.0 to 1.0 `float` according to upper bounds defined by properties in the `EyeCandyCaptureConfig` class:
* `NormalizeRMSVolumePeak`
* `NormalizeFrequencyMagnitudePeak`
* `NormalizeFrequencyDecibelsPeak`
* `NormalizeWebAudioPeak`

This conversion happens in the `AudioTextureEngine` class. There is more discussion on the wiki pages which explain the available audio textures.