# App Configuration

Usually Monkey Hi Hat should work fine immediately after installation. For my own usage, I only change the three flags mentioned in the [Post-Install Instructions](post-install-instructions.md) section.

However, the application has a fairly large set of settings and options. This section only touches on a few mandatory items and various system options for controlling where configuration comes from. All of the config settings are heavily documented by comments in the config file itself You can see the config template [here](https://github.com/MV10/monkey-hi-hat/blob/master/mhh/mhh/ConfigFiles/mhh.conf) in the repository.


## Config File Locations

The default location is the application's top-level directory.

> If you DO NOT use the Windows installer or the Linux install script, for example, you built the app from source, you should manually copy `mhh.conf` from the `ConfigFiles` template directory to the appropriate directory.

If you need multiple configuration files, create an environment variable (named `monkey-hi-hat-config` on Windows, or `MONKEY_HI_HAT_CONFIG` on Linux) set to the complete pathname of the active configuration file, which can be stored anywhere the application can access. If the environment variable exists, this is the first location the program checks for a file. This is most commonly used for supporting development scenarios, but advanced DJ / VJ and other pro / semi-pro users might also benefit from this (for example, supporting different NDI sources in studio-equipment environments).

The config file path search sequence is:

* The environment variable
* The default location
* The app directory's `ConfigFile` template path

> If the program tries to load from the template directory, note that the `ConfigFiles\mhh.conf` template is not usable "out of the box" since it doesn't point to your content files. Installation and update will not modify that copy of the file. See _Required Path Settings_ below for details. This is mostly a legacy feature from early versions without installer update capability.

You may notice `mhh.debug.conf` in the app's `ConfigFiles` template directory. You can disregard this, as the name suggests, it's for developer usage. The contents may change at any time, it's mostly uncommented, and it may reference unreleased features. It is loaded when a debugger is attached (ie. running the program from Visual Studio) and my dev machines reference it by environment variable. It gets installed simply because it's part of the code repository for my convenience and safekeeping.


## Installing Updates

Updates will _completely replace_ the app directory and pre-installed content, only the `mhh.conf` is preserved / updated.

The installer will try to update the existing configuration file on Windows. Config update isn't available for Linux yet, but I'm working on it. Meanwhile you'll have to check the [Changelog](changelog.md) and add any new comments / settings manually.

> The Windows installer _**only**_ modifies a config file in the default location. If you have alternates, you must maintain those copies by hand. The installed `ConfigFiles` directory contains a current template / default copy of `mhh.conf` you can use for comparison.

You may want to review the config file after an update, especially if you're a hands-on type who has made extensive changes.


## Required Path Settings

The installers will set these paths for you. For manual installation, or to add custom content, set the path values listed below under the `[windows]` and/or `[linux]` sections at the end of the config file.

* `VisualizerPath`
* `PlaylistPath`
* `TexturePath`
* `FXPath`
* `CrossfadePath`
* `FFmpegPath`
* `ScreenshotPath` (optional)

You can also list multiple paths separated by a semicolon (`;`) on Windows or a colon (`:`) on Linux. If you use the Volt's Laboratory content distributed with the program on the release page, you should specify a shared library path after the visualizer, FX, and crossfade paths. The pre-installed content shares general-purpose shader library files.

For Windows, the default content location is: `C:\Program Data\mhh-content`, and the FFmpeg binaries are downloaded into your app directory during installation.

For Linux, the default content location is: `~/mhh-content` and the FFmpeg binaries are assumed to be in the standard `/usr/lib` location.


## Other Settings

The config file is a plain text file you can read and edit with Notepad, nano, Notepad++, or any other text editor.

Comments in the [`mhh.conf`](https://github.com/MV10/monkey-hi-hat/blob/master/mhh/mhh/ConfigFiles/mhh.conf) file documents all currently-available settings. It is reasonably self-explanatory, but generally it contains things like file locations, startup modes, and audio device information.

The `UnsecuredPort` option defaults to 0 when the setting is not specified, which disables listening on a network port. However, the provided `mhh.conf` file actually sets this to 50001, which is the default value expected by the [monkey-droid](https://github.com/MV10/monkey-droid) GUI application. Although the name "unsecured" might sound a bit alarming, this is just to remind people that the application should _never_ be exposed to public networks.


## Known Issues

* The Windows `HideConsoleAtStartup` and `HideConsoleInStandby` options don't work correctly with the newer Windows Terminal application. Microsoft has spent several years debating a fix across multiple threads ([latest issue](https://github.com/microsoft/terminal/issues/12464)), so hopefully they'll address this soon. It should work as expected with the old DOS-style `cmd.exe` command prompt window.

* The Linux `HideConsoleAtStartup` and `HideConsoleInStandby` options have not been implemented yet.
