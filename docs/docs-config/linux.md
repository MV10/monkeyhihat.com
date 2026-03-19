# [linux] Section

Not surprisingly, this section contains settings which are specific to Linux users. Similar settings exist for both Windows and Linux, and it would be possible to use the same configuration file for multiple systems (for example, use environment variables to point to the config file over the network).

## Paths

Paths adhere to standard Linux syntax rules:

| Consideration | Syntax |
|---|---|
| directory separators | forward slash (`/`) |
| search path delimiters | colon (`:`) between paths |
| text case | case-sensitive |
| home directory | tilde (`~`) recognized |


### Content Search Paths

Technically the content path settings are search paths -- they can represent multiple paths, each separated by the search path delimiter. At a minimum, you _must_ provide `VisualizerPath`. The template configuration file has comments showing example search paths. Upon initial installation, the correct default paths will be provided. You can add custom locations to these, they are unlikely to be modified by later updates. (You should keep any custom work in a separate directory hierarchy; updates will completely replace the default out-of-box content with new content.)

The various content paths are self-explanatory:

* `VisualizerPath`
* `PlaylistPath`
* `TexturePath`
* `FXPath`
* `CrossfadePath`

### Other Paths

`ScreenshotPath` defines where screenshots are saved. It must be a single path only. If not provided, your user account Desktop directory is used, if present.

`FFmpegPath` defaults to `/usr/lib/x86_64-linux-gnu` which should work for most systems.

`LogPath` is blank by default, which puts log files into the application directory (`~/monkeyhihat`).

`TestingExcludePaths` is blank by default. Developers use this to list root paths that will be ignored when test mode is used (such as the TestContent directory in the source code repository). When testing new shaders, you really only want to test against the real content shipped with the final product. This is easier to use than the older _TestingSkip*_ count-based settings in the [setup] section.

## Audio Input Settings

Linux relies on OpenAL-Soft to capture loopback audio data. Some Linux systems work out of the box, others require configuration of various audio components such as ALC, Pulse, and PipeWire to make loopback work correctly. Those settings are highly specific to your distro, hardware and drivers, and software environment, and are beyond the scope of this documentation.

Run Monkey Hi Hat with the _devices_ command to see what the program knows about your audio environment. There is additional information available in the _[DJ / VJ Notes](https://www.monkeyhihat.com/docs/index.php#/dj-and-vj-notes?id=linux-line-level-audio)_ in the _Appendix_ area of the docs.

`LoopbackApi` defaults to OpenALSoft which is the only supported capture option for Linux. You can also set this to SyntheticData if you want a sine wave signal to use as test data.

`OpenALContextDeviceName` defaults to blank, which auto-selects the system's default audio context. You can also specify an _exact_ context name.

`CaptureDeviceName` defaults to blank, which auto-selects the system's default audio device. You can also specify an _exact_ device name.

## Display Media Track Info

These settings relate to the display of on-screen track information from the audio source, such as Spotify, a web browser, MP3 players, and so on.

`ShowMediaPopups` defaults to true. This uses the DBus MPRIS standard to collect media details and detect media events like a track change. When false, no media data will be available.

`MediaServiceName` defaults to blank, which automatically selects the first media-player application that is actually outputting sound. In this mode it will not detect if the app stops and some other app begins playing audio. You can often guess the DBus MPRIS app name (such as "spotify" or "juke"), but if you play audio, then run "mhh --devices", it will list all of the currently registered media-player apps. Some apps add things to their service name such as the Brave browser, which uses names like "brave.instance1234". Use an asterisk suffix to find these, such as "brave*". If more than one matches, the service with status "Playing" is chosen. If no specific service is set, the first "Playing" service is used, and if none are active the first "Paused" service is used. If all services are "Stopped" the first service is chosen.

## Environment Settings

These are miscellaneous settings relating to the general OS environment.

`SkipX11Check` defaults to false. Some video drivers (particularly NVidia) have problems with Wayland and require X11. When true, the program will not test the `XDG_SESSION_TYPE` variable for the value `X11`.

`HideConsoleAtStartup` defaults to false. This is not working due to Wayland restrictions, but it should control whether or not the console is visible at all for automated startup purposes (using a launcher, auto-start at login, etc).

`HideConsoleInStandby` defaults to true, but like the other hide option, it is not currently functional.
