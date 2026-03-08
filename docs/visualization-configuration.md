# Visualization Configuration

## Purpose

The visualization configuration tells monkey-hi-hat what kind of data to send to the shaders, what kind of audio textures are used (if any), and where to find the vertex and shader files. There are many examples in my [Volt's Laboratory](https://github.com/MV10/volts-laboratory/tree/master/shaders) repository, and I'll be adding to those over time.

## The [shader] Section

* `Description` A line of text with the name of the visualization, and anything else you'd like to add such as the author's name or a URL (remember, no hashtags, that signifies the beginning of a comment). The [monkey-droid]() GUI control app will read and show these descriptions.

* `VertexSourceTypeName` This controls how data is fed to the shaders. Currently two built-in types are supported: `VertexQuad` and `VertexIntegerArray`. See _Creating Visualizations_ for more information about these.

* `VertexShaderFilename` and `FragmentShaderFilename` are the names of the vert and frag shaders. They must be in the same directory as the `.conf` file. If one or the other is omitted, a pass-through default is provided automatically.

* `BackgroundFloatRGB` is the background color the buffer is cleared to before each frame is rendered. This is more important with `VertexIntegerArray` because the output doesn't typically cover the entire screen, unlike `VertexQuad` which is full-coverage by definition. As the name suggests, the red, green, and blue color components must be normalized floats (values 0 to 1).

* `RenderResolutionLimit` is disabled by default (value 0), but it allows you to apply a maximum resolution to the rendered output, which will then be upscaled to full-screen. This is useful for heavy-overhead shaders (like cloud_tunnel) that can't sustain smooth frame rates at larger sizes.

* `FXResolutionLimit` is disabled by default (value 0). It allows you to apply a maximum rendering resolution when a post-processing FX is active. The FX configuration must also set the `ApplyPrimaryResolutionLimit` flag, indicating the FX is high-overhead, otherwise this value is not used. When the program is cross-fading between two visualizations, this value is also applied if it is defined, regardless of whether any FX is running.

* `RandomTimeOffset` is disabled by default (value 0). It will add or subtract a randomly-generated offset to the `time` uniform passed to shaders. This is useful when a shader is highly time-dependent, but produces very different output over time. Note that some shaders need to "seed" their drawing buffers for the first few passes. If they rely on `time` for this, you may be able to convert them to use the `frame` count instead (especially if you have defined a frame-rate target).

* `RandomTextureSync` is false by default. When true, if random texture selection is used (one uniform used for multiple textures), then the same texture index is used for all randomized textures. This is most useful for synchronizing texture masks. (See the [Starship FX](https://github.com/MV10/volts-laboratory/blob/master/fx/starship.conf) for an example of this.)

## The [VertexIntegerArray] Section

Vertex Source Types can have their own custom settings. The section name matches the Visualizer Type Name.

Currently only `VertexIntegerArray` has additional settings:

* `VertexIntegerCount` defines the size and content of the integer array passed to the vertex shader. This must be a 32-bit integer value, so the visualizer can request one thousand, ten thousand, a million, or any other number of values. Typically, very high values aren't that useful, and the VertexShaderArt website limits users to a maximum value of 100,000.

* `ArrayDrawingMode` defines how the output vertices are drawn. These are defined by OpenGL (visual [examples](https://webglfundamentals.org/webgl/lessons/webgl-points-lines-triangles.html)):
  * `Points`
  * `Lines`
  * `LineStrip`
  * `LineLoop`
  * `Triangles`
  * `TriangleStrip`
  * `TriangleFan`

## The [AudioTextures] Section

If the visualizer is audio-responsive, this section lists the uniform names of audio textures that will be used by the shaders. Unlike the first version, you _must_ use these pre-defined uniform names in this file and in your shaders. See [Understanding Audio Textures](understanding-audio-textures.md) for more details, but the available types and names are:

  | AudioTexture typename | Fixed uniform name |
  |---|---|
  | AudioTextureWaveHistory | eyecandyWave |
  | AudioTextureFrequencyDecibelHistory | eyecandyFreqDB |
  | AudioTextureFrequencyMagnitudeHistory | eyecandyFreqMag |
  | AudioTextureWebAudioHistory | eyecandyWebAudio |
  | AudioTextureShadertoy | eyecandyShadertoy |
  | AudioTexture4ChannelHistory | eyecandy4Channel |
  | AudioTextureVolumeHistory | eyecandyVolume |

As of version 2.0, it is no longer necessary to consider or manage OpenGL `TextureUnit` assignments. Also, the `[AudioTextureMultipliers]` section is obsolete. You should apply any boost/cut multipliers in the shader code, or as custom uniforms in the visualizer configuration file (see below).

## The [Uniforms] Section

Custom fixed-value or random-value `float` uniforms can be defined. These are passed to all shaders used by the visualizer. The format is `uniform=value` or `uniform=min:max`. Randomized uniforms are generated each time the config file is loaded, and will remain fixed during that specific run.

Note that due to mathematical quirks of the IEEE `double` data type, the true maximum value will always be very slightly smaller than the requested value (specifically, 0.0000000004656612875245796924106 less... likely irrelevant for visualization purposes).

See also [Shader Basics](shader-basics.md) for a complete list of other uniforms provided by the program such as `time` and `frame` and various random numbers.

## The [Textures] Section

It's common for shaders to reference a static image as input data. These can be loaded into memory and provided to all shaders as `sampler2D` uniforms. The format is `uniform:filename.ext` and all texture paths defined in `mhh.conf` will be searched. As of v3.1.1, the program can randomly select a texture. Specify the same uniform name multiple times with a different texture filename on each line.

The image-loading library (StbImageSharp) supports the JPG, PNG, BMP, TGA, PSD, GIF and HDR formats, although I have only tested with JPG and PNG files.

The Volt's Laboratory archive file provided with each release includes the textures available at the Shadertoy website.

## The [Videos] Section

As of version 4.3.0, the program can load any video that FFmpeg is able to play (I have only tested with h.264-encoded MP4 files, and the OGV and WEBM files from Shadertoy). Audio is not supported. These are specified the same way image textures are defined, with `uniform:filename.ext` entries, and if the same uniform name is listed multiple times the program will choose a video at random.

In addition to the requested uniform name, the program will generate three more uniforms by adding `_duration`, `_progress` and `_resolution` suffixes to the specified uniform name. Duration is a `float` representing the total length of the video. Progress is a normalized (0 to 1) value indicating the current playback position. Resolution is a `vec2` representing the width and height of the video data.

Generally you want VERY small, low bitrate videos. Like image textures, you should let the shader do the work of upscaling and manipulating. The Volt's Laboratory archive file includes three sample videos in the texture directory, and these are only 640x360 at 30FPS. Some of the videos offered on the Shadertoy website are even smaller than that. (I no longer ship those, they simply weren't interesting from a music visualizer standpoint, but you can download them with links provided [here](https://shadertoyunofficial.wordpress.com/2019/07/23/shadertoy-media-files/) if you want them.)

The basic FFmpeg libraries are installed in an `ffmpeg` directory inside the app install directory. Here is an FFmpeg command you can use to re-encode `input.mp4` as `output.mp4` with a lower resolution, 30 FPS, a 349k bit-rate, and stripping all audio data. (Other file types would require different switches.)

```
ffmpeg -i input.mp4 -r 30 -vf scale=640:360 -an -c:v libx264 -preset medium -b:v 349k output.mp4
```

Note also the `VideoFlip` setting in the `[setup]` section of the `mhh.conf` application configuration file. Most file formats have the origin (pixel 0,0) at the top left corner, but OpenGL's origin is at the bottom left. The options for this setting are `Internal` (which seems to perform best in my testing), `FFmpeg` which flips the buffer during decoding (surprising this is slower!), or `None` if you only use custom videos that are saved inverted (super fast!), or you write your own shaders that invert the Y coordinate for texel fetch (`1.0 - resolution.y`). You could also use `None` if you only use abstract videos and you don't care if they're inverted or not.

## The [FX-Blacklist] Section

The post-processing FX shaders sometimes don't work well with certain visualizations, so this section lets a visualizer list the names of any FX shaders that should never be applied. It's just a simple list of the FX config filenames.

A future release will allow you to specify `*` which blocks _all_ FX processing. This is useful for visualizations that should only be loaded with specific FX shaders (and never without), since playlists and the command-line can specify a visualizer / FX combination directly.

## Advanced: The [MultiPass] Section

Instead of drawing directly to the OpenGL swap-buffers, a multi-pass shader draws to internally-managed framebuffers. A previously-used framebuffer's texture can be used as input to later passes. Each "pass" consists of another visualizer input object and a pair of vertex and fragment shader files. Other than actually writing the shaders, your main task is to figure out the sequence of buffer usage to produce the desired effect. The buffer numbers are zero-based and should increase sequentially. Skipping numbers or trying to use buffer numbers as inputs that haven't been defined yet will prevent the visualizer from loading.

Each entry under the `[multipass]` section header defines an additional rendering pass (or "draw call" in OpenGL terminology). The final draw buffer is then automatically copied to OpenGL's internal "back buffer" then swapped to the screen. Each pass is defined by four to six space-separated columns:

| # | Content | Description |
| --- | --- | --- |
| 1 | draw buffer | A single zero-based integer |
| 2 | input buffers | An asterisk indicating none, or a comma-separated list of previously-used draw buffers |
| 3 | vertex | The name of a vertex shader source file, or asterisk to use the one in the `[shader]` section |
| 4 | fragment | The name of a fragment shader source file, or asterisk to use the one in the `[shader]` section |
| 5 | vertex source | Optional; blank, or `VertexIntegerArray` or `VertexQuad` |
| 6 | settings | Only required for `VertexIntegerArray` (specifies vertex count and draw mode, see below) |

For more complex passes, it is possible to specify visualizer `.conf` files instead of shaders and vertex types:

| # | Content | Description |
| --- | --- | --- |
| 1 | draw buffer | A single zero-based integer |
| 2 | input buffers | An asterisk indicating none, or a comma-separated list of previously-used draw buffers |
| 3 | viz.conf | The name of a visualizer `.conf` file, or asterisk to use the "main" visualizer file |

### Draw-Buffer Numbers

Buffers are just single numbers. You can draw to the same buffer multiple times within the visualizer, although you can't _simultaneously_ use the same one to draw and as an input on any single pass. Unless you specify a `RenderResolutionLimit`, remember that each buffer is the size and color-depth of your display area, so if you're rendering something like 32bpp at 2K, these will add up quickly (not to mention overhead allocating them, shuffling them around, and so on). Also bear in mind that during the transition to a new visualizer, _both_ visualizers and all their buffers will be allocated, as well as two additional buffers used by the crossfade shader. It isn't hard to imagine a high-res display rapidly depleting GPU memory, so reusing buffers is a smart optimization.

### Input-Buffer Numbers

The texture of any draw buffer used in a previous pass can be specified in a comma-delimited list. The uniforms are always named `input0`, `input1` and so on, where the number at the end matches the buffer number. So if the pass specifies `1,3` the shader will receive textures in uniforms named `input1` and `input3`. If no inputs are required (commonly on the first pass), use an asterisk in this column.

The repository's test-content [multipass](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/multipass.conf) visualizer is an example of this (it is the same as the *oil_slick* visualization content from Volt's Laboratory).

### Input-Buffer Letters

The final texture of any draw buffer from the _previous_ frame can be specified in a comma-delimited list along with the numeric input buffers (numeric buffers refer to the buffer contents from the _current_ frame). The program refers to previous-frame content as "back-buffers" although that's a bit different than what back/front buffer normally means. So front- or draw-buffer 0 corresponds to back-buffer A, and 1 is B, 2 is C, and so on. Their uniform names will be `inputA`, `inputB` and so on.

Unlike Shadertoy buffers, the contents of the back-buffers is fixed throughout the frame. This is actually _increased_ flexibility. Shadertoy buffers only temporarily have access to the previous frame's data -- new output overwrites that data and it isn't available to later passes in the frame. This will be discussed more in the _Shader Basics_ section.

The repository's test-content [doublebuffer](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/doublebuffer.conf) visualizer is an example of this (it is the same as the _darkstar_ visualization in Volt's Laboratory and the visualizer archive provided in the release downloads).

### Render-Pass Visualizer Config Files

For the simplified multipass definition, provide the names of complete visualizer `.conf` files. The repository's test-content [mpvizconf](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/mpvizconf.conf) visualizer is an example of this. Use an asterisk in this column to use the main (initial) visualizer configuration where the multipass is defined.

If a visualizer config is defined, no additional columns are required or allowed.

### Vertex and Fragment Shader Source Files

This is pretty self-explanatory -- provide the names of shader files. The paths defined in the `mhh.conf` configuration will be searched. The `.vert` and `.frag` extensions are optional and will be added if needed. To use the shader files defined in the `[shader]` section, use an asterisk in either or both columns. This is common for the first pass where the basic visualizer's shader filenames are both used.

### Vertex Source Type Name and Settings

These columns are optional. If blank, the pass will re-use the vertex source defined in the basic `[shader]` section. Otherwise either of the available vertex sources can be declared: `VertexIntegerArray` or `VertexQuad`.

The settings column is **_required_** when `VertexIntegerArray` is used since it is currently the only vertex source that accepts settings. The column should not exist for a `VertexQuad` source. The settings entry must specify both `VertexIntegerCount:[value]` and `ArrayDrawingMode:[value]` separated by a semicolon. See the earlier sections above for details about those settings. The column should look like this:

```
VertexIntegerCount:1000;ArrayDrawingMode:Triangles
```


