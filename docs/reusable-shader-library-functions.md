# Reusable Shader Library Functions

## Concepts

Shader programs can define functions, so it follows that programmers may wish to re-use these functions. Library shaders are just GLSL source files that contain function definitions and nothing else. They're added (linked) to "main" shader programs, so they shouldn't define version pragmas, they can't have a `main` function, and so on. Both visualizer and FX config files can reference library shaders.

A shader program that will use library functions has to declare an empty version of the functions that will be used. This declaration has the same name and signature but no definition (no code enclosed by braces).

The library shaders don't have access to `struct` or `#define` statements in the program source. They can reference uniforms and globally-scoped variables (declare them in the library file). However, it is usually preferable to pass everything as function arguments. Library shaders would be the Shadertoy equivalent of code in the _Common_ tab (although on Shadertoy they can't reference uniforms or globally-scoped variables).

The visualizer must list all required library shader filenames in a `[Libraries]` section, or the shaders will fail to compile. Quite a few formats are possible for these entries. The GPU driver needs to know if the library will be linked to the vertex stage or the fragment stage, so the simple approach is to reference library files with `.vert` or `.frag` extensions. However, many functions are useful in either or both stages, so a third extension is permitted for library shaders: `.glsl` files.

If you only list a `.glsl` filename, it will be compiled twice, once to link to the vertex stage and again to link to the fragment stage. But if your main program isn't using the library in both places, that's wasteful. To indicate the configuration only needs the library at one stage or the other, prefix the filename with `vert:` or `frag:`. For example: 

```ini
[libraries]
frag:color_functions.glsl
```

All of the possible library entry patterns are listed below:

| Pattern | Description |
| --- | --- |
| `path\filename.ext` | explicit location of a library file (for .glsl, this links to both stages)
| `vert:path\filename.glsl` | explicit location of a library file to link to the vertex stage
| `frag:path\filename.glsl` | explicit location of a library file to link to the fragment stage
| `filename` | extension determines handling, finds .glsl, .vert, or .frag extensions
| `filename.vert` | library to link to the vertex stage only
| `filename.frag` | library to link to the fragment stage only
| `filename.glsl` | general library to link to both the vertex and fragment stages
| `vert:filename` | general library to link to the vertex stage only, .glsl extension implied
| `frag:filename` | general library to link to the fragment stage only, .glsl extension implied
| `vert:filename.glsl` | general library to link to the vertex stage only
| `frag:filename.glsl` | general library to link to the fragment stage only

Any path-filename combination is required to specify the extension.

For the filename-only pattern, it is valid to have both a .frag and .vert file with the same filename, but if a .glsl filename exists, an exception is thrown if a .frag or .vert extension is also found for the same filename.

## The Shadertoy Common Tab

Many Shadertoy programs use a `Common` tab for code that is shared by the `Buffer` and `Image` tabs. This is similar to a library, but Shadertoy _copies_ that code into each shader tab's code, whereas Monkey Hi Hat compiles and links the libraries. There are both benefits and drawbacks to each approach.

The two main benefits of the Shadertoy model are that `#define` commands in the `Common` tab are available in each shader tab, and it isn't necessary to declare the library functions in the shader code. Monkey Hi Hat shader programs can't access `#define` declarations, and empty function declarations are required.

On the other hand, Monkey Hi Hat library functions can declare and use uniforms, which isn't possible in Shadertoy. For an example of this, see the Volt's Laboratory library *fonts_v1a* which declares the font texture as `uniform sampler2D font` and uses it throughout the library code. This was originally a Shadertoy program called [Font Renderer](https://www.shadertoy.com/view/cdtBWl), written by user foodini, and you can see in the `Common` tab that a reference to the texture must be passed with every function call.

## Example

The repository's *[vertint.conf](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/vertint.conf)* test-content visualizer references the vertex shader *[vertint.vert](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/vertint.vert)* and the library shader *[vert_library.glsl](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/vert_library.glsl)*. The *vertfrag.conf* also references this library, but links it to the fragment stage instead.

The library shader defines a pair of color-conversion functions:

```GLSL
vec3 rgb2hsv(vec3 c)
{
    const vec4 K = vec4(0.0, -1.0 / 3.0, 2.0 / 3.0, -1.0);
    vec4 p = mix(vec4(c.bg, K.wz), vec4(c.gb, K.xy), step(c.b, c.g));
    vec4 q = mix(vec4(p.xyw, c.r), vec4(c.r, p.yzx), step(p.x, c.r));

    float d = q.x - min(q.w, q.y);
    const float e = 1.0e-10;
    return vec3(abs(q.z + (q.w - q.y) / (6.0 * d + e)), d / (q.x + e), q.x);
}

vec3 hsv2rgb(vec3 c)
{
    const vec4 K = vec4(1.0, 2.0 / 3.0, 1.0 / 3.0, 3.0);
    vec3 p = abs(fract(c.xxx + K.xyz) * 6.0 - K.www);
    return c.z * mix(K.xxx, clamp(p - K.xxx, 0.0, 1.0), c.y);
}
```

The vertex shader declares a matching signature for one of these, which is resolved when the GPU driver compiles and links the files:

```GLSL
vec3 hsv2rgb(vec3 c);
```
