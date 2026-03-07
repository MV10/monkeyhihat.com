# Contributor's Getting Started

## Welcome

If you're a .NET developer who is interested in fixes, changes, and improvements to Monkey Hi Hat or its related repos, this page will help you get oriented. I'd recommend creating a new Issue to discuss your ideas and plans before you spend much time working on the code, but I very definitely would welcome contributor PRs!

## Getting Started

As of version 5.2.0, Linux is officially supported.

Working on MHH should be as simple as forking and cloning the repo, then firing up Visual Studio or JetBrains Rider. I assume anyone interested in development has already installed and run the app, which means you should already have the [volts-laboratory](https://github.com/MV10/volts-laboratory) content (visualizers, FX, etc) in your `C:\Program Data\mhh-content` or `/opt/mhh-content` directory. You will want to modify your config file to point there. 

I won't accept PRs of the config files unless you're (a) adding something new or fixing something (start an Issues discussion about it first), and (b) have applied *only* those changes to the config files I distribute now, and (c) you're also willing to update the install processes to support the new config. Read the page on configuration to find out how to reference a stand-alone config that isn't part of source control.

You should probably have at least a passing familiarity with OpenGL programming (GLSL, or at least something like Shadertoy's WebGL). There are definitely areas of the codebase that never touch on that at all, but the bulk of it is really in the weeds on rendering sequences (particularly the intricacies of buffer-handling) and GL resource-handling.

If you're not familiar with multi-threaded applications, unsafe code, or careful disposal of unmanaged resources, I'd advise extreme caution here, and please mention that to me when you open an Issue. For the most part, if you understand `async/await` and `Task` usage (for example, you understand the difference between `WhenAll` and `WhenAny` and what "aggregate exception" means, and why async and parallelism are different things), you should be fine. OpenGL is not even a little bit thread-safe, and never will be, but most of the tricky stuff happens in the separate `eyecandy` audio/OpenGL library that MHH uses.

## Solution Structure

The solution has a few Solution Folders which point to content in the repo's top-level `testcontent` directory, so if you need to create a test visualizer or FX relating to some new feature, you'll have to manually create it there, then `Add -> Existing Item` to the appropriate Solution Folder for it to show up.

In addition to the `mhh` project itself, there is the Windows installer .NET Framework project (`install`, refer to the readme for some details), and the Linux packaging scripts (`linuxpkg`). Directories within the `mhh` project are described below. 

### Program.cs

MHH is a .NET console program, so at the top level you'll find a `Program.cs` with the usual `Main` entry point. This is a pretty basic config parser and command-line switch parser. MHH is designed to be controlled remotely, so when the program runs, it uses `CommandLineSwitchPipe` to listen for incoming command switches either via local named pipes, or over TCP/IP from another machine (or Monkey Droid running on Android on the same network).

### ConfigFiles Directory

This is where the default program configuration files are stored (`mhh.conf` and the debug variation), as well as `version.txt` used by the installer. Check out the readme for details. Notably, you'll see a lot of references to `Program.AppConfig` which is a public static object exposing the parsed program configuration.

### Hosting Directory

The `Hosting` folder is where you'll find the `HostWindow` class which is the real program loop that runs MHH visualizations and orchestrates all the rest. This is globally accessible as `Program.AppWindow`. It exposes a bunch of functions such as `Command_Load` or `Command_QueueCrossfade` which the console program code invokes after processing command switches. Although MHH is an OpenGL program, it relies heavily on the wrapper library [OpenTK](https://github.com/opentk/opentk), and `HostWindow` is where you'll find a few critical OpenTK event-handlers such as `OnLoad`, `OnRender` and `OnUpdate`.

The rest of the class files here are pretty self-explanatory. For example, `FXConfig.cs` handles parsing and storing the `.config` files that define post-processing effects, and `PlaylistManager.cs` handles playlist processing when MHH is running in that mode.

### InternalShaders Directory

These are the bare-bones minimum shaders and config files that allow MHH to run without any additional content. There are also some utility files like the pass-through vertex and fragment files which get re-used all over the place. Most of this is compiled at start-up and stored in a cache.

### Libraries Directory

This is where third-party binaries are stored which can't be easily installed from some other source. Currently that means the NDI streaming-texture libraries obtained from the NDI SDK. They're in the repo as content files so that they will be copied to the build output directory during development. For an installed end-user scenario, the Windows DLLs are downloaded from my monkeyhihat.com server (since they change rarely and would unnecessarily bloat the app archive), and the Linux SOs will likely be part of the .deb package (as I write this, packaging is a _TODO_ item).

### Rendering Directory

Here you'll find `RenderManager`, which `HostWindow` exposes as `Renderer` (ie. `Program.AppWindow.Renderer`). This class mostly coordinates other specialized `IRenderer` implementations, which in turn know how to run different types of visualizers (such as single-pass or multi-pass), post-processing effects, crossfade transitions, and so on. If you're interested in this area of the code, start with `SimpleRenderer` for a bare-minimum example of how these rendering implementations work (particularly the `RenderFrame` method).

There is also `TextManager` which can handle displaying and hiding overlay text (which is just another buffer layer generated by a shader).

The static `RenderingHelper` class is a large collection of methods for common chores such as working with the shader caches, various OpenGL resources like textures and uniforms, and complex tasks like viewport calculations after window-resize events.

### Streaming Directory

These are the classes that support sending and receiving textures with the Spout protocol (Windows-only) and the NDI protocol (cross-platform, and also dedicated hardware such as cameras, studio equipment, etc.).

### Utils\Caching Directory

MHH has a few types of caching, all of which is exposed through the `Caching.cs` static class. In some cases like `IdleVisualizer` or `TextShader`, the "cached" data is just an object directly held by the class. There are also several Least-Recently Used (LRU) caches for visualizer, FX, and library shaders, and a permanent `List<>` cache of the crossfade transition shaders, which are scanned, loaded, and compiled at start-up (because they're used very frequently).

The class also stores a `MaxAvailableTextureUnit` integer. This may seem like a strange place to store this value, but the thinking is that it's cached because it has to be read from OpenGL, and it's used often enough that we wouldn't want to be re-reading it all the time via native API calls (and it is specific to your GPU and won't change unless you physically swap hardware).

### Utils\Global Directory

This directory is basically the dumping-ground for globally useful stuff -- constants, enumerations, extensions, logging, and path utilities. Pretty self-explanatory.

### Utils\OpenGL Directory

Not surprisingly OpenGL-specific code and definitions are stored here. In particular, `GLResourceManager.cs` handles the fairly complicated processes around creating, resizing, and cleaning up textures and framebuffers, and keeping track of all the little details and numbers that OpenGL requires for each of these. Within MHH we have the concepts of `GLResourceGroup` and `GLImageTexture`, which are a field-only classes where all those OpenGL details are stored by the manager.

When you get into multi-pass buffer handling, particularly when you're talking about more than one of them running at once (such as a multi-pass visualizer plus a multi-pass post-processing effect), this can get pretty tricky -- especially when you're trying to sustain 60FPS at high resolution, all while tip-toeing around the non-thread-safe OpenGL API.

Definitely talk to me ahead of time if you think you want to mess around in this area of the program.

### Utils\OSInterop Directory

Since MHH is cross-platform, a few features need OS-specific handling. The `Program.Main` function creates an `IOSInterop` object based on the OS environment. These provide features like audio track monitoring and terminal interactions. Any contributor wishing to implement an OS-dependent feature must update `IOSInterop` and provide both a Windows and Linux equivalent, or a suitable stub if there is no equivalent.

### VertexSources Directory

In MHH parlance, a vertex source is what feeds data into the vertex stage of the shader pipeline. Currently there are only two, and these are documented under _Creating Visualizations_. Pretty simple stuff.

## Related Repositories

In addition Monkey Hi Hat itself, I have several related repos you should be at least passingly familiar with.

| Repository | Description |
|---|---|
| [eyecandy](https://github.com/MV10/eyecandy) | A library that does all the heavy lifting of analyzing audio data and converting it to OpenGL textures, which the shaders use for music reactivity. |
| [volts-laboratory](https://github.com/MV10/volts-laboratory) | Storage for all of the visualizer, FX, crossfade, and library files (configs and shaders) that make up the content distributed with MHH. |
| [monkey-see-monkey-do](https://github.com/MV10/monkey-see-monkey-do) | A Windows Service distributed with MHH that can start MHH over TCP/IP if MHH is not currently running (for remote-control convenience purposes). |
| [monkey-droid](https://github.com/MV10/monkey-droid) | A MAUI 1.0 remote-control application for Android and Windows. Unsure about the future of this one, it works and it's convenient, but MAUI is a train-wreck right now from the developer-experience standpoint. |

## Dependencies

In addition to my eyecandy library, MHH itself is directly dependent upon these third-party libraries:

| Repository | Description |
|---|---|
| [CommandLineSwitchPipe](https://github.com/MV10/CommandLineSwitchPipe) | passes switches to a running instance |
| [FFMediaToolkit](https://github.com/radek-k/FFMediaToolkit) | video playback via ffmpeg |
| [NdiLibDotNetCoreBase](https://github.com/eliaspuurunen/NdiLibDotNetCoreBase) | NDI streaming textures |
| [Spout.NETCore](https://github.com/AWAS666/Spout.NETCore) | Spout streaming textures |
| [StbImageSharp](https://github.com/StbSharp/StbImageSharp) | still-image loading |
| [StbImageWriteSharp](https://github.com/StbSharp/StbImageWriteSharp) | screenshot creation |
| [Tmds.DBus](https://github.com/tmds/Tmds.DBus) | Linux audio track info |
| [WindowsMediaController](https://github.com/DubyaDude/WindowsMediaController) | Windows audio track info |

The eyecandy library adds the following dependencies, although MHH only uses OpenTK directly:

| Repository | Description |
|---|---|
| [FftSharp](https://github.com/swharden/FftSharp) | Fast Fourier Transform functions |
| [NAudio](https://github.com/naudio/NAudio) | Windows audio-capture support |
| [OpenTK](https://github.com/opentk/opentk) | OpenGL and OpenAL wrappers and helpers |
| [Serilog](https://github.com/serilog) | Logging |

## Conclusion

For starters, check out `Program.cs` and `HostWindow.cs`, then follow your way into the rendering pipeline. I'm a big believer in explanatory comments, particularly when the code is doing something complicated.

I'm looking forward to your interest and assistance!

