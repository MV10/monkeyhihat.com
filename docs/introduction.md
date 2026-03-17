# Introduction

Monkey Hi Hat is a cross-platform music visualizer. It displays colorful, interesting graphics, many of which are audio-reactive,  moving and changing in time with whatever music is being played through your PC's speaker outputs. This documentation explains how to install, use, and customize the program. The source code repository's [README](https://github.com/MV10/monkey-hi-hat/blob/master/README.md) file offers a few short sample video clips, images, and links to related information. 

> Please understand there is no "user interface" -- the program is designed to run full screen, and to be controlled from another PC or Android device. Remote control is optimal but not mandatory. The general idea is to get it running and let it do its thing.

If you have problems or questions, please open a Github [Issue](https://github.com/MV10/monkey-hi-hat/issues) and ask for help.

In a desktop browser, you can drag the right-hand side of this documentation content area to set a comfortable reading width.


## Requirements

The hardware requirements are relatively modest. Other than DJ/VJ streaming scenarios, CPU and memory usage are typically very low. I do not support Intel GPUs (see _Hardware Notes_ below).

* A modern graphics processor that supports OpenGL 4.5
* .NET 10 runtime (or the equivalent .NET SDK)
* Recommended: Monkey-Droid GUI remote control
* Optional: SSH remote control
* For content creators: GLSL editor or IDE extension

And of course, you will need a source of music such as Spotify, Soundcloud, line-in, a media player or whatever else you prefer. Spotify has a decent native client for each OS ([Windows](https://open.spotify.com/download), [Linux](https://www.spotify.com/de-en/download/linux/)) which has the benefit that it allows remote-control of music playing through your PC from any other client on the same network, such as your phone or a laptop.


## Getting Started

The Windows install program handles _all_ major setup requirements. Linux installation requires a couple of manual steps.

The _Quick Start_ pages explain how to install the application and content.

Refer to the _Using Monkey Hi Hat_ section for a brief first-time walkthrough to confirm everything is working.

Although the program has many features and options, generally it should work immediately after installation.

Launching the program varies slightly by OS, but once it is running, it works identically on both operating systems.


## Advanced Usage

After getting familiar with the program running locally, DJ / VJ users may want to refer to specific configuration options for running shows in more complex environments described on the [DJ and VJ Notes](dj-and-vj-notes.md) page, including line-level audio, and video routing with Spout or NDI.

I welcome both application and content contributions and collaboration. For app programmers, refer to the [Contributors Getting Started](contributors-getting-started.md) page for a quick overview. For OpenGL content programmers, the documentation has many sections under _Content Creation_ to help you get started, and you'll want to review the [README](https://github.com/MV10/volts-laboratory/blob/master/README.md) for the _Volt's Laboratory_ repo where content is stored.

If you're interested in the technical underpinnings, there is some information in the [eyecandy section](https://www.monkeyhihat.com/docs/index.php#/eyecandy-introduction), which is the library that powers Monkey Hi Hat, and in various articles on my [blog](https://mcguirev10.com/). But at this point, most of the information is here (and in fact, developers interested in eyecandy are directed to the Monkey Hi Hat documentation for various aspects of setup and usage).


## Hardware Notes

I won't pay much attention to problems with Intel GPUs, particularly laptop-level integrated GPUs. Simply put, Intel's drivers are so buggy they're nearly worthless. This may be a non-issue, because many of them can't handle the required OpenGL API level 4.5. Sad but true. My own laptop, a relatively-new and otherwise excellent Dell XPS13, can barely chug through some of the more basic shaders at just 1920 x 1080. 

On the other hand, my "living room" mini-PC, which is mainly where we use this program, has no problem running most of these at full 2K (which my amplifier then upscales to 4K). That machine is a Minisforum UM790 Pro, which has an excellent AMD Radeon 780M laptop-class GPU.

In short, NVIDIA and AMD GPUs are strongly recommended. If you're having problems, please update your GPU driver before submitting a bug report, especially if the problem is specific to one or a few of the visualizers. For Linux users with NVIDIA GPUs, I found it was necessary to switch to X11 due to driver texture bugs using Wayland.
