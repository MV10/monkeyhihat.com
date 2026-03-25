# Creating Visualizations

> See my January 2024 [Tutorial](https://mcguirev10.com/2024/01/20/monkey-hi-hat-getting-started-tutorial.html) ... it is a little bit outdated now, but all of the basics are still relevant.

A visualization is an OpenGL shader. Writing shaders is a very complex topic which is far beyond the scope of this documentation. The [Shader Basics](shader-basics.md) page links to a few tutorials which might help anyone new to the topic. This section assumes you have a basic familiarity with shaders.

## Core Elements

A basic Monkey Hi Hat visualization consists of three files:

* the visualization configuration file (`.conf`)
* an OpenGL vertex shader source code file (`.vert`)
* an OpenGL fragment shader source code file (`.frag`)

The visualization configuration file does the following:

* provides a friendly description (name, credits, etc.)
* identifies the names of the vert and frag shader source files
* determines what data is sent to the shaders
* identifies how vertex data is represented (Vertex Source Type)
* determines what Audio Texture data is provided to the shaders

The config file supports other settings, too. Refer to the _Visualization Configuration_ section for detailed information about the file format and available settings. This page describes the process at a more conceptual level.

In addition to basic visualizers, version 2.0 introduced multipass visualizers, and version 3.0 introduced textures, multipass backbuffers, and function libraries. These all use the same file types, but the multipass configurations define a _sequence_ of visualizer shaders and buffers. The output or "draw" buffers from earlier passes can be used as input textures to later passes, allowing you to create elaborate effects. As of version 3.0, a multipass visualizer can also reference the buffers from the _previous frame_ which allows very complex time-based effects.

### Visualizer Types (Vertex Source Type)

Currently there are two very different types of visualizers available. Each corresponds to their Vertex Source Type:

* `VertexQuad` is designed for visualizers that are focused on fragment shaders (like Shadertoy). The vertex data is two simple triangles extending between the corners of the screen to form a quad which covers the entire display area.
* `VertexIntegerArray` is designed for visualizers that are focused on abstract vertex shaders (like those found on VertexShaderArt). The vertex data doesn't describe anything specific. Instead, an array of sequential integers is passed to the vertex shader, and the code uses math to position, size, and color the output vertices. Several drawing modes are available (points, triangles, etc). 

You can specify both a `.vert` and `.frag` shader for these, but typically `VertexQuad` is only used with fragment shaders, and `VertexIntegerArray` is only used with vertex shaders, so if you omit the other shader file, a default pass-through shader is provided automatically.

### Audio Texture Types

Monkey Hi Hat supports seven Audio Textures provided by eyecandy:

* `AudioTextureVolumeHistory`
* `AudioTextureWaveHistory`
* `AudioTextureFrequencyMagnitudeHistory`
* `AudioTextureFrequencyDecibelHistory`
* `AudioTextureShadertoy`
* `AudioTexture4ChannelHistory`
* `AudioTextureWebAudioHistory`

Refer to the [Understanding Audio Textures](understanding-audio-textures.md) page for details about what these are and how they're used to create audio-reactive visualizations.

## Preparation

When you install Monkey Hi Hat, it also installs a bunch of visualization shaders and FX and textures and so on. You should store any custom content _separately_ from those items, because when you update the program, those pre-installed things will be _completely replaced_ by removing the default locations and re-creating them from scratch.

Choose a location for your top-level directory where custom content will be stored. Let's assume it's a directory named `monkeyshine`. For Windows users, we'll assume this is off your main drive, so `C:\monkeyshine` and for Linux users we'll assume it's in your home directory, so `~/monkeyshine`. Inside that directory create six additional directories:

```
   📁 monkeyshine
   ┣━━📁 crossfades
   ┣━━📁 fx
   ┣━━📁 libraries
   ┣━━📁 playlists
   ┣━━📁 shaders
   ┗━━📁 textures 
```

You will have to add these to your configuration file so that the program can find them.

### Windows

Use Notepad and open `C:\Program Files\mhh\mhh.conf`, then scroll down to the `[windows]` section near the bottom.

You will see five path settings like this. The path separator on Windows is the semicolon (`;`), as you can see in the `VisualizerPath` setting below. You will add a separator to these settings and add your new directories.

```
# location of visualizer conf and shader vert/frag files
VisualizerPath=C:\ProgramData\mhh-content\shaders;C:\ProgramData\mhh-content\libraries

# location of playlist conf files
PlaylistPath=C:\ProgramData\mhh-content\playlists

# location of graphics files
TexturePath=C:\ProgramData\mhh-content\textures

# location of post-processing FX conf and shader vert/frag files
FXPath=C:\ProgramData\mhh-content\fx;C:\ProgramData\mhh-content\libraries

# location of crossfade shader frag files
CrossfadePath=C:\ProgramData\mhh-content\crossfades
```

Using the example directory structure shown earlier, your settings would become:

```
# location of visualizer conf and shader vert/frag files                              ↓ new content starts here
VisualizerPath=C:\ProgramData\mhh-content\shaders;C:\ProgramData\mhh-content\libraries;C:\monkeyshine\shaders;C:\monkeyshine\libraries

# location of playlist conf files                ↓ new content starts here
PlaylistPath=C:\ProgramData\mhh-content\playlists;C:\monkeyshine\playlists

# location of graphics files                   ↓ new content starts here
TexturePath=C:\ProgramData\mhh-content\textures;C:\monkeyshine\textures

# location of post-processing FX conf and shader vert/frag files         ↓ new content starts here
FXPath=C:\ProgramData\mhh-content\fx;C:\ProgramData\mhh-content\libraries;C:\monkeyshine\fx;C:\monkeyshine\libraries

# location of crossfade shader frag files          ↓ new content starts here
CrossfadePath=C:\ProgramData\mhh-content\crossfades;C:\monkeyshine\crossfades
```

And that's it -- the program will find anything you create.

### Linux

Use text editor like nano or Kate and open `~/monkeyhihat/mhh.conf`, then scroll down to the `[linux]` section.

You will see five path settings like this. The path separator on Linux is the colon (`:`), as you can see in the `VisualizerPath` setting below. You will add a separator to these settings and add your new directories.

```
# location of visualizer conf and shader vert/frag files
VisualizerPath=~/mhh-content/shaders:~/mhh-content/libraries

# location of playlist conf files
PlaylistPath=~/mhh-content/playlists

# location of graphics files
TexturePath=~/mhh-content/textures

# location of post-processing FX conf and shader files
FXPath=~/mhh-content/fx:~/mhh-content/libraries

# location of crossfade shader files
CrossfadePath=~/mhh-content/crossfades
```

Using the example directory structure shown earlier, your settings would become:

```
# location of visualizer conf and shader vert/frag files                          ↓ new content starts here
VisualizerPath=~/mhh-content/shaders:~/mhh-content/libraries:~/monkeyshine/shaders:~/monkeyshine/libraries

# location of playlist conf files   ↓ new content starts here
PlaylistPath=~/mhh-content/playlists:~/monkeyshine/playlists

# location of graphics files      ↓ new content starts here
TexturePath=~/mhh-content/textures:~/monkeyshine/textures

# location of post-processing FX conf and shader files          ↓ new content starts here
FXPath=~/mhh-content/fx:~/mhh-content/libraries:~/monkeyshine/fx:~/monkeyshine/libraries

# location of crossfade shader files  ↓ new content starts here
CrossfadePath=~/mhh-content/crossfades:~/monkeyshine/crossfades
```

And that's it -- the program will find anything you create.

## Workflows

It's _extremely_ useful to have an editor that "speaks" GLSL, the OpenGL Shader Language. There are probably plugins for popular editors like Notepad++ or (shudder) Visual Studio Code, but since I use the grown-up version of Visual Studio, I strongly recommend Daniel Scherzer's [GLSL language integration](https://marketplace.visualstudio.com/items?itemName=DanielScherzer.GLSL2022) extension. For Linux-based development, I use JetBrains Rider with Jan Polák's [GLSL Support](https://plugins.jetbrains.com/plugin/6993-glsl-support) plugin which works well, despite iffy reviews of early versions.

These will recognize `.vert`, `.frag`, and `.glsl` filename extensions, and It Just Works. It's a pretty nice workflow to run Monkey Hi Hat on another monitor or off to the side in a window, and use your IDE to modify the shader, then just issue a `--reload` command to immediately see the results.

Both Visual Studio and JetBrains Rider can directly open a directory (in other words, you don't need to create a solution or project).

### Custom Creations

The best workflow is probably an iterative process. Set up your files, load Monkey Hi Hat and get some music going, disable caching with the `--nocache` command, and make small changes. Issue a `--reload` command whenever you make a change and see what the results are. I strongly recommend Gregg Man's VertexShaderArt [tutorial](https://www.youtube.com/@vertexshaderart8178/videos) videos for a nice introduction to this iterative process. It's also helpful to understand the unique integer-input approach used by `VertexIntegerArray` shaders.

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

### Converting Public Domain Shaders

If you want to adapt an existing Shadertoy or VertexShaderArt example, the Volt's Laboratory repository (and the archive included with each app release) has template files for each. Since Shadertoy is frag-shader-oriented, there is a template `.conf` and `.frag` file. Similarly, because VertexShaderArt is vert-shader-oriented, there is a template `.conf` and `.vert` file. Adapting these to Monkey Hi Hat is very nearly a fill-in-the-blanks process.

Comments in the template files should help you, and of course, Volt's Laboratory has many examples you can use as a reference. For more details, refer to the [Shader Basics](shader-basics.md) page which explains the available shader uniforms, and how these map to Shadertoy and VertexShaderArt.
