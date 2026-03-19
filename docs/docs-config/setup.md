# [setup] Section

The _setup_ section contains general settings that don't warrant separate categories.

## Basic Behaviors

These affect how the application launches and general appearance considerations.

### Standby Mode

By default, the application immediately goes into a graphical display mode. However, it is possible to leave it running in a minimal-overhead standby state where it simply loops waiting for a command.

`StartInStandby` defaults to false. True is useful to auto-launch at startup or login, or for off-hours standby on a dedicated machine. Standby mode is _very_ low-intensity, simply looping and doing nothing, waiting for a command to arrive. 

`CloseToStandby` defaults to false. When true, pressing <kbd>ESC</kbd> or using the [X] close-window button will switch the program to standby mode instead of ending the program.

### Display Control

`StartFullScreen` defaults to true, although the template config sets it to false. When false, you can prepare the app locally (for example, run the playlist command) then manually switch to full-screen by hitting the <kbd>Spacebar</kbd>. It's also useful in windowed mode when creating and testing shaders.

`SizeX` and `SizeY` control the window dimensions in non-full-screen mode. It defaults to 960 x 540 which is a 16:9 ratio that is good for testing. The application doesn't perform any validation of starting size, and Linux window managers may limit or change this.

`StartX` and `StartY` control where the window is positioned in non-full-screen mode. It defaults to 100 x 100. Coordinates on other monitors are in "virtual screen space" relative to the primary monitor. Use the `--display` command to get a list of monitor names, ID numbers, and coordinate rectangles. The application doesn't perform any validation of starting coords, and Linux window managers may limit or change this.

`HideMousePointer` defaults to true, but in windowed mode false is often preferable. It only affects the mouse pointer when it is over the app's display area.

