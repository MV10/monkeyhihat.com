# Post-Processing FX

## Concepts

Post-processing (referred to as "FX" here and throughout the program) is simply another form of multi-pass rendering which uses the output from a visualization as an input texture. Like visualizers, FX uses a `.conf` configuration file format, requires `.frag` shader source code files, and these files must be stored in one of the paths listed in the application's `FXPath` setting.

You can think of FX as additional multi-pass stages added to an existing visualization, which is referred to as the "primary" visualization. You should therefore read and understand how multi-pass visualizations work (see the _Visualization Configuration_ wiki topic). In fact, the FX configuration files have a `[multipass]` section, but the first pass must always be draw-buffer 1 because draw-buffer 0 is automatically reserved for the primary visualization the FX is operating on. FX passes only support `VertexQuad`-style fragment shaders.

FX can be added explicitly via the `--load` command or a playlist configuration file, or they can be applied randomly by the playlist manager.

## The [FX] Section

* `Description` A line of text with the name of the visualization, and anything else you'd like to add such as the author's name or a URL (remember, no hashtags, that signifies the beginning of a comment). The [monkey-droid]() GUI control app will read and show these descriptions.

* `RenderResolutionLimit` is disabled by default (value 0), but it allows you to apply a maximum resolution to the rendered output, which will then be upscaled to full-screen. This is useful for heavy-overhead shaders that can't sustain smooth frame rates at larger sizes.

* `ApplyPrimaryResolutionLimit` is false by default. High-overhead effects can set this to true. If the primary renderer is also high-overhead and has defined an `FXResolutionLimit` value, the primary will change to render at that resolution. It has no effect if the primary doesn't specify a resolution limit for post-processing effects.

* `Crossfade` defaults to true, and controls whether the FX is applied immediately, or is faded in over a period of time. It uses the application's `CrossfadeSeconds` setting. If that is zero, FX crossfade is disabled regardless of this setting.

## The [MultiPass] Section

The multi-pass section is a simplified version of that used by visualizations. The Draw-Buffer and Input-Buffer columns are the same, except that buffer 0 is always assigned to the primary visualization and must never be specified. See the _Visualization Configuration_ wiki topic for details about the Draw-Buffer and Input-Buffer columns.

The third column must be the name of a fragment shader (the `.frag` extension is optional). The built-in pass-through vertex shader is always used.

## Other Sections

FX configurations can also specify `[uniforms]`, `[textures]`, `[videos]`, `[audiotextures]` and `[libraries]` sections. These work exactly the same way as the same sections do in visualizer configuration files. See the _Visualization Configuration_ wiki topic for details.

## Advanced: Option Uniforms

This describes _visualizer_ settings which relate to a specific post-processing FX.

An FX shader can expose uniforms which are meant to be configured by the visualizer to which the FX is applied. The informal standard is to prefix the uniform name with `option_` and provide a default value. Like other config-driven uniforms, they must be `float` values. For example, let's assume an FX named _snazzy_ lists these declarations in `snazzy.frag`:

```glsl
uniform float option_mix_percentage = 0.15;
uniform float option_time_factor = 0.2;
```

Any visualization .conf can add a `[fx-uniforms:filename]` section, where `filename` reflects the FX that exposes those option uniforms. The entries in that section work just like a regular `[uniforms]` section ... either `name=float` for a specific value, or `name=float:float` for a randomized range. We assumed the example above was declared by an FX named _snazzy_, so any visualizer could adjust those options like this:

```ini
[fx-uniforms:snazzy]
option_mix_percentage = 0.25
option_time_factor = 0.15:0.35
```
