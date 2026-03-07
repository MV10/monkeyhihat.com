# Using Monkey Hi Hat

## Startup and Local Control

Monkey Hi Hat is primarily designed to run full-screen and to be controlled from a separate computer or phone. However, you can run it in a window and control it locally, or run it full-screen on one monitor and control it from a second monitor. The Introduction page has a basic first-time walk-through, but usage is simple. Either launch it from an icon (desktop or your Start menu), or open a terminal, change to the install directory, and run the program directly:

* Windows: `mhh`
* Linux: `./mhh`

This loads the low-overhead "idle" visualizer.

To send commands to the running instance, open a second terminal window, change to the install directory, and run the program again with the `--help` switch to see a list of command-line options:

* Windows: `mhh --help`
* Linux: `./mhh --help`

The installer provides content and sample playlists. Start up some music and load the "variety" playlist:
 
* Windows: `mhh --playlist variety`
* Linux: `./mhh --playlist variety`

The program window recognizes several keyboard commands. Two of them are:

* `ESC` ends the program
* `→` loads the next playlist entry (right-arrow)

If you didn't change anything, at this point the program is running in a window. You can resize or maximize that window, but you probably want to open the `mhh.conf` configuration file and change the `StartFullScreen` setting to `true`. But then, unless you have multiple monitors, it won't be easy to use a local terminal to send commands, and if you're running it remotely (for example, in your AV stack outputting to your TV), you don't want to be chained to the keyboard.

This is where remote control comes into play.

## Remote Control: Monkey-Droid GUI

