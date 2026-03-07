# Changelog

#### v5.2.0 2025-12-07
* Full Linux support (testing on Debian 13 / KDE Plasma 6)
* Linux option to check for X11 (NVIDIA has problems with Wayland)
* Configuration changes in `mhh.conf`
  * Added `[linux]` section 
  * Fixed typo: migrate `NDIRecieveInvert` to `NDIReceiveInvert`
  * Removed `[windows]` comment about not supporting Linux
  * Add `[windows]` `OpenALContextDeviceName`
  * Add `[windows]` note about `SyntheticData` for `LoopbackApi`
* Maps Linux `~` path segment to `$HOME` directory 
* Isolated OS-specific interop features into dedicated classes
* Linux-legal environment var `MONKEY_HI_HAT_CONFIG` (Windows uses `monkey-hi-hat-config`)
* Implemented `--devices` switch for Linux to list audio devices and media players
* Linux line-in / mic-in confirmed working
* Reads Linux media player info ([DBus MPRIS](https://github.com/tmds/Tmds.DBus))
* Added Linux NDI send/receive support
* Dev config for JetBrains Rider Linux IDE
  * Added .NET Framework 4.7.2 Reference Assemblies to build install.exe
  * Replaced `IWshRuntimeLibrary` with COM-interop `ShellLinkObject`
  * Defined Windows/Linux mhh publish-to-folder profiles (`.run` directory)
* Dedicated site for installer content ([monkeyhihat.com](https://monkeyhihat.com))
* Show app version at startup
* Crossfade-tester bugfixes
* Removed Windows NDI 32 bit DLL
* Created release-packaging scripts (see packaging/README)
* Allows content versioning to lag app release versioning


#### v5.1.0 2025-10-29
* Added streaming texture control switches:
  * `--streaming status`
  * `--streaming send spout|ndi "sender name" ["spout_group_list"]`
  * `--streaming receive spout "sender name"`
  * `--streaming receive ndi "machine (sender name)"`
  * `--streaming stop send|receive`
* Added `SpoutReceiveFrom` and `NDIReceiveFrom` to config file
* Added `SpoutReceiveInvert` and `NDIReceiveInvert` to config file
* Prevent receiving from both Spout and NDI at the same time
* Added `[streaming]` section to viz / fx (see _TestContent\streaming.conf_)
* Added dedicated `CrossfadePath` to config, created new directory in content repo
* Removed requirement for "crossfade" prefix for crossfades in dedicated path
* Added _badtexture.jpg_ to `InternalShaders` to replace missing textures
* Spout receiver scaling added
* Populates the eyecandy OpenGL error logging app context object
* Added config `OpenGLErrorLogging` for controlling OpenGL error detail-level
* Added config `OpenGLErrorThrottle` for time-suppression of duplicate log entries
* Added config `OpenGLErrorBreakpoint` for triggering debugger breakpoints
* Fixed texture release bug in `SimpleRenderer`

#### v5.0.0 2025-10-05
* Added [NDI](https://ndi.video/tools/) and [Spout](https://github.com/leadedge/Spout2) streaming video output for DJ / VJ and video production pipelines
* Added mic / line-in support (use `CaptureDeviceName` in config with WASAPI to use a specific device)
* Added `--devices` switch to list WASAPI device names (OpenALSoft not currently supported)
* Updated to eyecandy 4.2.0 (shader cubemap uniform support, WASAPI capture device control)
* Add cubemap support for viz/fx (new `[cubemaps]` section just like `[textures]`)
* Viz/FX `RandomTextureSync` true/false; filename counts must match
* Added "Starship" FX demonstrating `RandomTextureSync` (image/mask texture-matching)
* Improve edge-case startup exception reporting of fatal socket errors (ie. socket-in-use)
* Migrated all code to file-level namespaces
* Removed unused `CaptureDriverName` setting

#### v4.5.0 2025-08-27
* Updated to eyecandy v4.0.0 (logging improvements)
* Updated to CommandLineSwitchPipe v2.0.0 (logging improvements)
* Updated to FFMediaToolkit v4.8.0 (cleaner release of some managed resources)
* Change internal video frame-flip to use StbImage instead of C# loop, ~30% faster
* Vertically flip screenshots (duh)
* Set focus after spacebar-to-screenshot `--jpg wait` and `--png wait` commands
* Improved some video processing error messages
* Tested background-thread video decode; too much locking overhead required
* Eyecandy changes to avoid re-allocation of texture buffers
* Added `ScreenshotPath` to `mhh.conf` (defaults to user's Desktop if no path is provided)
* Logging improvements (log categories, better output control)
* Added `LogCategories` to `mhh.conf` listing categories to include; all others filtered out
* Wiki "Appendix: Logging" section lists available log categories and how to configure

#### v4.4.0 2025-08-17
* Fixed `FXActive` uniform during crossfades
* Added video-clip-based "ghostly" FX (Volt's Laboratory repo)
* Added additional variants on the "costume" video clip (Volt's Laboratory repo)
* Added `silent` uniform (float 0/1) to notify shaders that the engine is detecting silence
* Updated to eyecandy v3.3.0 with synthetic silence-replacement data (see [changelog](https://github.com/MV10/eyecandy/wiki/5.-Changelog))
* New `LoopbackApi=SyntheticData` option available in `[windows]` section of mhh.conf
* Added mhh.conf settings relating to silence-replacement / synthetic data:
  * `MinimumSilenceSeconds` - default 0.25, duration before "silence" is flagged
  * `ReplaceSilenceAfterSeconds` - default 2.0, applies if `DetectSilence` is true
  * `SyntheticAlgorithm` - currently only `MetronomeBeat` is available
  * `SyntheticDataBPM` - default is 120
  * `SyntheticDataBeatDuration` - default is 0.1 seconds
  * `SyntheticDataBeatFrequency` - default is 440 Hz
  * `SyntheticDataAmplitude` - default is 0.5, range is 0.0 to 1.0
  * `SyntheticDataMinimumLevel` - default is 0.1f, base volume level

#### v4.3.1 2025-08-06
* Updated to eyecandy v3.2.0 with improved/expanded error handling and logging
* Added mhh.conf `HideWindowBorder` setting to control window frame style when not in full-screen mode
* Added `--paths` switch to list configured content paths (visualizations, FX, textures, playlists)
* Added Trace-level logging to diagnose user's `FramebufferIncompleteAttachment` [issue](https://github.com/MV10/monkey-hi-hat/issues/5)
* Bugfix in `GLResourceManager.ResizeTexture` copy operation
* Removed Linux support

#### v4.3.0 2025-08-05
* Add Windows video playback support (no audio support planned); experimental due to performance concerns
* Add `FFmpegPath` to `[windows]` section of `mhh.conf`
* Add `VideoFlip` to `[setup]` section of `mhh.conf` (default `Internal`; other options are `FFmpeg` or `None`)
* Distribute ffmpeg binaries via the installer (new `ffmpeg` subdirectory in app install directory)
* Add `[video]` section in viz/FX config files (same rules as `[textures]` section)
* Video-specific uniforms (appends `_duration`, `_progress`, `_resolution` to video uniform name)
* Add sample MP4 files to the Volt's Laboratory textures directory (royalty-free)
    * Pixabay.com [dancer.mp4](https://pixabay.com/videos/woman-model-dancing-silhouette-vj-185787/)
    * Pexels.com [traffic.mp4](https://www.pexels.com/video/time-lapse-of-traffic-in-the-city-26690703/)
    * MixKit.co [costume.mp4](https://mixkit.co/free-stock-video/terrifying-performance-of-a-woman-in-disguise-44230/)
* Add Shadertoy video files to the Volt's Laboratory textures directory
    * Shadertoy LustreCreme.ogv
    * Shadertoy Britney.webm
    * Shadertoy VanDamme.webm
    * Shadertoy GoogleChrome.ogv
* Moved all texture support into renderer classes (removed from `IVertexSource` classes which caused duplication)
* Updated to eyecandy v3.1.0 with improved background thread synchronization for frequent texture updates (ie. video)
* Added experimental Co-Pilot guidance document (not impressed so far...)

#### v4.2.1 2025-06-12
* Only accept the `--help` switch if no other instances are running

#### v4.2.0 2025-05-28
* Multi-monitor support:
    * Config window starting position (`StartX` and `StartY`)
    * In full-screen mode the `Enter` key advances to the next monitor
    * Added `--display` command to report window and monitor info
* Added `fxactive` uniform (float 0/1) to notify viz shaders that post-processing FX is active
* Altered chaos_columns viz to hide the sphere when `fxactive` is true (float 1.0)
* Startup / standby shows PID and TCP port
* Updated to eyecandy 3.0.2 (dependency updates, no features)

#### v4.1.1 2024-11-06
* Default `StartFullScreen` config to false, which is easier for first-time users
* Change `VertexIntegerArray` settings on `[multipass]` to use `:` instead of `=`
* Add uniform `vec4 randomrun4` which provides four additional random numbers
* Add `--fade file` to queue the next crossfade shader (filename prefix `crossfade_` is optional)
* Playlist viz entries can begin with `>file` identifying crossfade to use (filename prefix optional)
* Add `X` keystroke to extend playlist auto-advance timer by 1 minute (cumulative)
* Add `A` keystroke to pause playlist auto-advance timer (use right-arrow or `--next` to resume)
* Visualizer playlist `SwitchTimeHint=Half` bug fixed
* Updated to eyecandy 3.0.1 (minor debug logging changes to Shader constructor)

#### v4.0.0 2024-02-01
* Eliminated the need for a Windows loopback audio driver (!)
* New stand-alone executable installer / updater / uninstall, no more PowerShell shenanigans!
* TCP relay support (via monkey-see-monkey-do) is deployed with the app
* Reverted to OpenGL 4.5 due to Linux MESA drivers (no 4.6 features are needed by MHH)
* Updated to eyecandy 3.0.0 (released 2024-01-27)
* Reset uniform default values for each render pass
* Viz / FX texture randomization by repeating a uniform name with different filenames
* Crossfade renderer now supports randomized transition shaders
* Added setting `RandomizeCrossfade=true` in `mhh.conf` (default is false)
* For writing crossfade shaders, see comments in Volt's `libraries\crossfade_simple.frag`
* Add `--test [viz|fx|fade] [name]` switch and `--endtest` switch
* Test mode uses +/- to cycle through content using the named testing target
* Test mode disables viz/FX caching, and shows a text overlay with test target info
* Add `TestingSkipVizCount` and `TestingSkipFXCount` to `mhh.conf` (used during MHH dev)
* Add config `LoopbackApi` to `[windows]` section, `WindowsInternal` is default, can be `OpenALSoft`

#### v3.1.0 2023-12-03
* Migrated to .NET 8.0
* Bug fixes via eyecandy v2.0.6 and OpenTK v4.8.2
* Added `u` uninstall switch to installer script
* The Shadertoy PCM wave texture is now 0.0 to 1.0 (silence is 0.5)
* Many viz content improvements and additions via Volt's Laboratory
* Internal font rendering support
* Added a `[text]` settings section to the `mhh.conf` app config file
* Added informational text overlays and crossfading popup notifications
* Added `--show [viz|stats]` switches shows text overlay for 10 seconds
* Added `--show [popups|what]` to toggle viz/fx playlist popup notifications or show the popup
* Added `--show [toggle|clear]` to make text overlays permanent and clear anything shown
* Added `--show track` to show Spotify track info (if available; currently Windows-only)
* Added `--show grid` to display 100 x 15 characters for adjusting text settings
* Added <kbd>V</kbd> to show visualization overlay (viz, fx, playlist, descriptions)
* Added <kbd>S</kbd> to show stats overlay (frame rate, resolution, etc.)
* Added <kbd><</kbd> to toggle text overlay timed / permanent mode (really <kbd>,</kbd> / comma)
* Added <kbd>></kbd> to immediately clear any current text overlay (really <kbd>.</kbd> / period)
* Added <kbd>G</kbd> to display the text grid test pattern
* Added <kbd>P</kbd> to toggle viz/fx playlist popup notifications
* Added <kbd>W</kbd> to immediately show a viz/fx playlist popup notifications
* Added <kbd>T</kbd> to immediately show Spotify track info (if available; currently Windows-only)
* Undocumented `--show debug` option and <kbd>D</kbd> key; content varies
* Added <kbd>Bksp</kbd> to save JPG snapshot to user Desktop (Windows) or app directory (Linux)
* Added `ShowSpotifyTrackPopups` to `[windows]` section of `mhh.conf`
* Added `UnsecuredRelayPort` to `mhh.conf` for the (not yet released) Monkey-See-Monkey-Do launcher/relay service
* Window is not visible until the first frame is rendered (prevents a white flicker at startup)
* Added `FullscreenMinimizeOnFocusChange` in `mhh.conf` to allow using windows on other monitors

#### v3.0.0 2023-10-20
##### _Major Features_
* Post-processing FX shaders
* Image texture loading (jpg, png, etc)
* Double-buffering for multipass shaders (exposes framebuffers from previous frame)
* Reusable function library shaders
* New uniforms and custom uniforms
* Many new commands
* Install / Uninstall script

##### _App Config & Commands_
* `mhh.conf` is now in the `ConfigFiles` directory to prevent overwrites when unzipping updates
* Fallback environment variable `monkey-hi-hat-config` can point to an app config file anywhere
* Apply default 60 FPS target, controlled by `FrameRateLimit` in `mhh.conf` (0 is unlimited, may break some shaders)
* Added optional framerate target value to `--fps` command (0=disabled, max=9999)
* Added `VSync` to `mhh.conf`, default is `Off`, can be `On` or `Adaptive` (on if framedrop drops below half of target FPS)
* Added `TexturePath` to `mhh.conf` for external image files
* Added `--fullscreen` command (toggle)
* Added `RenderResolutionLimit` to global and visualizer configurations (minimum 256, default is 0 to disable)
    * Moved `resolution` uniform to renderers since buffered output may not match output resolution
    * Renderers own/control the buffer when needed (when output resolution exceeds defined limit)
    * Crossfade no longer allocates buffers unless the renderers actually need them
* Changed `IVisualizer` interface to `IVertexSource` and implmentations to `VertexIntegerArray` and `VertexQuad`
* Command line `--load [viz] [fx]` to immediately apply an FX to a newly loaded visualization
* Added `StartInStandby` to `mhh.conf` for startup/login launching
* Added `CloseToStandby` to `mhh.conf` for manual window-closing (<kbd>ESC</kbd> key or title-bar <kbd>X</kbd> button)
* `HideConsoleAtStartup`, `HideConsoleInStandby` in `[windows]` section ([issue](https://github.com/microsoft/terminal/issues/12464) _minimizes_ Win11 Terminal)
* `--standby` command toggles standby mode (intended for remote calls)
* `--console` command toggles console visibility (Windows only)
* The `--load` and `--playlist` commands will trigger a "wake up" from standby mode
* Add `FXCacheSize` and cache FX shaders separately from visualizers, default is 50
* Increase default `ShaderCacheSize` to 150 (viz shaders are generally small)
* Added `LibraryCacheSize` to `mhh.conf` (default is 10)
* Cache sizes can be set to 0 in `mhh.conf` to disable caching altogether
* Added `--nocache` to disable shader caching for the session (good for testing)
* Added `--jpg` and `--png` for screenshots (Win: desktop, Linux: app path); `wait` flag watches for <kbd>Spacebar</kbd>

##### _Visualizer Configs_
* Added `[textures]` section to visualizer .conf files (`uniform:filename.ext`, `uniform!` is `ClampToEdge` wrap-mode)
* Added `[libraries]` section to viz and FX .conf files (see test content `vertint`, `vertquad`, `multipass`, and `mpvizconf1`)
* Simplified visualizer shader config (uses internal passthrough if filename omitted or * is used)
* Added `RandomTimeOffset` to viz.conf, randomly starts elapsed time at 0 to X seconds. Default is zero. Can be negative.
* Viz.conf `[playlist]` section `SwitchTimeHint` (None, Half, Double, DoubleFX), `FXAddStartPercent` (+/- to 50%/sec)
* Viz.conf `[fx-blacklist]` section lists FX files to never apply to the visualizer

##### _Multipass & Post-Processing FX_
* Added multipass support for referencing viz.conf files instead of shaders and vert source types/args
* Added multipass A-Z double-buffering (previous frame's data; allows Shadertoy-style multipass)
* Defined FX config format (see repo `testcontent/fx/snapclock.conf` for details)
* Added `--fx [fx.conf]` command
* Added `--list fx` command
* Added `[textures]` support to FX.conf files

##### _Playlists_
* Added playlist settings `FXPercent` and `FXDelaySeconds`, and `[FX]` section
* Playlist `--next fx` command applies FX immediately, even if one wasn't queued
* Playlist `InstantFXPercent` for immediate application of FX to the next visualization
* Playlist support for visualizer names followed by a specific immediately-applied FX name

##### _Shader Uniforms_
* Custom `[uniform]` definitions in visualizer and FX .conf files (`name=float` or `name=float:float` to randomize)
* Visualizer FX-options support via `[FX-uniforms:filename]` sections (see TestContent FX `option_uniforms` and viz `vertint`)
* Added always-available uniforms:
    * `frame` - frame count float for the current visualizer (0-based)
    * `date` - vec4 year, month, date, seconds since midnight (like Shadertoy iDate)
    * `clocktime` - vec4 hour, minute, seconds, utc hour
    * `randomseed` - normalized float (0-1) randomly generated at program startup
    * `randomrun` - normalized float (0-1) randomly generated at visualization startup
    * `randomnumber` - normalized float (0-1) randomly generated for each new frame
    * Note the true maximum is _very_ slightly less than 1: https://stackoverflow.com/a/52439575/152997

##### _Miscellaneous & Internal_
* Changed to a more interesting internal idle-mode shader
* Added better config file validations for basics like pathspec formatting and availability
* Added `Const` class for solution-wide constants like `StringSplitOptions`
* Added dependency on StbImageSharp for loading image texture files
* Trace-level Dispose logging (async disposal _completely_ incompatible with OpenGL/OpenAL!)
* Use the `mhh` namespace globally (subdivisions were pointless)
* Discontinued use of murmur3 hashing for shader cache keyes; too many collisions
* Moved parsing of complex `[multipass]` section to a separate `MultipassParser` class
* Added `FXRenderer` and generalized `MultipassSectionParser`
* Added internal `passthrough` frag/vert shaders
* Changed buffers to wrap mode
* Decouple from window `ClientSize`, wait for `OnResize` events to stop; for Windows, `OnWindowUpdate` suspends
* Added crossfade support to FX activation
* Changed resource owner names to include class name and object creation timestamp to simplify debugging
* Significantly enhanced `--info` output

#### v2.0.0 2023-09-07
* Requires x64 architecture
* Multipass visualizer support (including config [Multipass] section)
* Crossfade for visualizer changes w/ option for immediate switch
* Always load all eyecandy audio textures and assign required uniform names
  | AudioTexture typename | Fixed uniform name |
  |---|---|
  | AudioTextureWaveHistory | eyecandyWave |
  | AudioTextureFrequencyDecibelHistory | eyecandyFreqDB |
  | AudioTextureFrequencyMagnitudeHistory | eyecandyFreqMag |
  | AudioTextureWebAudioHistory | eyecandyWebAudio |
  | AudioTextureShadertoy | eyecandyShadertoy |
  | AudioTexture4ChannelHistory | eyecandy4Channel |
  | AudioTextureVolumeHistory | eyecandyVolume |
* Created `RenderManager` to centralize future visualizer complexity
* Create `PlaylistManager` to simplify the `HostWindow` codebase
* Removed OpenGL ES support (which also means no Raspberry Pi support)
* Minimum OpenGL API version is 4.6
* Set `EnableCap.ProgramPointSize` to support old-style `gl_PointSize`
* Upgraded to eyecandy v2.0.0 with automatic `TextureUnit` assignments
* Added shader caching (the `--reload` command forces a cache update)
* Discontinue use of `Shader` reference in `eyecandy.BaseWindow`
* Added Dispose-aware threadsafe LRU cache
* Added murmur3 x64 128-bit hash keygen
* Moved built-in viz.conf out of AppConfig and into Caching
* Removed all audio texture requirements from visualizer .conf files
* Removed `--viz` command support
* Better Dispose coverage for GL objects
* Implemented GLResourceManager to gen/delete framebuffers, textures, TextureUnits, etc.
* Added `CrossfadeSeconds` to application configuration
* Moved `time` uniform into the individual renderers for smoother transitions
* Use `VisualizerPath` in `mhh.conf` instead of `ShaderPath`
* Updated internal shaders and volt-lab shaders with `#version 460` directives

#### v1.2.0 2023-09-02
* _**Final version to support ARM32HF / Raspberry Pi 4B / OpenGL ES**_
* Shader `resolution` uniform changed to `ClientSize` (viewport area); was `Size` (total window area)
* Multiple search-path support (platform specific delimiters: Windows uses semicolons, Linux uses colons)
* Support platform-specific path separators
* Load separate configuration file during VS debug (mhh.debug.conf)
* Updated to eyecandy v1.1.82 (fixes OpenAL error at program exit)
* Updated to CommandLineSwitchPipe v1.1.2
* Embedded a legit icon, fancy!
* Call GC.SuppressFinalizer on Dispose methods (just in case)

#### v1.1.0 2023-08-26
* Changes to support the [monkey-droid](https://github.com/MV10/monkey-droid) GUI control application
* Updated to CommandLineSwitchPipe v1.1.1 with TCP network support
* Added `UnsecuredPort` to `mhh.conf` for TCP network support (disabled by default)
* Added the monkey-droid `--md.list` switch to retrieve lists of playlist and visualizer files
* Added the monkey-droid `--md.detail` switch to retrieve visualizer detail data
* Added monkey-droid Windows `msix` and Android `apk` install packages to the release page

#### v1.0.0 2023-08-05
* Initial release 🍰 
