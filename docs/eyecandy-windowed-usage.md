# Eyecandy: Using With OpenTK Windows

> TODO: Provide a more detailed explanation. This was moved from the original quick-and-dirty README.

At a high level, these are the extra steps compared to a regular OpenTK `GameWindow` scenario:

* Create an `EyeCandyCaptureConfig` object to define audio capture parameters
* Create an `EyeCandyWindowConfig` object to define your window characteristics
    * Set the size: `config.OpenTKNativeWindowSettings.Size = (960, 540);`
    * Set the vert: `config.VertexShaderPathname = "Subdir/filename.vert";`
    * Set the frag: `config.FragmentShaderPathname = "Subdir/filename.frag";`
* Create a window object derived from `BaseWindow`
* In the window constructor, create an `AudioTextureEngine` object
* Call `engine.Create<AudioTextureXXXX>(...)` to define the textures you'll use
* Among your other OpenGL calls, in the `OnRenderFrame` event...
    * Call `engine.UpdateTextures();`
    * Call `engine.SetTextureUniforms(Shader);`

Refer to the Wave or Frag classes in the [`demo`](https://github.com/MV10/eyecandy/tree/master/demo) project for relatively easy-to-follow examples of this. The Wave demo works similarly to VertexShaderArt (the work is performed in a vertex shader based on an array of sequential integers), and the Frag demo works similarly to Shadertoy (the work is performed in a frag shader on a quad that simply covers the entire display surface).

Extensive testing has shown that the background thread generates very little overhead. In my real-world monkey-hi-hat program, it's easiest to just create one of each audio texture and let them run all the time, rather than trying to manage creation/deletion or enabling/disabling. Use it when you need it, ignore it when you don't.

Refer to the `demo` project's [`Program.cs`](https://github.com/MV10/eyecandy/blob/master/demo/Program.cs) for a simple example of how to wire up Serilog logging. As of v3.2.0 eyecandy is tied into the OpenGL debug-message error signaling facility. You'll get detailed error messages and a stack trace -- a huge improvement over the old `GetError` approach.
