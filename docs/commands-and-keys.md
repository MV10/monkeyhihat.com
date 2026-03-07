# Commands and Keys

## Command-Line Switches

Executing `mhh` with no switches launches the program. After it is running, you control the running instance by running it again with the switches shown below. These are passed to the running instance, then the second copy exits.  _Most_ of the time you're only going to use a few of these. I regularly only use `--playlist`, `--load`, sometimes `--fx`, and `--standby`.

The output from `mhh --help` lists available switches:

```
--help                      shows help (surprise!)
--quit                      ends the program

--list [viz|playlists|fx]   shows config files (*.conf) from all defined paths for the requested file type

--idle                      loads the default startup shader
--reload                    unloads and reloads the current shader (unavailable after an FX shader loads)
--load [file]               loads [file].conf from VisualizationPath defined in mhh.conf
--load [viz] [fx]           loads a visualization and immediately applies FX; must use search paths
--fx [file]                 loads [file].conf from FXPath defined in mhh.conf
--fade [file]               queues a specific crossfade shader for the next visualizer change
--load [path\file]          if present, loads [file].conf from requested path
--fx [path\file]            if present, loads [file].conf from requested path
--fade [path\file]          if present, queues crossfade from requested path

--playlist [file]           loads [file].conf from PlaylistPath defined in mhh.conf
--playlist [path\file]      if present, loads [file].conf from requested path
--next                      when a playlist is active, advances to the next viz (using the Order setting)
--next fx                   when a playlist is active, applies a post-processing FX (if one isn't running)

--jpg [wait]                JPG screenshot; (saves to desktop); "wait" watches for spacebar
--png [wait]                PNG screenshot; (saves to desktop); "wait" watches for spacebar

--show [viz|stats]          Text overlay for 10 seconds (unless "toggle" command is used)
--show [toggle|clear]       Switches text overlays from 10 seconds to permanent, "clear" removes overlay
--show [popups|what]        "what" shows viz and FX names and "popups" toggles playlist auto-popups
--show track                On Windows, displays most recent Spotify track info (if available)
--show grid                 Displays a 100 x 15 character grid for adjusting text settings

--info                      writes shader and execution details to the console
--display                   lists monitor details and the window state and coordinates
--fullscreen                toggle between windowed and full-screen state
--fps                       returns instantaneous FPS and average FPS over past 10 seconds
--fps [0|1-9999]            sets a frame rate (FPS) target, or 0 to disable (some shaders may require 60 FPS)
--nocache                   disables shader viz/fx caching for the remainder of the session (good for testing)

--test [viz|fx|fade] [file] Enters test mode, use +/- to cycle through content
--endtest                   Exits test mode (loads the idle visualizer)

--standby                   toggles between standby mode and active mode
--pause                     stops the current shader
--run                       resumes the current shader
--pid                       shows the current Process ID
--log [level]               shows or sets log-level (None, Trace, Debug, Information, Warning, Error, Critical)
--paths                     shows the configured content paths (viz, FX, etc.)

--console                   toggles the visibility of the console window (only minimizes Terminal)
--cls                       clears the console window of the running instance (useful during debug)

--devices                   list audio device names, can be used when MHH is not running

--streaming                 streaming commands control Spout / NDI; refer to the docs for details
--streaming status
--streaming send spout|ndi ["sender name"]
--streaming receive spout "source name"
--streaming receive ndi "machine (source name)" ["group1,group2,...groupN"]
--streaming stop send|receive

```

## Keyboard Input

Several keyboard commands are available:

| Key | Action |
|---|---|
| `Esc` | Exits the program (or goes to standby, if configured as such)
| `Spacebar` | Toggles between full-screen and windowed mode
| `W` | What's That? Shows visualization and FX names
| `T` | Track Info: Shows music details (if enabled in config)
| `P` | Popup: Toggle display of playlist visualizer/FX names
| `V` | Visualization details: filenames and other viz/FX information
| `S` | Statistics: frame rate, resolution, etc. like `--info` returns
| `>` | Immediately clear any text overlay
| `Enter` | In full-screen mode, moves display to the next monitor (v4.2.0)

Some keys are only available or change behavior in certain modes:

| Key | Action                                                               |
|---|----------------------------------------------------------------------|
| `→` | Playlist: right-arrow advances to the next visualization             
| `↓` | Playlist: down-arrow applies a random post-processing FX             
| `X` | Playlist: extends auto-advance timer by 1 minute (v4.1.0)            
| `A` | Playlist: pause auto-advance timer (`→` or `--next` resumes; v4.1.0) 
| `+` `-` | Test: advance during the `--test [viz/fx/fade]` command modes
| `Q` | Test: quit test mode (like `--endtest`, loads the idle viz)          
| `R` | Test: reloads the current combination                                
| `Backspace` | Immediate screenshot (jpg format)                                    
| `Spacebar` | Screenshot: saves after the `--jpg wait` or `--png wait` commands    

## Errors and Logging

By default, warnings and errors are written to `mhh.log` in the application directory. The log file is overwritten each time the program is executed. Log level can be changed on-the-fly with the `--log` switch. The config file has a lot of features used to control logging, especially when troubleshooting. See the [Logging](logging.md) page for more information.
