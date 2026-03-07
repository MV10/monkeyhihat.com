# Introduction

These documents explain how to use Monkey Hi Hat, but also how to set up your system correctly.

As of version 4.0.0, the Windows install program handles _all_ major setup requirements. All you need to do is provide the music! Linux users need a few extra steps (simple).

After installation, you may want to glance at the [Post-Installation](post-install-instructions.md) notes. Even though the installer should get you running, Monkey Hi Hat is designed for interactive control from a remote device. The repository's [README](https://github.com/MV10/monkey-hi-hat/blob/master/README.md) also has links and details.

After getting familiar with the program running locally, DJ / VJ users may want to refer to specific configuration options for running shows in more complex environments described on the [DJ and VJ Notes](dj-and-vj-notes.md) page, including line-level audio, and video routing with Spout or NDI.

If you're interested in the technical underpinnings, there is some information in the [eyecandy wiki](https://github.com/MV10/eyecandy/wiki), which is the library that powers Monkey Hi Hat, and various articles on my [blog](https://mcguirev10.com/). But at this point, most of the information is here (and in fact, developers interested in eyecandy are directed to this documentation for various aspects of setup and usage).

## Requirements

* A modern video card (or integrated GPU) that supports OpenGL API 4.5 (most non-Intel GPUs are OK)
* .NET 8 runtime (or on Windows, Visual Studio with the .NET 8 SDK)
* Recommended: Monkey-Droid GUI
* Optional: Remote control via SSH
* For content creators: GLSL editor or IDE extension

And of course, you will need a source of music such as Spotify or Soundcloud. Spotify has a decent native Windows client ([download](https://open.spotify.com/download)) which has the benefit that it allows remote-control of music playing through your PC from any other client on the same network -- such as your phone or a laptop.

## Running for the First Time

The _Commands and Keys_ documentation shows you all of the command-line options, but that can be overwhelming at first. Here's a quick step-by-step. This assumes you are also using the visualizer and FX content from Volt's Laboratory, which the installer will automatically download and configure.

* Windows: Launch the program with the _Monkey Hi Hat_ icon from your Start Menu or Desktop
* Linux: Run the `mhh` program in the app directory under your home directory (ie. `cd ~/mhh; ./mhh`)
* You should see a spinning swirly-ball thing -- this is the "idle" shader built into the program:

![image](https://github.com/MV10/monkey-hi-hat/assets/794270/780ab053-8ee3-432c-b2e0-9d8f5322627a)

If your program is running full-screen, press the <kbd>Spacebar</kbd> to switch to windowed mode. The program hides the mouse pointer by default, but the graphical output (not the terminal) must have focus for this to work. Now let's verify you can load the visualizers that were installed with the program. 

With the idle shader still running:

#### Windows
* Launch a console window with the _Monkey Hi Hat Console_ icon from your Start Menu or Desktop
* The console window automatically shows the command-line help; view this any time by running `mhh --help`
* Execute the command `mhh --load warp_speed` ... you should see a "flying through space" visualizer start
* Try applying an effect, execute the command `mhh --load warp_speed rainbow_borders` for a more colorful version
* Finally, start some music and try the playlist command: `mhh --playlist variety`

#### Linux
* Open a terminal window and change to the app directory: `cd ~/mhh`
* To view help at any time, enter the command `./mhh --help`
* Execute the command `./mhh --load warp_speed` ... you should see a "flying through space" visualizer start
* Try applying an effect, execute the command `./mhh --load warp_speed rainbow_borders` for a more colorful version
* Finally, start some music and try the playlist command: `./mhh --playlist variety`

If any of these fail to load, check the console window for error messages, or view the `mhh.log` file in the app directory.

If you have problems, please open a Github [Issue](https://github.com/MV10/monkey-hi-hat/issues) and ask for help.

See the [Using Monkey Hi Hat](using-monkey-hi-hat.md) page for details about real-world usage.

## Hardware Notes

I won't pay much attention to problems with Intel GPUs, particularly laptop-level integrated GPUs. Simply put, Intel's drivers are so buggy they're nearly worthless. This may be a non-issue, because many of them can't handle the required OpenGL API level 4.5. Sad but true. My own laptop, a relatively-new and otherwise excellent Dell XPS13, can barely chug through some of the more basic shaders at just 1920 x 1080. 

On the other hand, my "living room" mini-PC, which is mainly where we use this program, has no problem running most of these at full 2K (which my amplifier then upscales to 4K). That machine is a Minisforum UM790 Pro, which has an excellent AMD Radeon 780M laptop-class GPU.

In short, NVIDIA and AMD GPUs are strongly recommended. If you're having problems, please update your GPU driver before submitting a bug report, especially if the problem is specific to one or a few of the visualizers. For Linux users with NVIDIA GPUs, I found it was necessary to switch to X11 due to driver texture bugs using Wayland.
