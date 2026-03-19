# [windows] Section

Not surprisingly, this section contains settings which are specific to Windows users. Similar settings exist for both Windows and Linux, and it would be possible to use the same configuration file for multiple systems (for example, use environment variables to point to the config file over the network).

## Paths

Paths adhere to standard Windows syntax rules:

| Consideration | Syntax |
|---|---|
| directory separators | back slash (`\`) |
| search path delimiters | semicolon (`;`) between paths |
| text case | case-insensitive |


### Content Search Paths

Technically the content path settings are search paths -- they can represent multiple paths, each separated by the search path delimiter. At a minimum, you _must_ provide `VisualizerPath`. The template configuration file has comments showing example search paths. Upon initial installation, the correct default paths will be provided. You can add custom locations to these, they are unlikely to be modified by later updates. (You should keep any custom work in a separate directory hierarchy; updates will completely replace the default out-of-box content with new content.)

The various content paths are self-explanatory:

* `VisualizerPath`
* `PlaylistPath`
* `TexturePath`
* `FXPath`
* `CrossfadePath`

### Other Paths

`ScreenshotPath` defines where screenshots are saved. It must be a single path only. If not provided, your user account Desktop directory is used.

`FFmpegPath` is normally the `ffmpeg` directory under the application install directory, and is set during installation.

`LogPath` is blank by default, which puts log files into the application directory (`C:\Program Files\mhh`).

`TestingExcludePaths` is blank by default. Developers use this to list root paths that will be ignored when test mode is used (such as the TestContent directory in the source code repository). When testing new shaders, you really only want to test against the real content shipped with the final product. This is easier to use than the older _TestingSkip*_ count-based settings in the [setup] section.

## Audio Input Settings

The application has excellent built-in support for loopback audio capture on Windows, but OpenAL-Soft is available.

Run Monkey Hi Hat with the _devices_ command to see what the program knows about your audio environment. There is additional information available in the _[DJ / VJ Notes](https://www.monkeyhihat.com/docs/index.php#/dj-and-vj-notes?id=windows-line-level-audio)_ section of the _Appendix_ area of the docs.

`LoopbackApi` is blank by default, which is the same as using WindowsInternal. This is the high-performance Windows Multimedia WASAPI feature. You can also specify OpenALSoft which requires installing and configuring a separate loopback driver and OpenAL library DLLs (not recommended). You can also set this to SyntheticData if you want a sine wave signal to use as test data.

`OpenALContextDeviceName` defaults to blank for WASAPI. For OpenALSoft, leave it blank to auto-select the system's default audio context, or specify an _exact_ context name.

`CaptureDeviceName` defaults to blank for WASAP. Specify an _exact_ devicename for WASAPI line-in or microphone input. For OpenALSoft, blank auto-selects the system's default audio device, or specify an _exact_ device name.

## Display Media Track Info

This controls the display of on-screen track information from the audio source. 

Currently Windows only supports the native Spotify client, but work is in progress to leverage Windows Media Controller (WMC).

`ShowSpotifyTrackPopups` defaults to true. When false, no media data will be available.

## Spout Texture Streaming

Spout is a Windows system used by DJs and VJs for sharing images with other applications running on the same PC.

These settings are defined in the _[DJ / VJ Notes](https://www.monkeyhihat.com/docs/index.php#/dj-and-vj-notes?id=spout-support)_ section of the _Appendix_ area of the docs.

## Environment Settings

These are miscellaneous settings relating to the general OS environment.

`HideConsoleAtStartup` defaults to false. This is not working due to Microsoft's indecision about how to address visibility with the new tabbed Terminal interface, but it should control whether or not the console is visible at all for automated startup purposes (launching from the Start menu, auto-start at login, etc).

`HideConsoleInStandby` defaults to true, but like the other hide option, it is not currently functional.
