# Post-Install Instructions

This page is for users who have just finished running the installer. Prior to version 4.0.0, it was necessary to install audio loopback libraries and a third-party driver, so there were manual configuration steps required after install. However, that requirement has been eliminated, so there isn't currently much here.

## Suggested Configuration Changes

The configuration file is just a text file you can edit in programs like Notepad or nano. The filename is `mhh.conf` and if you used the installer, it should be available in the `C:\Program Files\mhh` directory on Windows, or `/etc/mhh` on Linux. All of the settings are heavily documented by comments (you can see the config template [here](https://github.com/MV10/monkey-hi-hat/blob/master/mhh/mhh/ConfigFiles/mhh.conf) in the repository) and the documentation has a short [App Configuration](app-configuration.md) page with some high-level considerations.

I personally like to change the first three options:

* Change `StartFullScreen` to `true`
* Change `StartInStandby` to `true`
* Change `CloseToStandby` to `true`

`StartInStandby` determines what the program does as soon as you execute it. The default is `false` which means it immediately loads and runs the "Idle" shader. When `true` the program will simply wait to receive commands from some remote source or another terminal window.

If the program displays graphics immediately, or after it receives a command that displays graphics (such as `--load` or `--playlist`), the `StartFullScreen` setting determines whether the program runs in a window or full screen mode.

Finally, `CloseToStandby` determines what happens if you press <kbd>ESC</kbd> or you click the X window-close button. When `false` the program simply ends. When `true`, the graphical display ends and the program resumes waiting for commands in a terminal window. When issuing commands remotely, `--quit` will always exit and `--standby` will always drop to standby mode.

Setting all three to `true` works well if you use the Monkey Droid remote control application and the application is always running, or you use the Windows TCP relay service to remotely launch the program (see below). This way I can just pick up my phone, open Monkey Droid, choose the living room computer, and click on the playlist. The application launches and a few seconds later the playlist kicks in as it switches to full screen. I don't need to touch a keyboard. I also remotely control my Yamaha amplifier and Spotify on that machine using nothing but my phone.

## TCP Relay Service

By default, Monkey Hi Hat can receive commands over the network on port 50001 (or whatever port you choose in the configuration file). Of course, for that to work, the program must be running, and that's where the TCP Relay Service (named monkey-see-monkey-do, or msmd) comes into play. The service is a lightweight background service that listens on a different port, and any commands received on that port will be relayed to the Monkey Hi Hat port. When Monkey Hi Hat is not running, the service will start it, then relay the commands.

During Windows installation, you will be asked whether you want the service to run. It is always installed even if you choose not to run it. See _Windows Service Control_ below to set it up later, or to stop it.

Linux does not have a TCP relay service at this time because security restrictions makes it somewhat complicated. Finding a work-around is on my TO-DO list.

### Service Configuration

The _Using Monkey Hi Hat_ page explains that the program listens for commands on a TCP port (by default, port 50001).

Inside the `mhh.conf` config file, you will find an `[msmd]` section with an `UnsecuredReplayPort` setting, which defaults to 50002. Like the `UnsecuredPort` setting for Monkey Hi Hat itself, you can set this to any unused port, but the default is normally a safe choice.

You can also limit the service to TCP v4 or v6, and adjust the startup delay, but normally you can leave these at the defaults. The comments in the configuration file provide more details.

### Monkey-Droid Configuration

The _Using Monkey Hi Hat_ section explained how to add a Server entry to control the Monkey Hi Hat computer directly.

Controlling the computer through the TCP Relay Service is exactly the same. You add another Server entry using the same computer name, but you use the monkey-see-monkey-do port number instead (typically 50002).

In fact, if you always run the relay service, it's perfectly fine to only use that port instead of directly communicating with Monkey Hi Hat. There is no significant delay when both programs are running.

### Windows Service Control

If you didn't tell the Windows installer you want to use the TCP relay service, just open a command window, change to the application directory, and run two batch files: `WinServiceCreate` and `WinServiceRun`. After that, the service will always auto-start whenever Windows boots up. 

Similarly, the `WinServiceStop` batch file will terminate the service, and `WinServiceDelete` will prevent it from auto-start after Windows reboots.
