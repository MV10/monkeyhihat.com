# Linux Quick-Start

## Setup and Requirements

For the moment, installation on Linux is a slightly manual process. (I am trying to learn how to build .deb packages but the documentation is awful and the process is complex.) However, the steps are simple:

* Install dependencies
* Download and run the `install.sh` script

The program requires:

* A modern video card (or integrated GPU) that supports OpenGL API 4.5 (most non-Intel GPUs are OK)
* .NET 8 runtime or SDK
* FFmpeg
* Recommended: Monkey-Droid GUI (alas, only available for Windows or Android)
* Alternately: Terminal on a second screen, or another machine with SSH access
* For content creators: GLSL editor or IDE extension (JetBrains Rider has one that's not terrible)

And of course, you will need a source of music such as Spotify, an MP3 player, Soundcloud, etc. Spotify has a decent native Linux client ([download](https://www.spotify.com/de-en/download/linux/)) which has the benefit that it allows remote-control of music playing through your PC from any other client on the same network -- such as your phone or a laptop.


## Dependency Installation

Install the latest .NET version 8 runtime package from Microsoft (or if you're a .NET developer, the SDK works just as well). You will have to add their package source ([instructions](https://learn.microsoft.com/en-us/dotnet/core/install/linux)). Using Debian as an example, once you have packaging configured, you would run:

```bash
sudo apt-get install -y dotnet-runtime-8.0
```

For Debian-based distributions, an official FFmpeg package exists:

```
sudo apt-get install -y ffmpeg
```

You should also have `unzip` installed (most modern distros already have it).


## Application Installation

Download the `install.sh` script from the Releases page, make it executable, and run it in your home directory:

```
cd ~
chmod +x install.sh
./install.sh
```

It will download some archive files, create some directories, and expand the content into them. Then it will set up your config file and create launcher links (ie. a `.desktop` file). At that point the program should be ready to use!

The application and config installs into `~/monkeyhihat` and the content files are in `~/mhh-content`.

If you already have Monkey Hi Hat installed, I do provide an `update.sh` script, but all it really does is overwrites the app and content directories with updated files. The Windows installer tries to update the config file, but Linux support is in the early stages and that functionality isn't available yet (sorry). You should consult the wiki's changelog and manually add any new settings (I'd _strongly_ recommend copying the comments and the settings to the same location as the template). Each release includes a `~/monkeyhihat/ConfigFiles/mhh.conf` template configuration explaining all available options.


## Using Monkey Hi Hat

The wiki documentation home page has a basic first-time walk-through, but usage is simple: open a terminal, change to the install directory, and run `./mhh`. This loads the low-overhead "idle" visualizer. To send commands to the running instance, open another terminal window, change to the install directory, and run `./mhh --help` to see the command-line switches. If you're using the sample content, start up some music and run the command `./mhh --playlist variety`.

The program window recognizes several keyboard commands. Two of them are:

* `ESC` ends the program
* `→` loads the next playlist visualizer (right-arrow)

If you didn't change anything, at this point the program is running in a window. You can resize or maximize that window, but you probably want to open the `mhh.conf` configuration file and change the `StartFullScreen` setting to `true`. But then, unless you have multiple monitors, it won't be easy to use a local terminal to send commands, and if you're running it remotely (for example, in your AV stack outputting to your TV), you don't want to be chained to the keyboard.

This is where remote control comes into play, which is covered in the next section.


## Remote Control: Monkey-Droid GUI

Android users (or users with a Windows PC) can install [Monkey Droid](https://github.com/MV10/monkey-droid), a simple dedicated GUI application for controlling monkey-hi-hat running on another computer. The Windows `msix` or the Android `apk` install packages are available on this repo's [release](https://github.com/MV10/monkey-hi-hat/releases/) page. The Monkey Droid application has minor UI bugs (thanks to .NET 7's MAUI being released prematurely) but I plan to rewrite it in 2026.

The Monkey Hi Hat `mhh.conf` config file includes an `UnsecuredPort` setting. By default, port 50001 will be used, but you can use any open port you wish. The official TCP custom or "dynamic" port range is 49152 to 65535, which is your safest bet for avoiding collisions with other things running on your system.

Start Monkey Hi Hat, then launch Monkey Droid on the device of your choosing. Hit the &plus;`Add` button at the top right of the Server List page. Enter the name of the computer where Monkey Hi Hat is running, enter the port number, and hit the `Save` button. After returning to the Server List page, choose the server you just defined, and choose the `Use` option from the pop-up. (You can also try the `Test` option just to verify network connectivity.)

Once a server is selected, you'll be sent to the Playlist page. It's initially empty, so ask the server what playlists are available: Hit the &olarr;`Refresh` button at the top right of the page. If you're using the content provided in the [Volts Laboratory](https://github.com/MV10/volts-laboratory) repo, you'll see at least one playlist named `variety`. Select that and Monkey Hi Hat will load and use that playlist.

The Visualizer tab works similarly. It's initially empty, so hit the &olarr;`Refresh` button at the top right. You can use this page to jump to any specific visualizer (shader). Note this will terminate the playlist, if one is active. Initially each entry will not have a description loaded. A background thread will read visualizer descriptions and whether or not they are audio-reactive (indicated by a music note icon).

The other tabs are self-explanatory. You can issue the other standard Monkey Hi Hat commands, or issue commands manually (which is useful for Monkey Hi Hat commands that haven't been added to Monkey Droid yet).

You can also control Monkey Hi Hat from an SSH terminal, which relies on named pipes instead of TCP network connections. Refer to the directions in the last section of this page for more details.


## Remote Control: Terminal / SSH

If you have two monitors, probably the easiest remote control option is to just run a terminal on the other display, change to the MHH directory, and issue your `./mhh` commands from there. This would work on a desktop, but it isn't very practical for large "headless" configurations like running it on a living room TV from a PC isolated in an AV closet.

Since you probably want to run Monkey Hi Hat full screen, and you might want to control it from your couch with a tablet, your phone, a laptop, or some other separate device, I recommend setting up SSH (Secure Shell). Typically if your distro doesn't already include OpenSSH, you need only request it from your packaging system.

Linux PCs will usually support the ssh client app out of the box. Windows PCs commonly download the PuTTY terminal app. I also run [ConnectBot](https://play.google.com/store/apps/details?id=org.connectbot) on my Android phone. It's a little bit buggy, but it's free, it's actively maintained, and it doesn't harangue you with bullshit ads that you'll never intentionally click on.


## For Content Creators: GLSL Editor

If you want to create or modify the visualization shaders, it's _extremely_ useful to have an editor that "speaks" GLSL, the OpenGL Shader Language. There are probably plugins for popular editors like Notepad++ or (shudder) Visual Studio Code, and if you use the real Visual Studio, I strongly recommend Daniel Scherzer's [GLSL language integration](https://marketplace.visualstudio.com/items?itemName=DanielScherzer.GLSL2022) extension. JetBrains Rider also has a passable GLSL plugin available.

It's a pretty nice workflow to run Monkey Hi Hat on another monitor or off to the side in a window, and use a real IDE to modify the shader, then just issue an `./mhh --reload` command to immediately see the results.


## About Linux Support

In version 4.3.1, I dropped Linux support. The interest wasn't there and I didn't think I'd ever personally care much about it.

Fast forward to late 2025 and I have to admit Microsoft is now routinely trashing Windows and even [bricking hardware](https://www.techpowerup.com/340032/microsoft-windows-11-24h2-update-may-cause-ssd-failures). I no longer feel safe depending on them, which is big coming from me, I have relied on MS in one form or another for nearly 50 years. On top of recent _mistakes_, adding fuel to the fire are the forced updates which have caused me (and everyone else) no end of trouble, incessant advertising trash which is annoying and offensive, the corporate ransomware known as OneDrive, piss-poor performance even on expensive modern hardware, and their disdain for the country that made their company what it is. (In the couple of months since I wrote all of that, they also managed to break the Start Menu, File Explorer, the lock screen, and all of Windows 10 with the "final" update. Staggering incompetence.)

Thus, I have fully migrated to Linux (Debian and KDE) as my full-time desktop OS, and I will only run Windows in a VM. I even gave up Visual Studio (and the endless AI slop) in favor of JetBrains Rider, but of course I need to test and debug on Windows (necessitating _very_ painful VM configuration hassles to support GPU passthrough).

_It might finally be The Year of Linux._

(If you weren't a computer dork in the 90s / early 2000s, you probably won't get the joke.)
