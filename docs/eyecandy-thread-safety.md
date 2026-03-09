# Eyecandy Thread Safety

The eyecandy library is multi-threaded, but OpenGL is not inherently thread-safe. When eyecandy updates audio texture data on background threads, it uses a `Mutex` synchronization object to prevent other threads from changing the OpenGL texture activation / binding settings during updates. Library consumers which perform frequent texture updates should also use `Mutex` synchronization when eyecandy audio capture may be active.

The eyecandy library exposes the string value `AudioTextureEngine.GLTextureMutexName` which allows any other assembly or process to obtain a mutually-exclusive lock around a section of code by referencing that same mutex name.

For example:

```csharp
using eyecandy;
using OpenTK.Graphics.OpenGL;

private static readonly Mutex GLTextureMutex = new(false, AudioTextureEngine.GLTextureMutexName);

public void UpdateTexture()
{
    GLTextureMutex.WaitOne(); // wait to obtain the lock
    try
    {
        GL.ActiveTexture(myTextureUnit);
        GL.BindTexture(TextureTarget.Texture2D, myTextureHandle);
        GL.TexParameter(...);
        GL.TexImage2D(...);
        GL.BindTexture(TextureTarget.Texture2D, 0); // unbind
    }
    finally
    {
        GLTextureMutex.ReleaseMutex(); // release the lock
    }
}
```