Windows and Android users can install [Monkey Droid](https://github.com/MV10/monkey-droid), a simple dedicated GUI application for controlling monkey-hi-hat running on another computer on the same local network. The Windows `msix` or the Android `apk` install packages are available on this repo's [release](https://github.com/MV10/monkey-hi-hat/releases/) page. The Monkey Droid application has minor UI bugs (thanks to .NET 7's MAUI being released prematurely) but I plan to rewrite it in 2026 when the libaries have matured.

The Monkey Hi Hat `mhh.conf` config file includes an `UnsecuredPort` setting. By default, port 50001 will be used, but you can use any open port you wish. The official TCP custom or "dynamic" port range is 49152 to 65535, which is your safest bet for avoiding collisions with other things running on your system.

Start Monkey Hi Hat, then launch Monkey Droid on the device of your choosing. Hit the &plus;`Add` button at the top right of the Server List page. Enter the name of the computer where Monkey Hi Hat is running, enter the port number, and hit the `Save` button. After returning to the Server List page, choose the server you just defined, and choose the `Use` option from the pop-up. (You can also try the `Test` option just to verify network connectivity.)

Once a server is selected, you'll be sent to the Playlist page. It's initially empty, so ask the server what playlists are available: Hit the &olarr;`Refresh` button at the top right of the page. If you're using the content provided in the [Volts Laboratory](https://github.com/MV10/volts-laboratory) repo, you'll see at least one playlist named `variety`. Select that and Monkey Hi Hat will load and use that playlist.

The Visualizer tab works similarly. It's initially empty, so hit the &olarr;`Refresh` button at the top right. You can use this page to jump to any specific visualizer (shader). Note this will terminate the playlist, if one is active. Initially each entry will not have a description loaded. A background thread will read visualizer descriptions and whether or not they are audio-reactive (indicated by a music note icon).

The other tabs are self-explanatory. You can issue the other standard Monkey Hi Hat commands, or issue commands manually (which is useful for Monkey Hi Hat commands that haven't been added to Monkey Droid yet).

You can also control Monkey Hi Hat from an SSH terminal, which relies on named pipes instead of TCP network connections. Refer to the directions in the last section of this page for more details.

## Remote Control: Windows SSH Support

Since you probably want to run Monkey Hi Hat full screen, and you might want to control it from your couch with a tablet, your phone, a laptop, or some other separate device, I recommend setting up SSH (Secure Shell). SSH is a remote-terminal protocol that has been used in the UNIX world for ages. Relatively recently, Microsoft finally got with the program and began shipping an SSH server and client, although they require a few extra steps to make them easier to use.

> Important: The instructions below create a relatively _insecure_ SSH setup. I trust everything _inside_ my network, so I'm not concerned about this, but that's your decision and I accept no responsibility if Evil Chinese Hax0rs gain access to your secret hoard of hipster coffee blends, or whatever else is on your network. Secured key-based configuration is beyond the scope of this quick-start. Put on your big-boy pants and search the Interwebs, it's actually pretty easy to do.

The first step is to tell Windows you want to use OpenSSH Server and OpenSSH Client. From the Start menu, open _Settings_, click on _Apps_, click on _Optional Features_, and if you see _OpenSSH Server_ and _OpenSSH Client_ in this list, they're already installed and you're done. Otherwise, click (Win10) _Add a feature_ , or (Win11) click the _View features_ button on the _Add an optional feature_ line. Choose the checkbox next to _OpenSSH Server_ and/or _OpenSSH Client_, then click the (Win10) _Install_ button, or (Win11) click the _Next_ button then the _Install_ button. The installer will take a minute or two to download and install the apps.

The next step is to make sure OpenSSH Server is always running. Open the Start menu and type _Services_ and you should see the Services app show up. Click on it, then scroll down to find _OpenSSH SSH Server_. At the right, you'll probably see that startup mode is _Manual_ and nothing in the status column, indicating it is not running. Double-click on it, and in the properties dialog, change _Startup type_ to _Automatic_ or _Automatic (Delayed Start)_ (which lets Windows start more quickly), and under _Service status_ click on the _Start_ button, then click _Ok_ and close the Services app.

Finally, you need to open port 22 on your computer's firewall so that it can receive SSH traffic. Open the Start menu and type "Firewall" and you should see _Firewall & network protection_ pop up. Click on it, then click _Advanced settings_, which opens a Windows Defender dialog. Click _Inbound Rules_ at the top left, then _New Rule_ at the top right. The New Rule Wizard dialog opens. Click the _Port_ option, then click the _Next_ button. Keep the default _TCP_ and _Specific local ports_ options, and type _22_ in the field next to _Specific local ports_, then click the _Next_ button. Keep the default _Allow the connection_ setting and click _Next_ again. For monkey-hi-hat purposes, you most likely only want OpenSSH to respond on _Private_ networks, so uncheck _Domain_ and uncheck _Public_ unless you intend to configure secure access. Finally, click _Next_ again, enter _OpenSSH Server_ as the firewall rule name, and click _Finish_. You can close the Windows Defender and Settings windows.

You can test this from a computer running the SSH client, including locally on the same computer where Monkey Hi Hat and OpenSSH server is running. Open a command-line window and type `ssh user@computer` and press <kbd>Enter</kbd>. It will warn you that it can't positively identify the server and ask you if you wish to proceed. This looks and works differently with different clients. With OpenSSH Client on Windows, you'll have to type the word _yes_ to proceed. Other clients may show a dialog, or prompt for the <kbd>Y</kbd> key etc. Then you'll be prompted for the password. On Windows, you may have to alter your user login to accept a password, particularly if you're using a "Microsoft account" and/or the Windows Hello PIN, rather than a simple local account. These steps are beyond the scope of this Quick Start, but it's pretty easy to find more details online.

## Remote Control: Linux Terminal / SSH

If you have two monitors, probably the easiest remote control option is to just run a terminal on the other display, change to the MHH directory, and issue your `./mhh` commands from there. This would work on a desktop, but it isn't very practical for large "headless" configurations like running it on a living room TV from a PC isolated in an AV closet.

Since you probably want to run Monkey Hi Hat full screen, and you might want to control it from your couch with a tablet, your phone, a laptop, or some other separate device, I recommend setting up SSH (Secure Shell). Typically if your distro doesn't already include OpenSSH, you need only request it from your packaging system.

Linux PCs will usually support the ssh client app out of the box. Windows users commonly download the PuTTY terminal app.

## Remote Control: Android SSH Client

I sometimes run [ConnectBot](https://play.google.com/store/apps/details?id=org.connectbot) on my Android phone. It's a little bit buggy, but it's free, it's actively maintained, and it doesn't harangue you with bullshit ads that you'll never intentionally click on. However, the dedicated Monkey-Droid app is far superior. I will typically use ConnectBot during testing.

## For Content Creators: GLSL Editor

If you want to create or modify the visualization shaders, it's _extremely_ useful to have an editor that "speaks" GLSL, the OpenGL Shader Language. There are probably plugins for popular editors like Notepad++ or (shudder) Visual Studio Code, but since I use the grown-up version of Visual Studio, I strongly recommend Daniel Scherzer's [GLSL language integration](https://marketplace.visualstudio.com/items?itemName=DanielScherzer.GLSL2022) extension.

This will recognize `.vert`, `.frag`, and `.glsl` filename extensions, and It Just Works. It's a pretty nice workflow to run Monkey Hi Hat on another monitor or off to the side in a window, and use Visual Studio to modify the shader, then just issue an `--reload` command to immediately see the results.