`FullScreenMinimizeOnFocusChange` defaults to true. When false, this allows the use of other application windows on other monitors. (Focus can change to another window on the same monitor, but it still won't overdraw a full-screen Monkey Hi Hat window.) Note some drivers may incur a slight performance penalty with this disabled.

### Communications

The program can be remotely controlled over the local network, most commonly with the Monkey Droid application.

`UnsecuredPort` defaults to 0 (disabled), but the config template sets it to 50001. "Unsecured" in the name is meant as a reminder that it should be exposed to the Internet or other public networks.  This controls the TCP port where the program listens for commands. If you don't know what that means, don't worry about it, this is a safe setting. The official "dynamic" port range is 49152 through 65535; use one of these if port 50001 is used on your system for something else.

## Caching Control

At runtime, Monkey Hi Hat caches many frequently-used items. Generally these aren't that large and you shouldn't need to change these settings, but you can control the size of many of these caches. These are typically LRU (Least Recently Used) caches which means re-use keeps them "fresh".

`ShaderCacheSize` defaults to 150. Use 0 to disable. Note that a cached shader is a reference to a compiled shader program that is stored on the GPU. Visualizer shaders are generally quite small compared to what modern hardware can handle, and realistically most GPU can store thousands before memory becomes an issue.

`FXCacheSize` defaults to 50. Use 0 to disable. Like visualizers, FX shaders are typically small. There are normally fewer of them and they are reused more often, so a separate cache ensures they are not evicted by frequent visualizer changes.

`LibraryCacheSize` defaults to 10. Use 0 to disable. Unlike visualizers and FX, it usually isn't useful to cache a lot of library shaders. They are normally only referenced by a group of related shaders, and once the main shader is compiled and cached, the libraries aren't useful by themselves. Even 10 is likely overkill, usually just one library is actively referenced.

## Performance

`RenderResolutionLimit` defaults to 0 which disables any limitations other than screen resolution in full-screen mode, or the actual window size. This applies a global maximum resolution for render targets. The individual visualizer configuration files can specify their own lower limits. If a visualizer specifies a higher limit, it will be clamped to this global setting.

`FrameRateLimit` defaults to 60 frames per second (FPS). The maximum is 9999, and set to 0 for unlimited. However, many shaders, particularly those derived from Shadertoy, may not work correctly at anything other than 60 FPS.

`VSync` defaults to On. Set it to Off to disable it. This prevents frame updates when the display is refreshing. Some graphics drivers may override this setting. Off is typically more important for gaming because enabling it can introduce brief lags which are more obvious when gaming inputs are in use. It can also be set to Adaptive which disables synchronization only if the framerate drops below the _FrameRateLimit_ setting.

`VideoFlip` defaults to Internal and the other available settings are None and FFmpeg. This controls how (or if) video files are inverted. Most graphic file formats have the origin (pixel 0,0) at the top-left corner, but OpenGL has the origin at the bottom-left corner. Testing seems to indicate Internal is faster than letting FFmpeg handle it. Use None if you're only using custom-made videos that are stored inverted.

## Playback Features

`RandomizeCrossfade` defaults to false, although the template config sets this to true. When false, only the internal crossfade effect is applied. When true, the crossfade directory is searched for shaders and these are applied randomly when transitioning from one visualizer to another. All crossfade shaders are always cached because they are used continuously.

`CrossfadeSeconds` defaults to 2. Set to 0 to disable crossfades. This controls how long the program takes to transition from one visualization to another.

`TestingSkipVizCount` and `TestingSkipFXCount` both default to 0. These are available for historic reasons, the _TestingExcludePaths_ settings in the [linux] and [windows] sections are easier to use. These are typically only useful to shader developers. This lets the test mode skip the visualizers and FX shaders that are in the source repository's TestContent directories, which are normally listed first in the pathspecs. When testing new shaders, you really only want to test against the real content shipped with the final product.

## Logging

Even though some logging is enabled by default, normally the application won't generate any log output at all. However, many settings are available if troubleshooting is necessary. Log files are generated in the application directory. A separate _Logging_ section is available in this documentation in the _Appendix_ area which goes into all the details about how logging works, including the config file settings.

## Audio Features

### Silence Detection

Silence Detection is meant to reduce app workload if the program is left running but the music has stopped (for example, you've switched to regular TV). These are very old settings, these days on a dedicated device, it's probably more useful to put the program into standby mode when it isn't in use.

`DetectSilenceSeconds` defaults to 0, which is disabled. It must be a whole number. This must be disabled for simulated audio to work (see below).

`DetectSilenceMaxRMS` defaults to 1.5 which defines the maximum volume that is treated as silence. This is a side effect of how noisy the computer's audio hardware is. My expensive desktop PC generates the 1.5 value of background noise when no audio is playing, but my $50 Raspberry Pi generates a clean zero.

`DetectSilenceAction` determines what to do when silence is detected. The default is Idle, which switches to the low-overhead idle shader. You can also specify Blank which simply clears the screen.

### Simulated Audio 

Since many visualizers are audio-reactive, they can be pretty boring (or disappear entirely) during long periods of silence. When silence detection is disabled (see above), simulated audio can be used, which generates a synthetic beat to keep audio-reactive visualisers busy. This feature will automatically disable itself when new real audio starts. Typically you won't have to alter these values.

`ReplaceSilenceAfterSeconds` defaults to 0, which disables it. The config file sets this to 2.0 seconds. When audio is continously silent for this long, simulated audio will begin.

`MinimumSilenceSeconds` defaults to 0.25 and is the amount of uninterrupted silence which must occur to qualify as a period of silence. This is essentially the threshold where it starts paying attention to decide if it should replace silence with a synthetic signal.

Currently there is only one type of synthetic data available, so `SyntheticDataAlgorithm` must be `MetronomeBeat`. The other settings relate to the characteristics of the synthetic data: `SyntheticDataBMP` (default 120 is 120 beats per minute), `SyntheticDataBeatDuration` (0.1 seconds), `SyntheticDataBeatFrequency` (default is 440Hz), `SyntheticDataBeatAmplitude` (default is 0.5), and `SyntheticDataMinimumLevel` (default is 0.1).

### Advanced Audio Processing

These settings are passed through to the _eyecandy_ audio processing library which receives the raw audio data from your computer's hardware and turns it into content which Monkey Hi Hat shaders can consume. The values shown are the defaults.

Normally you should not alter these values unless you're writing completely custom shaders.

* `RMSVolumeMilliseconds=300`
* `NormalizeRMSVolumePeak=100`
* `NormalizeFrequencyMagnitudePeak=6500`
* `NormalizeFrequencyDecibelsPeak=90`
* `SampleSize=1024`
* `HistorySize=128`
