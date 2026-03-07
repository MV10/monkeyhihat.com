# Playlist Configuration

## Configuration

A playlist is simply a collection of visualizations and FX which are displayed according to various timing and randomization settings. The repository's [`test_playlist.conf`](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/playlist/test_playlist.conf) test-content file documents the various features and options.

If silence detection doesn't seem to be working, run the _silence_ option from the eyecandy library's `demo` project. Some systems generate a low level of noise that isn't audible to you. Adjust the `DetectSilenceMaxRMS` value in the `mhh.conf` configuration file. For example, my $3000 desktop machine is "silent" at about 1.5, but my $50 Raspberry Pi works as low as 0.2. 

## Visualizer Settings

Visualizer `.conf` files support a `[Playlist]` section with a couple of settings documented in the repository's [`playlist.conf`](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/playlistoptions.conf) test-content visualizer file.

* `SwitchTimeHint` can extend or shorten the playback time of the visualizer when a playlist is using `Time` mode.

* `FXAddStartPercent` can boost or suppress the chance that an FX will be applied.

* The `[FX-Blacklist]` section lists any FX that should never be applied to the visualizer.
