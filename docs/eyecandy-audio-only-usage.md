# Eyecandy: Using Audio-Only Processing

> TODO: Provide a more detailed explanation. This was moved from the original quick-and-dirty README.

It is possible to use the audio processing portions without the OpenGL texture features:

* Create an `EyeCandyCaptureConfig` object to define audio capture parameters
* Create an `AudioCaptureBase` object by calling the static `Factory` method
* For post-processing, assign an `AudioProcessingRequirements` struct to `audio.Requirements`
* Create an `Action`-style callback (no arguments, returns `void`)
* Create a `CancellationTokenSource`
* Start capturing with `Task.Run(() => audio.Capture(callback, cancellationToken))`
* In the callback, reference the sample and processed data arrays in `audio.Buffers`
* Stop capturing:
    * Cancel the token
    * `await` the `Task` returned from the `Task.Run` invocation
    * Call `Dispose` (or re-start capture)

The "Peaks" demo is a good example of this, presenting a purely console-based analysis of data maximums.
