# Introduction to the Eyecandy Library

This library does all the hard work of capturing live-playback audio and producing different representations of the sound data as OpenGL textures. It is how Monkey Hi Hat processes audio data, but it can be used independently of Monkey Hi Hat. The library has several basic parts:

* Audio capture and audio data (raw and processed)
* Multi-threaded conversion of audio data to OpenGL textures
* Audio texture management
* Helper classes for OpenGL window and shader management

This section explains the technical aspects of the library and how to write programs using the library. It is oriented to developers who are already familiar with modern .NET development.

If you're just looking for a visualizer, this probably won't be of much interest -- you want the [Monkey Hi Hat](https://www.monkeyhihat.com/docs/index.php#/introduction) application which uses this library. Usage is detailed in other areas of this documentation.

Even if you are here for the eyecandy library, in the Monkey Hi Hat portions of the documentation you will find help [understanding audio textures](understanding-audio-textures.md) and various topics about porting or creating visualization shaders, which are also important topics for writing your own eyecandy-based application.

Although the original plan was to use a Raspberry Pi 4B, GPU performance is worse than expected. Also since they're currently stuck on the very old OpenGL ES 3.1 (with some 3.2 capabilities) it can't support some of the features I want in the Monkey Hi Hat program. Consequently, as of the v2 release, the default GL setting has changed to `BaseWindow.ForceOpenGLES3dot2 = false`. This means the OpenTK default of full-API OpenGL 3.3 will be used by this library unless you override it. The Monkey Hi Hat project is targeting GL 4.5, which is the last version supported by Linux MESA drivers (and 4.6 is supposedly the last version of OpenGL _ever_, while the Khronos Foundation disappears down the rabbit-hole of the "new" Vulkan API).

_Major Dependencies_

* [OpenTK](https://github.com/opentk/opentk)
* [NAudio](https://github.com/naudio/NAudio)
* [FftSharp](https://github.com/swharden/FftSharp)
* [.NET 8](https://dotnet.microsoft.com/en-us/download)
* [GLFW](https://github.com/glfw/glfw)
* [OpenAL-Soft](https://github.com/kcat/openal-soft)

OpenAL and OpenAL-Soft is only required on Linux. Windows _can_ use OpenAL-based audio capture (with a third-party audio loopback driver) but as of eyecandy v3, the default Windows audio capture methodology is to use the internal WASAPI loopback device, which also provides higher quality data with measurably lower latency.
