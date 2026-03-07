# Linux Quick-Start

## Setup and Requirements

For the moment, installation on Linux is a slightly manual process. (I am trying to learn how to build .deb packages but the documentation is awful and the process is complex.) However, the steps are simple:

* Install dependencies
* Download and run the `install.sh` script

Of course, you will need a source of music such as Spotify, an MP3 player, Soundcloud, or whatever else you prefer. Spotify has a decent native Linux client ([download](https://www.spotify.com/de-en/download/linux/)) which has the benefit that it allows remote-control of music playing through your PC from any other client on the same network -- such as your phone or a laptop.

## Dependency Installation

The dependencies are:
 
* .NET runtime
* FFmpeg

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

If you already have Monkey Hi Hat installed, I do provide an `update.sh` script, but all it really does is overwrites the app and content directories with updated files. The Windows installer tries to update the config file, but Linux support is in the early stages and that functionality isn't available yet (sorry). You should consult the [Changelog](changelog.md) and manually add any new settings (I'd _strongly_ recommend copying the comments and the settings to the same location as the template). Each release includes a `~/monkeyhihat/ConfigFiles/mhh.conf` template configuration explaining all available options.


## Using Monkey Hi Hat

The Introduction page has a short walk-through for testing your initial setup, but for more details and options, refer to the [Using Monkey Hi Hat](using-monkey-hi-hat.md) section to proceed.


## About Linux Support

In version 4.3.1, I dropped Linux support. The interest wasn't there and I didn't think I'd ever personally care much about it.

Fast forward to late 2025 and I have to admit Microsoft is now routinely trashing Windows and even [bricking hardware](https://www.techpowerup.com/340032/microsoft-windows-11-24h2-update-may-cause-ssd-failures). I no longer feel safe depending on them, which is big coming from me, I have relied on MS in one form or another for nearly 50 years. On top of recent _mistakes_, adding fuel to the fire are the forced updates which have caused me (and everyone else) no end of trouble, incessant advertising trash which is annoying and offensive, the corporate ransomware known as OneDrive, piss-poor performance even on expensive modern hardware, and their disdain for the country that made their company what it is. (In the couple of months since I wrote all of that, they also managed to break the Start Menu, File Explorer, the lock screen, and all of Windows 10 with the "final" update. Staggering incompetence.)

Thus, I have fully migrated to Linux (Debian and KDE) as my full-time desktop OS, and I will only run Windows in a VM. I even gave up Visual Studio (and the endless AI slop) in favor of JetBrains Rider, but of course I need to test and debug on Windows (necessitating _very_ painful VM configuration hassles to support GPU passthrough).

_It might finally be The Year of Linux._

(If you weren't a computer dork in the 90s / early 2000s, you probably won't get the joke.)
