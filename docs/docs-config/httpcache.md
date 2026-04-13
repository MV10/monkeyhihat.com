# [httpcache] Section

This section controls the optional caching of texture and cubemap files downloaded by visualizers or FX configs. Refer to the _Visualization Configuration_ section for information about how this works from the viz/fx standpoint. The cache itself is just a directory on your system.

Cache limits are optional. Limits by age are only applied when the program starts. Limits by file count and total directory size are applied after each download is added to the cache. Cached files are removed by age (oldest removed first).

## Settings

`CacheEnabled` defaults to `true` and controls whether any caching is used. Note that if you disable the cache, any files in the cache are still there. You'd have to manually purge the cache if you want it completely gone. Note that downloads still work if caching is disabled, they just aren't saved for re-use.

`WindowsPath` and `LinuxPath` are blank by default. When blank, Windows uses `C:\Users\[username]\AppData\temp\monkeyhihat` and Linux uses `~/.cache/monkeyhihat`. Only the default directory will be created automatically. If you provide a specific path, it must exist or caching will be disabled at startup.

`MaxFileCount` defaults to 500, and 0 disables the limitation. When the number of cached files exceeds this count, the oldest file is deleted.

`MaxTotalMB` defaults to 500 (megabytes), and 0 disables the limitation. When the total size of the cache directory exceeds this limit, the oldest file is deleted.

`MaxAgeDays` defaults to 90, and 0 disables the limitation. This is only checked at program startup. Note that visualizer and FX configs can force a download, so if you need content that is updated frequently, you can still disable time-based limits or use long limits while still reading fresh data where desirable.

`PollingMS` is the frequency that the main thread checks for completed downloads. Downloading happens on a background thread, but OpenGL is not thread-safe, so the retrieved texture or cubemap must be uploaded to the GPU from the main thread. This defaults to 250 (milliseconds), and the minimum is 100.

`MaxDimension` defaults to 1920, and 0 disables the rule. When a file is retrieved, the longest side is compared to this limit and the file is resized if it is larger. The default of 1920 is enormous in texture terms but it allows for high-definition cubemaps (which, by definition, are only one-quarter the horizontal resolution of the source file). Note resizing of downloaded content applies whether caching is enabled or not.

`PlaceholderTexture` defaults to blank, which uses the internal `badtexture.jpg` while the file is being downloaded. Any filename you specify must be available in the configured `TexturePath` list. Individual viz/fx config files can override this. This setting applies to downloads whether caching is enabled or not.

## Related Commands

There are a series of command-line switches that relate to download caching.

`--cache purge` removes all cached content.

`--cache info` shows cache statistics (location, count, total size, limits).

`--cache add [url]` retrieves and caches a specific texture or cubemap.

`--cache find [url]` shows the details of the cached file if it is present.

`--cache list` shows all cached files and their details.

`--cache prefetch` goes through all of the visualizer and FX files based on the configured `VisualizerPath` and `FXPath` lists and retrieves every HTTP-referenced texture or cubemap and stores it in the cache. It will show a warning if the file count or total size limits are exceeded, but that won't interrupt downloading (which means older files get pruned from the cache as it goes).
