# Post-Install Instructions

## About This Page

This page is for users who have just finished running the installer. Prior to version 4.0.0, it was necessary to install audio loopback libraries and a third-party driver, so there were manual audio configuration steps required after install. However, that requirement has been eliminated, so there isn't currently much here.

## Configuration Changes to Consider

The configuration file is just a text file you can edit in Notepad. The filename is `mhh.conf` and if you used the installer, it should be available in the `C:\Program Files\mhh` directory on Windows, or `/etc/mhh` on Linux. All of the settings are heavily documented by comments (you can see the config template [here](https://github.com/MV10/monkey-hi-hat/blob/master/mhh/mhh/ConfigFiles/mhh.conf) in the repository) and the wiki has a [short](https://github.com/MV10/monkey-hi-hat/wiki/03.-App-Configuration) page with some high-level considerations.

I personally like to change the first three options:

* Change `StartFullScreen` to `true`
* Change `StartInStandby` to `true`
* Change `CloseToStandby` to `true`

Setting those to `true` works well if you use the Monkey Droid remote control application with the TCP relay service to remotely launch the program. This way I can just pick up my phone, open Monkey Droid, choose the living room computer, and click on the playlist. The application launches and a few seconds later the playlist kicks in as it switches to full screen. I don't need to touch a keyboard. I also remotely control my Yamaha amplifier and Spotify on that machine -- using nothing but my phone.

If you didn't tell the Windows installer you want to use the TCP relay service, just open a command window, change to the application directory, and run two batch files: `WinServiceCreate` and `WinServiceRun`. After that, the service will always auto-start whenever Windows boots up. By default Monkey Droid should communicate on port 50002 to send commands to the relay service instead of directly to Monkey Hi Hat (by default MHH itself listens on port 50001).

Linux does not have a TCP relay service at this time (the security model makes it somewhat complicated).
