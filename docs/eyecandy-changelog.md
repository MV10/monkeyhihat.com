# Eyecandy Changelog

#### v4.3.3 2025-11-02
* Remove accidental debug output

#### v4.3.2 2025-11-01
* Added `EyeCandyCaptureConfig.OpenALContextDeviceName` (blank for default)
* Revised OpenAL audio capture for Linux PipeWire compatibility

#### v4.3.1 2025-10-29
* Suppress throttled-error summary when no errors were collected

#### v4.3.0 2025-10-17
* Added `EyeCandyWindowConfig.OpenGLErrorLogging` flag (default is Normal)
* Added `EyeCandyWindowConfig.OpenGLErrorBreakpoint` flag (default is false)
* Added `EyeCandyWindowConfig.OpenGLErrorThrottle` (default is 60 seconds)
* Logs extra error details via `GLErrorAppState` object
* Removed `ErrorLogging` fields that were marked obsolete in v4.0.0

#### v4.2.0 2025-10-01
* Add WASAPI line-in support (set `EyeCandyCaptureConfig.CaptureDeviceName`)
* Add WASAPI device enumeration to demo project with the `info` switch
* Change OpenAL device enumeration in demo to require `info O` switches

#### v4.1.0 2025-09-20
* Add `Shader.SetCubemap` to associate a cubemap with a uniform
* Add optional `TextureTarget` argument to `Shader.SetTexture` methods

#### v4.0.0 2025-08-25
* Initialize texture buffers separately from `AudioTexture.GenerateTexture`
* Pin the buffer in `AudioTexture.GenerateTexture` (requires "unsafe")
* Change `AudioTexture.GenerateTexture` to use `GL.TexSubImage2D` (non-allocating)
* Remove obsolete `AudioTextureEngine.EndAudioProcessing_SynchronousHack`
* **BREAKING CHANGES**
    * Standarized and improved logging
        * Added `ErrorLogging.LoggerFactory`
        * Removed `ErrorLogging.LoggingStrategy` (consumer can configure console output)
        * Removed `ErrorLogging.Logger` in favor of loggers with categories
        * Emits messages with correct log categories (prefixed with "Eyecandy.XYZ")
        * Eliminated log message string interpolation
        * Demo changes to support/demonstrate new logging features

#### v3.3.0 2025-08-17
* Use thread-safe `InternalBuffers` for `AudioCaptureWASAPI.PopulateWaveBuffer`
* Synthetic wave data generator used for either testing or silence-replacement
* New `EyeCandyCaptureConfig` settings for synthetic data generation:
    * `MinimumSilenceSeconds` - default 0.25, duration before "silence" is flagged
    * `ReplaceSilenceAfterSeconds` - default 2.0, applies if `DetectSilence` is true
    * `SyntheticAlgorithm` - currently only `MetronomeBeat` is available
    * `SyntheticDataBPM` - default is 120
    * `SyntheticDataBeatDuration` - default is 0.1 seconds
    * `SyntheticDataBeatFrequency` - default is 440 Hz
    * `SyntheticDataAmplitude` - default is 0.5, range is 0.0 to 1.0
    * `SyntheticDataMinimumLevel` - default is 0.1f, base volume level

#### v3.2.0 2025-08-06
* Completely revised error handling and logging
* Added KHR / OpenGL debug-message error callback support with stack traces
* Removed old-style `GL.GetError` checks

#### v3.1.0 2025-08-04
* Changed to `Mutex`-based locking for OpenGL background-thread operations
* Library consumers who frequently update textures should read Wiki section 2

#### v3.0.1 2024-11-04
* Minor debug-logging tweak to clarify the build phase in the Shader constructor

