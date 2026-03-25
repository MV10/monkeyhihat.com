# Windows Quick-Start

## Installation

Download the install program from the repository [Release](https://github.com/MV10/monkey-hi-hat/releases) page. It's named `install-5-4-0.exe` or whatever version is current.

When you run it, Windows may show you a warning with a heading like, "Windows protected your PC" -- this is an automatic thing Windows does for any file downloaded from the Internet. Click the _More info_ link and it will show you a _Run Anyway_ button that will start the process.

The Windows install program is fully automatic. It must run as Administrator and will prompt you for a password if your account is not in the Administrators group.

It will ask you a few yes/no questions, then it will download and install the app itself, visualization content, various support libraries, and if necessary, the .NET runtime. The installer can also update older versions or cleanly uninstall the current version and all related files.

Previously this section detailed manual installation, but that's no longer necessary or practical, and it was creating confusion among some new users. Unlike earlier versions, no audio loopback libraries or third-party drivers are required which were also manual steps required by older versions.

## What You Get

You should have a Monkey Hi Hat folder in your start menu with a link to the program, and another link to _Monkey Hi Hat Console_ (just a command prompt that is already pointing to the Monkey Hi Hat directory, and it auto-runs the `--help` command). Depending on how you answered the questions during installation, you may also have those icons on your Windows Desktop, and you may be able to hit <kbd>F10</kbd> to launch the program.

## Next Steps

* Start by reading [Using Monkey Hi Hat](using-monkey-hi-hat.md) to test your installation
* That section also helps you understand and choose remote control options
* A few popular config changes are explained in [Post Install Instructions](post-install-instructions.md)
