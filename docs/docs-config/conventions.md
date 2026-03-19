# Config File Conventions

The Monkey Hi Hat config file (usually `mhh.conf`) is a plaintext file that you can edit in programs like Notepad, Nano, or other simple text editors. It is loaded once when the application starts and most of the settings can't be changed at runtime. Some "getting started" features are mentioned in the _App Configuration_ topic in the _Options and Controls_ section of the docs, but this area is a _complete_ reference for all possible features and settings.

You can see the config template [here](https://github.com/MV10/monkey-hi-hat/blob/master/mhh/mhh/ConfigFiles/mhh.conf) in the repository.

Lines that begin with a `#` hashtag are comments, and any trailing portion of a line after a `#` hashtag is also a comment. This means you can't use a hashtag anywhere else such as text strings intended for display, or filenames and paths (unlikely to be a problem).

A section is enclosed in `[brackets]` and is used to group related settings. The config documentation is organized by section.

A section may contain a list of values, but most sections are settings consisting of "key-value pairs" in the form of `key=value`. Typically leading and trailing whitespace isn't important, you can do `key = value` or `key= value` if you feel that is more readable.

Versions prior to v5.4.0 had extensive comments in the config file itself which explained each feature. However, updating existing config files was extremely complicated and fragile, and this organized, centralized documentation is easier to maintain and read.

Note that the documentation may list settings in a different order than what you see in the config file. It is recommended to retain the order in the file because the installer update tool will try to insert new settings in logical ways based on that sequence. The documentation is organized in a more topical fashion, whereas the config file sometimes developed "organically" over time.


## Config File Locations

The default location is the application's top-level directory.

> If you DO NOT use the Windows installer or the Linux install script, for example, you built the app from source, you should manually copy `mhh.conf` from the `ConfigFiles` template directory to the appropriate directory.

If you need multiple configuration files, create an environment variable named `monkey-hi-hat-config` on Windows, or `MONKEY_HI_HAT_CONFIG` on Linux containing the full pathname (directory and filename) of the active configuration file, which can be stored anywhere the application can access. If the environment variable exists, this is the first location the program checks for a file. This is most commonly used for supporting development scenarios, but advanced DJ / VJ and other pro / semi-pro users might also benefit from this (for example, supporting different NDI sources in studio-equipment environments).

The config file path search sequence is:

* The environment variable
* The default location
* The app directory's `ConfigFile` template path

> If the program tries to load from the template directory, note that the `ConfigFiles\mhh.conf` template is not usable "out of the box" since it doesn't point to your content files. Installation and update will not modify that copy of the file. See _Required Path Settings_ below for details. This is mostly a legacy feature from early versions without installer update capability.

You may notice `mhh.debug.conf` in the app's `ConfigFiles` template directory. You can disregard this, as the name suggests, it's for developer usage. The contents may change at any time, it's mostly uncommented, and it may reference unreleased features. It is loaded when a debugger is attached (ie. running the program from Visual Studio) and my dev machines reference it by environment variable. It gets installed simply because it's part of the code repository for my convenience and safekeeping.
