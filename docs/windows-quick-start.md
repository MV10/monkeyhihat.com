# Windows Quick-Start

## Install Program

> If you use the install program, that is ALL you really need to know. The wiki home page shows you how to test your setup. The rest of this page explains _manual_ installation for people who build from source, and various optional features that might make your use of the program easier.

An install program is available on the release page. The installer can also update older versions or uninstall the current version.

The installer is the recommended approach for getting the application and content installed. It will download and install the app itself, visualization content, and if necessary, the .NET runtime. (Unlike earlier versions, no audio loopback libraries or third-party drivers are required.)

## Requirements

* A modern video card (or integrated GPU) that supports OpenGL API 4.5 (most non-Intel GPUs are OK)
* .NET 8 runtime or Visual Studio with the .NET 8 SDK
* Recommended: Monkey-Droid GUI
* For content creators: GLSL editor or Visual Studio extension
* Optional: Windows Terminal
* Optional: OpenSSH server and client (ships with Windows but inactive)

And of course, you will need a source of music such as Spotify or Soundcloud. Spotify has a decent native Windows client ([download](https://open.spotify.com/download)) which has the benefit that it allows remote-control of music playing through your PC from any other client on the same network -- such as your phone or a laptop.

## .NET Runtime

If you are not a .NET developer, download and install the latest .NET version 8 runtime from Microsoft. You only need the basic runtime on the bottom right, not the Desktop or ASP.NET runtimes (although those will work). If you _are_ a developer, the .NET 8 SDK is fine or any of the Visual Studio "workloads" that include the SDK. If you want to check whether .NET 8 is already installed, open a command-line window and type `dotnet --info`. If you get an error message or don't see any 8.x versions listed, you don't have it.

Run the installer (Windows x64 link at the bottom right):
* [https://dotnet.microsoft.com/en-us/download/dotnet/8.0](https://dotnet.microsoft.com/en-us/download/dotnet/8.0)

## Using Monkey Hi Hat

Obviously, you need to install monkey-hi-hat itself. The Windows installer handles everything for you. The application will be `C:\Program Files\mhh` and the content directory will be `C:\ProgramData\mhh-content`.

The installer also makes all of the necessary basic changes to the configuration file, which is `mhh.conf` in the application's directory. The configuration file is a plain text file you can read and edit with Notepad. It has many detailed comments to help you understand the settings. For my own usage after a fresh install, usually I just enable the first three settings in the file (`StartFullScreen`, `StartInStandby`, and `CloseToStandby`) and I leave the rest of it alone. Refer to comments in the config file and also the [config](https://github.com/MV10/monkey-hi-hat/wiki/03.-App-Configuration-(mhh.conf)) wiki topic for more details. 

If you're a programmer and you plan to create your own visualizations and effects, create a _separate_ directory structure on your computer or your network for those files (your config file can point to both sets of directories). Using separate directories for your custom content makes it easier to update the "off the shelf" content with future releases. Your custom directory structure should look like this:

```
📂 x:\monkey-hi-hat-content
      |--📂 fx
      |--📂 libraries
      |--📂 playlists
      |--📂 shaders
      |--📂 templates
      +--📂 textures
```

The wiki documentation home page has a basic first-time walk-through, but usage is simple: open a command-line window, change to the install directory, and run `mhh.exe`. This loads the low-overhead "idle" visualizer. To send commands to the running instance, open another command-line window, change to the install directory, and run `mhh --help` to see the command-line help options. If you're using the sample content, start up some music and run the command `mhh --playlist variety`.

The program window recognizes several keyboard commands. Two of them are:

* `ESC` ends the program
* `→` loads the next playlist visualizer (right-arrow)

If you didn't change anything, at this point the program is running in a window. You can resize or maximize that window, but you probably want to open the `mhh.conf` configuration file and change the `StartFullScreen` setting to `true`. But then, unless you have multiple monitors, you can't use a second window to send commands (well, technically you could `ALT-TAB` between the two), and if you're running it remotely (for example, in your AV stack outputting to your TV), you don't want to be chained to the keyboard.

This is where remote control comes into play, which is covered in the next section.

## Remote Control: Monkey-Droid GUI

Windows and Android users can install [Monkey Droid](https://github.com/MV10/monkey-droid), a simple dedicated GUI application for controlling monkey-hi-hat running on another computer. The Windows `msix` or the Android `apk` install packages are available on this repo's [release](https://github.com/MV10/monkey-hi-hat/releases/) page. The Monkey Droid application has minor UI bugs (thanks to .NET 7's MAUI being released prematurely) but I plan to rewrite it in 2026.

The Monkey Hi Hat `mhh.conf` config file includes an `UnsecuredPort` setting. By default, port 50001 will be used, but you can use any open port you wish. The official TCP custom or "dynamic" port range is 49152 to 65535, which is your safest bet for avoiding collisions with other things running on your system.

Start Monkey Hi Hat, then launch Monkey Droid on the device of your choosing. Hit the &plus;`Add` button at the top right of the Server List page. Enter the name of the computer where Monkey Hi Hat is running, enter the port number, and hit the `Save` button. After returning to the Server List page, choose the server you just defined, and choose the `Use` option from the pop-up. (You can also try the `Test` option just to verify network connectivity.)

Once a server is selected, you'll be sent to the Playlist page. It's initially empty, so ask the server what playlists are available: Hit the &olarr;`Refresh` button at the top right of the page. If you're using the content provided in the [Volts Laboratory](https://github.com/MV10/volts-laboratory) repo, you'll see at least one playlist named `variety`. Select that and Monkey Hi Hat will load and use that playlist.

The Visualizer tab works similarly. It's initially empty, so hit the &olarr;`Refresh` button at the top right. You can use this page to jump to any specific visualizer (shader). Note this will terminate the playlist, if one is active. Initially each entry will not have a description loaded. A background thread will read visualizer descriptions and whether or not they are audio-reactive (indicated by a music note icon).

The other tabs are self-explanatory. You can issue the other standard Monkey Hi Hat commands, or issue commands manually (which is useful for Monkey Hi Hat commands that haven't been added to Monkey Droid yet).

You can also control Monkey Hi Hat from an SSH terminal, which relies on named pipes instead of TCP network connections. Refer to the directions in the last section of this page for more details.

## Remote Control: Windows Terminal

This is _completely_ unnecessary for using Monkey Hi Hat, but I thought I'd plug the new(ish) [Windows Terminal](https://apps.microsoft.com/store/detail/windows-terminal/9N0DX20HK701) application. This replaces the tired-old "DOS prompt" / CMD command-line, as well as the default Powershell command-line and more. I use it as my default everywhere I can, now, and can't recommend it strongly enough. Other than Visual Studio and .NET, I rarely have anything nice to say about Microsoft's software decisions any more, but they knocked it out of the park with Terminal.

You can even run shaders as the background... and Mr. Rånge has even made it [relatively easy](https://mrange.github.io/windows-terminal-shader-gallery/) to install and configure.

## Remote Control: SSH Support

Since you probably want to run Monkey Hi Hat full screen, and you might want to control it from your couch with a tablet, your phone, a laptop, or some other separate device, I recommend setting up SSH (Secure Shell). SSH is a remote-terminal protocol that has been used in the UNIX world for ages. Relatively recently, Microsoft finally got with the program and began shipping an SSH server and client, although they require a few extra steps to make them easier to use.

> Important: The instructions below create a relatively _insecure_ SSH setup. I trust everything _inside_ my network, so I'm not concerned about this, but that's your decision and I accept no responsibility if Evil Chinese Hax0rs gain access to your secret hoard of hipster coffee blends, or whatever else is on your network. Secured key-based configuration is beyond the scope of this quick-start. Put on your big-boy pants and search the Interwebs, it's actually pretty easy to do.

The first step is to tell Windows you want to use OpenSSH Server and OpenSSH Client. From the Start menu, open _Settings_, click on _Apps_, click on _Optional Features_, and if you see _OpenSSH Server_ and _OpenSSH Client_ in this list, they're already installed and you're done. Otherwise, click (Win10) _Add a feature_ , or (Win11) click the _View features_ button on the _Add an optional feature_ line. Choose the checkbox next to _OpenSSH Server_ and/or _OpenSSH Client_, then click the (Win10) _Install_ button, or (Win11) click the _Next_ button then the _Install_ button. The installer will take a minute or two to download and install the apps.

The next step is to make sure OpenSSH Server is always running. Open the Start menu and type _Services_ and you should see the Services app show up. Click on it, then scroll down to find _OpenSSH SSH Server_. At the right, you'll probably see that startup mode is _Manual_ and nothing in the status column, indicating it is not running. Double-click on it, and in the properties dialog, change _Startup type_ to _Automatic_ or _Automatic (Delayed Start)_ (which lets Windows start more quickly), and under _Service status_ click on the _Start_ button, then click _Ok_ and close the Services app.

Finally, you need to open port 22 on your computer's firewall so that it can receive SSH traffic. Open the Start menu and type "Firewall" and you should see _Firewall & network protection_ pop up. Click on it, then click _Advanced settings_, which opens a Windows Defender dialog. Click _Inbound Rules_ at the top left, then _New Rule_ at the top right. The New Rule Wizard dialog opens. Click the _Port_ option, then click the _Next_ button. Keep the default _TCP_ and _Specific local ports_ options, and type _22_ in the field next to _Specific local ports_, then click the _Next_ button. Keep the default _Allow the connection_ setting and click _Next_ again. For monkey-hi-hat purposes, you most likely only want OpenSSH to respond on _Private_ networks, so uncheck _Domain_ and uncheck _Public_ unless you intend to configure secure access. Finally, click _Next_ again, enter _OpenSSH Server_ as the firewall rule name, and click _Finish_. You can close the Windows Defender and Settings windows.

I also run [ConnectBot](https://play.google.com/store/apps/details?id=org.connectbot) on my Android phone. It's a little bit buggy, but it's free, it's actively maintained, and it doesn't harangue you with bullshit ads that you'll never intentionally click on.

You can test this from a computer running the SSH client, including locally on the same computer where Monkey Hi Hat and OpenSSH server is running. Open a command-line window and type `ssh user@computer` and press <kbd>Enter</kbd>. It will warn you that it can't positively identify the server and ask you if you wish to proceed. This looks and works differently with different clients. With OpenSSH Client on Windows, you'll have to type the word _yes_ to proceed. Other clients may show a dialog, or prompt for the <kbd>Y</kbd> key etc. Then you'll be prompted for the password. On Windows, you may have to alter your user login to accept a password, particularly if you're using a "Microsoft account" and/or the Windows Hello PIN, rather than a simple local account. These steps are beyond the scope of this Quick Start, but it's pretty easy to find more details online.

## For Content Creators: GLSL Editor

If you want to create or modify the visualization shaders, it's _extremely_ useful to have an editor that "speaks" GLSL, the OpenGL Shader Language. There are probably plugins for popular editors like Notepad++ or (shudder) Visual Studio Code, but since I use the grown-up version of Visual Studio, I strongly recommend Daniel Scherzer's [GLSL language integration](https://marketplace.visualstudio.com/items?itemName=DanielScherzer.GLSL2022) extension.

This will recognize `.vert`, `.frag`, and `.glsl` filename extensions, and It Just Works. It's a pretty nice workflow to run Monkey Hi Hat on another monitor or off to the side in a window, and use Visual Studio to modify the shader, then just issue an `mhh --reload` command to immediately see the results.
