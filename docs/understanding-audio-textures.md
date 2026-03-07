# Understanding Audio Textures

## The Concept

The term "texture" in OpenGL is misleading, because these kinds of data buffers are commonly used to pass non-image data. In our case, we're encoding different kinds of audio information into these buffers. The data ranges from perceived volume level, to the raw PCM waveforms that amplifiers turn into power to move a speaker, to the results of various frequency-analysis algorithm.

However, the paradigm is still a two-dimensional image buffer. The layout of the data depends on the specific Audio Texture.

**IMPORTANT:** Your system volume setting influences the "strength" of the audio signal reflected in these textures (loopback only; line-in or mic input is not tied to the system volume). The audio-loopback configuration doesn't "know" what the original audio source level is, it only reflects the actual output (technically, _all_ output, not just music -- system notification sounds will be included, for example). My preference is to leave the system volume at 100% and use my stand-alone amplifier volume controls to adjust speaker volume. You can see this effect in action by running the eyecandy `demo` program's _history_ mode, then playing with the system volume while it scrolls the various texture types.

## Available Types

Currently these Audio Textures are available using the indicated uniform names:

  | AudioTexture typename | Fixed uniform name |
  |---|---|
  | AudioTextureWaveHistory | eyecandyWave |
  | AudioTextureFrequencyDecibelHistory | eyecandyFreqDB |
  | AudioTextureFrequencyMagnitudeHistory | eyecandyFreqMag |
  | AudioTextureWebAudioHistory | eyecandyWebAudio |
  | AudioTextureShadertoy | eyecandyShadertoy |
  | AudioTexture4ChannelHistory | eyecandy4Channel |
  | AudioTextureVolumeHistory | eyecandyVolume |

The "History" textures have current data in row zero, and each time the texture is updated, the data is "scrolled" upwards before the new data is generated. Thus, increasing the y-offset is going backwards in time. How much history is available is a function of the texture height and the audio sampling rate. It is generally about four seconds.

All currently available audio textures are 4-channel (RGBA) 32-bit floats. The data is in the green `g` channel, with one exception: `AudioTexture4ChannelHistory` uses all four channels (`rgba`).

Most texture widths match the sample count, defined in the audio config, and the config also defines row counts for history textures. Of course, once they're in the shader, everything is normalized to the 0 to 1 range.

## eyecandyVolume (AudioTextureVolumeHistory)

This represents perceived sound volume with a Root Mean Square (RMS) calculation. By default, the calculation is a sliding window of 300ms because most people detect changes in volume over that approximate timespan. There are other ways of calculating volume, but RMS is the most common by far. The other two major algorithms (LUFS, Loudness Units relative to Full Scale, and LKFS, Loudness K-Weighted relative to Full Scale) are essentially decibel measurements which are more about power levels than perceived volume.

This is a 1-pixel-wide history texture. Sample x at 0.5 to hit the center of the texel, and y 0.5 will represent the most recent volume value.

The eyecandy demo "stretches" the one-pixel-width texture across the entire viewport:

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/25f83a0b-2608-45b1-ad53-a9432db4131d)

## eyecandyWave (AudioTextureWaveHistory)

This is the raw 16-bit PCM wave-sample data. This contains both positive and negative values, and at sufficient volume levels, it will often approach the full range of possible values (which are normalized to the 0.0 to 1.0 range in the shader, of course).

This is a full-width history texture. However, technically this is point-in-time data, which means _both_ the x and y axis are history data. The x axis represents the sample rate of the audio capture buffer (1024 samples, by default), which means at the default settings each row of data represents about 23ms of audio. However, most shaders don't use the data this way.

Direct output of the texture doesn't really convey the "wave" aspect (see the Shadertoy texture below for a different presentation):

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/162fdc4e-3869-45af-a704-28a412298b7f)

## eyecandyFreqMag (AudioTextureFrequencyMagnitudeHistory)

This encodes an FFT frequency analysis represented as a relative magnitude calculation. This data is "subtle" and will probably benefit from boosting the strength with a multiplier. Most shaders using frequency data respond better to the "stronger" signals in the decibel representation.

This is a full-width history texture. The most recent data is at y 0.0, x 0.0 is the lowest frequency (20Hz), and x 1.0 is the highest frequency (20kHz). Increasing the y axis moves backwards in time. According to calculations you can find in the eyecandy wiki, the bass range (100Hz or lower) most commonly used for simple beat detection will occupy the 0.0 to 0.1 area of the texture.

Without magnification, it can be difficult to see this texture at all:

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/dd712d51-fcb7-4974-b15b-933c293b81db)

## eyecandyFreqDB (AudioTextureFrequencyDecibelHistory)

This encodes an FFT frequency analysis represented as decibel level. This data has strong signals compared to the FFT magnitude calculation. 

This is a full-width history texture. The most recent data is at y 0.0, x 0.0 is the lowest frequency (20Hz), and x 1.0 is the highest frequency (22.5kHz). Increasing the y axis moves backwards in time. According to calculations you can find in the eyecandy wiki, the bass range (100Hz or lower) most commonly used for simple beat detection will occupy the 0.0 to 0.1 area of the texture.

The decibel frequency representation is much easier to see:

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/9d4db060-07be-4914-a7b2-086dd726759c)

## eyecandyShadertoy (AudioTextureShadertoy)

This is a non-history texture intended to match the audio data provided by the Shadertoy website, which means there are two rows of data. The y 0.5 row represents frequency decibel data with post-processing similar to the way the browser WebAudio API works, and the y 0.75 row represents the raw PCM wave data. For the decibel data, only the lower-Hz half of the frequency spectrum is represented (about 11kHz and lower).

The PCM wave data should be in the normalized (0.0 to 1.0) range, with 0.5 representing perfect silence. However, in version 3.0 and earlier (and the eyecandy library version 2.0.5 and earlier) the PCM wave data is -1.0 to +1.0. This was corrected in the 3.0.1 release. Very few Shadertoy visualizations use PCM wave data (and the couple from Volt's Laboratory use it in ways that are unaffected by the "wrong" representation).

The eyecandy demo for this texture separately draws the PCM wave data in red and the decibel-like WebAudio frequency data in red.

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/00329d77-e6b5-420b-b18b-8c1f83a1348d)

## eyecandy4Channel (AudioTexture4ChannelHistory)

This combines four audio representations into a single texture buffer.

All four RGBA channels are used:
* red is RMS volume
* green is raw PCM wave data
* blue is frequency magnitude
* alpha is frequency decibels

This is a full-width history texture.

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/24b2b04b-efe3-4774-bbe8-d42cbc84666e)

## eyecandyWebAudio (AudioTextureWebAudioHistory)

This is an approximation of the output from the browser WebAudio API. It's based on a frequency decibel calculation, but it employs an odd time-domain smoothing which is sort of a slow-motion representation of frequency changes. Apart from that, it's just like `AudioTextureFrequencyDecibelHistory` in terms of represented frequency ranges and the bass range occupying approximately 0.0 to 0.1.

This is a full-width history texture.

It may be difficult to see in this thumbnail, but directly viewing the texture has a sort of "smeared" look compared to clean, true decibel data.

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/7799c08f-8ff3-4da3-b83a-18dab4dbde69)