#### v3.0.0 2024-01-27
* Dependency on NAudio 2.1.1 (no longer requires a loopback driver on Windows!)
* `EyeCandyCaptureConfig.LoopbackApi` (defaults: Windows `WindowsInternal`, Linux `OpenALSoft`)
* Refactored `AudioCaptureProcessor` into abstract `AudioCaptureBase` class
* Created concrete `AudioCaptureOpenALSoft` and `AudioCaptureWASAPI` classes
* Optional `AudioCaptureBase.Factory` to create a concrete instance based on config
* `Shader.GetUniform(name)` (currently only for `float` types)
* `Shader.ResetUniforms()` (currently only for `float` types)
* Calling `Shader.Use` only invokes the OpenGL API if the current shader is changing
* Added vert/frag pathnames to Shader constructor error messages

#### v2.0.6 2023-12-03
* Updated to .NET8
* Updated OpenTK to v4.8.2
* Shadertoy PCM wave midpoint corrected to 0.5 (full range is 0.0 to 1.0)
* Added `SetUniform` overload for `Vector2i` data
* Added `AudioTextureEngine.GLTextureLock` to synchronize GL texture-binding operations

#### v2.0.5 2023-10-20
* Added `Vector4` overload for `Shader.SetUniform`
* Changed "uniform not found" messages to trace log-level, added shader filenames to messages
* `Shader` constructor aborts after any load/compile failure
* Added `GL.Enable(EnableCap.ProgramPointSize)` to `BaseWindow.OnLoad`
* Added `ShaderLibrary` to pre-compile reusable function libraries
* Added optional library args to the `Shader` constructor (see `Vert` demo)
* Replaced async `EndAudioProcessing` with thread-safe synchronous call, depreacated old synchronous hack

#### v2.0.3 2023-09-16
* Updated OpenTK to v4.8.0 and FftSharp to v2.1.0
* Trace-level Dispose logging (note OpenGL/OpenAL are _very_ incompatible with async disposal!)

#### v2.0.0 2023-09-07
* Changed `BaseWindow.ForceOpenGLES32` to `false` by default
* Automatic `TextureUnit` assignment by types based on GL's "max combined texture unit" value
* Creating an `AudioTexture` which already exists and has the same uniform name logs a warning
* Creating an `AudioTexture` which already exists with a different uniform name throws an exception
* Checks `IsDisposed` in Capture method
* Properly disposes of GL texture handles
* Removed texture multiplier support: do this inside the shaders

#### v1.0.82 2023-09-02
* Removed OpenAL calls unnecessary for capture-only usage (bugfix)
* Removed EyeCandyCaptureConfig.DriverName (unnecessary for capture)
* Added WebAudio to `demo history`
* Expanded logging
* Add disposal finalizer suppression (just in case)

#### v1.0.8 2023-07-31
* More closely match WebAudio's weird output
* Add a demo showing real decibel data side-by-side with WebAudio data
* Modified the "frag" demo so it matches the Shadertoy preview size

#### v1.0.7 2023-07-30
* Added WebAudio-style buffer data and history texture
* Changed the Shadertoy texture to use WebAudio data
* Modified the "frag" demo to remove multipliers and other hacks

#### v1.0.6 2023-07-27
* HideMousePointer option
* Converted storage class to record
* Improved error logging, added some debug-level log output
* Engine-level silence detection support

#### v1.0.3 2023-07-23
* Squash a Linux bug: can't call AL.GetError after closing all devices...

#### v1.0.2 2023-07-22
* Added silence-detection settings to config (DetectSilence, MaximumSilenceRMS)
* Added silence-detection to buffers (SilenceStarted timestamp)
* Added "silence" demo
* Changed Shader to log unknown uniform names as Info level rather than Warn

#### v1.0.1 2023-07-20
* Improved / expanded error-handling and reporting
* Added `AverageFramesPerSecond` to `BaseWindow.CalculateFPS` method with configurable period
* Optional standard `ILogger` support (populate via `ErrorLogging.Logger` static field)
* `BaseWindow.Shader` creation is optional (via `createShaderFromConfig` constructor parameter)
* OpenGL ES 3.2 made optional (`BaseWindow.ForceOpenGLES3dot2` static field is `true` by default)
* Demo project forces all error logging to the console and all GL demos output average FPS upon exit
 