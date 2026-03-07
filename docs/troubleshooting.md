# Troubleshooting

## Support

* Did you receive an error message ("Exception") during installation? 
* Do you have problems using the program after installation?
* Do you have a question or suggestion, or need other assistance?

Please create a Github account and post a new issue with the details (use the `Issues` link at the top of your screen). 

You can also email me at [mcguirev10@gmail.com](mailto:mcguirev10@gmail.com?subject=Help%20with%20Monkey%20Hi%20Hat).

## Installation Issues

No known issues.

> When reporting installation issues (including upgrade / uninstall problems), please attach the log file. You can find this in your user account temporary directory, normally `C:\Users\your_username\AppData\Local\Temp` with the filename `install-monkey-hi-hat.log`. This is just a text file so please feel free to review it before sending. It will not contain any sensitive system information.

If the installer fails for some reason, the application is simple to install by hand. Details are in the _Quick Start_ sections of the docs. Even if that works for you, please open an issue so I can investigate whatever problem you encountered.

## Program Execution Issues

No known issues.

## Performance Issues

No known issues.

> Intel-based GPUs are _NOT_ supported. Their drivers are historically of very poor quality. If it works for you, great.

If your system can't maintain a smooth frame-rate, consider changing the `RenderResolutionLimit` limit in the configuration file (`mhh.conf`), which you can edit with Notepad or any other text editor. If you used the installer, that file should be in the `C:\Program Files\mhh` directory. Try to pick a standard horizontal resolution like 1920 or 1280. This works very well, my living room miniPC is set for 2K output and my amplifier upscales to 4K (and if there were quality issues it would be _very_ apparent on a 77" television).

## Content Creation Issues

No known issues.

While I can't help anyone learn to program or write shaders, I'm happy to help with issues like system setup, clarifying how the content creation process works, and so on. Shader programming is a potentially very complicated topic and there are many, many resources available across the web. The basics are covered across several topics in the docs, and also in a simple step-by-step [tutorial](https://mcguirev10.com/2024/01/20/monkey-hi-hat-getting-started-tutorial.html) on my blog.

## Sharing Issues (Spout / NDI)

#### _Received texture is blank or dimmed_

Check the fragment shader, the final output color's alpha channel must be 1.0. Since alpha isn't important in Monkey Hi Hat or Shadertoy, sometimes shaders migrated from Shadertoy disregard the alpha channel or even explicitly set it to zero.

## Miscellaneous / FAQ

No known issues.
