# App Configuration

Usually Monkey Hi Hat should work fine immediately after installation. The config file is a plain text file you can read and edit with Notepad, nano, Notepad++, or any other text editor. For my own usage, I only change the three flags mentioned in the [Post-Install Instructions](post-install-instructions.md) section.

However, the application has a fairly large set of settings and options. This section only touches on a few mandatory items and various system options for controlling where configuration comes from. The _Configuration File_ section in this documentation covers _all_ available settings. You can see the config template [here](https://github.com/MV10/monkey-hi-hat/blob/master/mhh/mhh/ConfigFiles/mhh.conf) in the repository.


## Installing Updates

Updates will _completely replace_ the app directory and pre-installed content, only the app directory's `mhh.conf` is preserved and updated. The installer program / scripts will try to update the existing configuration file on both Windows and Linux.

> Updates _**only**_ modify a config file in the default location. If you have alternates, you must maintain those copies by hand. The installed `ConfigFiles` directory contains a current template / default copy of `mhh.conf` you can use for comparison.

You may want to review the config file and the [Changelog](changelog.md) after an update, especially if you're a hands-on type who has made extensive changes.


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

The `UnsecuredPort` option defaults to 0 when the setting is not specified, which disables listening on a network port. However, the provided `mhh.conf` file actually sets this to 50001, which is the default value expected by the [monkey-droid](https://github.com/MV10/monkey-droid) GUI application. Although the name "unsecured" might sound a bit alarming, this is just to remind people that the application should _never_ be exposed to public networks.


## Known Issues

* The Windows `HideConsoleAtStartup` and `HideConsoleInStandby` options don't work correctly with the newer Windows Terminal application. Microsoft has spent several years debating a fix across multiple threads ([latest issue](https://github.com/microsoft/terminal/issues/12464)), so hopefully they'll address this soon. It should work as expected with the old DOS-style `cmd.exe` command prompt window.

* The Linux `HideConsoleAtStartup` and `HideConsoleInStandby` options have not been implemented yet.
