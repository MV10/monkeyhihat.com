# Creating Visualizations

> See my January 2024 [Tutorial](https://mcguirev10.com/2024/01/20/monkey-hi-hat-getting-started-tutorial.html) ... it is a little bit outdated now, but all of the basics are still relevant.

## Concepts

A basic monkey-hi-hat visualization consists of three files:

* the visualization configuration file (`.conf`)
* an OpenGL vertex shader source code file (`.vert`)
* an OpenGL fragment shader source code file (`.frag`)

The visualization configuration file does the following:

* provides a friendly description (name, credits, etc.)
* identifies the names of the vert and frag shader source files
* determines what data is sent to the shaders
* identifies how vertex data is represented (Vertex Source Type)
* determines what Audio Texture data is provided to the shaders

In addition to the basic visualizer, version 2.0 introduced multipass visualizers, and version 3.0 introduced texture support, multipass backbuffer support, and function library support. These all use the same file types, but the multipass configurations define a _sequence_ of visualizer objects, shaders, and buffers. The output or "draw" buffers from earlier passes can be used as input textures to later passes, allowing you to create elaborate effects. As of version 3.0, a multipass visualizer can also reference the buffers from the _previous frame_ which allows very complex time-based effects.

Refer to the _Visualization Configuration_ section for detailed information about the file format and available settings. This page describes the process at a more conceptual level.

## Visualizer Types (Vertex Source Type)

Currently there are two available types of visualizers, which correspond to their Vertex Source Type. (In earlier versions, these were called Visualizer Type, which is somewhat misleading as to their purpose.)

* `VertexQuad` is designed for visualizers that are focused on fragment shaders (like Shadertoy). The vertex data is two simple triangles extending between the corners of the screen to form a quad which covers the entire display area.
* `VertexIntegerArray` is designed for visualizers that are focused on abstract vertex shaders (like those found on VertexShaderArt). The vertex data doesn't describe anything specific. Instead, an array of sequential integers is passed to the vertex shader, and the code uses math to position, size, and color the output vertices. Several drawing modes are available (points, triangles, etc).
* You can specify a `.vert` and `.frag` shader for either of these, but typically `VertexQuad` is only used with fragment shaders, and `VertexIntegerArray` is only used with vertex shaders, so if you omit the other shader file, a default pass-through shader is provided automatically.

## Audio Texture Types

Monkey-hi-hat supports seven Audio Textures provided by eyecandy:

* `AudioTextureVolumeHistory`
* `AudioTextureWaveHistory`
* `AudioTextureFrequencyMagnitudeHistory`
* `AudioTextureFrequencyDecibelHistory`
* `AudioTextureShadertoy`
* `AudioTexture4ChannelHistory`
* `AudioTextureWebAudioHistory`

Refer to the _Understanding Audio Textures_ section more details about what these are and how they're used to create audio-reactive visualizations.

## GPUs Are Not Identical

The _Introduction_ page mentions I don't intend to support Intel's integrated GPUs, but even AMD and NVIDIA have their hardware and driver quirks. For example, consider zguerrero's Shadertoy creation [SlowMo Fluid](https://www.shadertoy.com/view/ltdGDn), which is the basis for the _splash_ FX used by monkey-hi-hat. The following screenshots are from Shadertoy in the browser, but the monkey-hi-hat FX exhibits the exact same behavior.

> UPDATE 2025-AUG-13: Shadertoy user morimea (aka danilw on Github) pointed out this isn't actually an AMD bug and many NVIDIA GPUs exhibit the same behavior. It is the sin-hash function itself which is unreliable, as noted on his Github [README](https://github.com/danilw/GPU-sin-hash-stability), and documented further in his Medium [article](https://arugl.medium.com/hash-noise-in-gpu-shaders-210188ac3a3e). The rest of this section is as I wrote it originally in 2023, and two years later people are still using the broken hash, so it's worth being aware of.

This is how it looks on my primary desktop with a dedicated NVIDIA RTX-2060 GPU:

![image](images/random-nvidia.png)

But when I run it on the living room TV's miniPC, which uses an integrated AMD Radeon 780M, it only ever generates two big, uninteresting bubbles (and another user on Shadertoy reported his Mac M1 GPU produces the same incorrect results):

![image](images/random-amd.png)

Bear in mind that Shadertoy can't generate random numbers, so they _should_ be identical. Why does this happen? I suspect a roundoff or similar numeric issue with this function, which is a standard way of generating a pseudo-random number (it isn't actually random in any sense, it's just "large and unexpected" -- but always the same):

```glsl
float hash(float n)
{
   return fract(sin(dot(vec2(n,n) ,vec2(12.9898,78.233))) * 43758.5453);  
}  
```

For what it's worth, this exact calculation (and the occasional minor variation, like `vec2(n, -n)`) shows up in [many](https://gist.github.com/PossiblyAShrub/42f446bc2956c3d1800da7f5e111086e#file-donut-txt-L26) other [places](https://jaksa.wordpress.com/2014/09/02/writing-a-parallel-sort-on-glsl-heroku-com/) all across the web, it isn't something specific to Shadertoy. In fact, it is also in other Monkey Hi Hat FX and visualizations where it _does_ work properly. I spent a lot of time searching and I have no idea where it came from originally. (It seems to be related to the [xorshift](https://en.wikipedia.org/wiki/Xorshift) algorithm and its variants, but not exactly the same.)

The fix, incidentally, was to reference a noise-texture rather than the calculation. Then both NVIDIA and AMD GPUs showed the same behaviors.

The Shadertoy user FabriceNeyret2 has some older articles on his [Shadertoy Unofficial](https://shadertoyunofficial.wordpress.com/) blog that are worth reading. In particular, he describes a lot of bugs and compatibility issues that sound similar to the _SlowMo Fluid_ example above in his 2016 article [Compatibility Issues in Shadertoy WebGLSL](https://shadertoyunofficial.wordpress.com/2016/07/22/compatibility-issues-in-shadertoy-webglsl/) (and obviously I think they probably apply outside the context of WebGL).

Github user danilw also maintains a very large and detailed list of [GPU bugs](https://github.com/danilw/GPU-my-list-of-bugs), including this specific hash function problem (which is really a problem with the `sin` implementation).

## Workflow for Conversion

If you want to adapt an existing Shadertoy or VertexShaderArt example, the Volt's Laboratory repository (and the archive included with each app release) has template files for each. Since Shadertoy is frag-shader-oriented, there is a template `.conf` and `.frag` file. Similarly, because VertexShaderArt is vert-shader-oriented, there is a template `.conf` and `.vert` file. Adapting these to monkey-hi-hat is very nearly a fill-in-the-blanks process.

Comments in the template files should help you, and of course, Volt's Laboratory has many examples you can use as a reference. For more details, refer to the _Shader Basics_ section which explains the available shader uniforms, and how these map to Shadertoy and VertexShaderArt.

### Workflow for Custom Creations

The best workflow is probably an iterative process. Set up your files, load monkey-hi-hat and get some music going, disable caching with the `--nocache` command, and make small changes. Issue a `--reload` command whenever you make a change and see what the results are. I strongly recommend Gregg Man's VertexShaderArt [tutorial](https://www.youtube.com/@vertexshaderart8178/videos) videos for a nice introduction to this iterative process. It's also helpful to understand the unique integer-input approach used by `VertexIntegerArray` shaders.

But before you begin, you have to decide the _style_ of visualization you wish to create.

At present, you have four options:
* a fragment-only shader which works like Shadertoy
* a vertex-only integer-input shader which works like VertexShaderArt
* a hybrid vertex/fragment shader using integer inputs like VertexShaderArt
* an advanced multi-pass / multi-buffer visualization

If you're interested in the first two, start from the appropriate template in Volt's Laboratory.

The third option is where things start to get interesting. Although your vertex shader must still depend on a series of sequential integers as inputs, the outputs are vertex coordinates, colors, and possibly point sizes or even filled triangles. The pixels covered by this stage are then fed into the fragment shader where you can alter the results however you like. Audio Texture data can be used by either or both shaders. The vertex shader could use volume data, while the fragment shader might use Decibel frequency data. It's up to you.

The fourth option is relatively complicated, but can produce some very interesting results. The repository's `TestContent` directory has an [example](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/multipass.conf) of a multi-pass visualizer you can study that uses three buffers and five shaders.

From there, the workflow is the same -- make changes, send a `--reload` command to see the results, and keep at it until you like what you see.

Note that it can be handy to use the configuration file's multiple-path feature. You could store off-the-shelf repository visualizations in one directory hierarchy (or even on your network), your completed custom content in another directory hierarchy, and your works-in-progress in a third location. Refer to the _App Configuration_ section for more information.
