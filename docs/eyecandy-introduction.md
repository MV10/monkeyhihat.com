# Eyecandy Library: Introduction

The eyecandy library has several basic parts:

* Audio capture and audio data (raw and processed)
* Multi-threaded conversion of audio data to OpenGL textures
* Audio texture management
* Helper classes for OpenGL window and shader management

This wiki explains the technical aspects of the library and how to write programs using the library. It is oriented to developers who are already familiar with modern .NET development.

If you're just looking for a visualizer, you should look at my [Monkey Hi Hat](https://github.com/MV10/monkey-hi-hat) application instead. A Windows installer is available in the [Releases](https://github.com/MV10/monkey-hi-hat/releases) section, and usage is detailed in the other documentation in this area.

There users and developers alike will also find help setting up your Windows or Linux system for audio loopback in the Quick-Start sections, as well as help understanding audio textures and porting or creating visualization shaders, which are also important topics for writing your own eyecandy-based application.

Although the original plan was to use a Raspberry Pi 4B, GPU performance is worse than expected. Also since they're currently stuck on the very old OpenGL ES 3.1 (with some 3.2 capabilities) it can't support some of the features I want in the Monkey Hi Hat program. Consequently, as of the v2 release, the default GL setting has changed to `BaseWindow.ForceOpenGLES3dot2 = false`. This means the OpenTK default of full-API OpenGL 3.3 will be used by this library unless you override it. The Monkey Hi Hat project is targeting GL 4.5, which is the last version supported by Linux MESA drivers (and 4.6 is supposedly the last version of OpenGL _ever_, while the Khronos Foundation disappears down the rabbit-hole of the "new" Vulkan API).

_Major Dependencies_

* [OpenTK](https://github.com/opentk/opentk)
* [NAudio](https://github.com/naudio/NAudio)
* [FftSharp](https://github.com/swharden/FftSharp)
* [.NET 8](https://dotnet.microsoft.com/en-us/download)
* [GLFW](https://github.com/glfw/glfw)
* [OpenAL-Soft](https://github.com/kcat/openal-soft)

OpenAL and OpenAL-Soft is only required on Linux. Windows can use OpenAL-based audio capture (with a third-party audio loopback driver) but as of eyecandy v3, the default Windows audio capture methodology is to use the internal WASAPI loopback device. (It also provides higher quality data with lower latency.)