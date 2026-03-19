# [text] Section

This section controls text popups (short notifications like visualizer names) and overlays (large blocks of information like frame-rate statistics). Some will alter basic font rendering and can usually be left at the defaults.

## Display Options

### Playlist Popups

When a playlist loads a new visualizer and/or applies an FX, a popup can be shown briefly with information about the shaders.

`ShowPlaylistPopups` defaults to true. It will show the names and descriptions of the visualizer and any FX that is active.

`ShowVizBylines` defaults to false. If true, when there is a new visualizer without an active FX, a third line of text is shown naming the author(s) and the origin of the visualization. This isn't shown when an FX is being applied to cut down on screen clutter.

`ShowTextBanners` defaults to false. If true, when the visualizer and/or FX changes, a line is shown across the bottom of the screen with a short blurb randomly selected from the [text-banners] section. (If you turn this on and the banner is in the middle of the screen, see the `TextBufferY` setting in the _Font Rendering_ section below.) The config template includes a couple of lines about Monkey Hi Hat such as the website's URL, and several amusing quotes and phrases about monkeys. DJ / VJ users could add custom entries pertaining to the event, business owners could list things like drink specials or trivia night, and so on.

`PopupFadeMilliseconds` defaults to 1000 (1 second). This controls how quickly the popup text appears and disappears.

`PopupVisibilitySeconds` defaults to 1 second but the config template sets this to 5 seconds. This is how long the popup text remains on screen before automatically clearing.

## [text-banners] Section

When the _ShowTextBanners_ setting (above) is true, the available banners are listed in the [text-banners] section, one per line. By default, the text buffer should be 97 characters wide, so no banner should exceed that length (and ideally you want to be about half of that for easy readability during the popup period).

There isn't anything special about it -- just make a list of the content you want to see.

Bear in mind the `#` hashtag is a comment character, so don't try to use it in a banner or the text will be truncated.

### Overlay Text

Some of the available commands show diagnostics information or other helpful text information. These are called overlays and are either permanent until dismissed, or remain visible for longer than the popups.

`OverlayPermanent` defaults to false. When true, any overlays must be cleared manually.

`OverlayVisibilitySeconds` defaults to 10 seconds. This controls when any non-permanent overlay automatically clears.

`OverlayUpdateMilliseconds` defaults to 500 (half a second). For informational overlays like frame rate, this determines the frequency at which the display data is updated.

## Font Rendering

Monkey Hi Hat has an internal font, but it is possible to generate and load custom fonts. That's currently beyond the scope of this documentation, although v5.4.0 ships a custom font texture which is discussed below. Typically the settings in this section don't need to be altered. For many of these, _very_ small changes can have a large effect. Most of these are "normalized" dimensions, which means they are relative to a range of 0.0 to 1.0, representing the screen space or font texture space.

`TextBufferX` and `TextBufferY` defines the size of the data block containing the text to generate. This defaults to 100 x 10 for historic reasons, but the config template sets this to 97 x 30, which are the optimal values to cover the entire screen using the other default settings. If you enable text banners (see above) and your banner is somewhere in the middle of the screen, your installation may have the original 10 row Y setting; change these to 97 x 30 to fix the problem.

`FontAtlastFilename` is blank by default, which uses the internal _font.png_ file. Any file you specify here should be somewhere in the configured list of texture paths.

`OutlineWeight` defaults to 0.55 which is generally good for the internal font atlas. This controls the dark outline around the white letters, which creates contrast against light backgrounds. This is extremely sensitive to small changes and will probably need to be tweaked if you use a different font atlas.

`CharacterSize` defaults to 0.02. It defines the square width / height of the on-screen character cells.

`PositionX` and `PositionY` default to 0.96 x 0.5 which defines the top left corner of the character cells. Basically this creates some offset from the screen edges. This may need to be fine-tuned if you use very unusual resolutions (some ultra-wide displays) or portrait mode.

### Alternate Font

Version 5.4.0 shipped with an alternate font atlas, [Kode Mono](https://fonts.google.com/specimen/Kode+Mono?preview.script=Latn) from Google.

To use this font apply these settings:

* `FontAtlasFilename=Font Kode Mono 1024x1024.png`
* `OutlineWeight=0.62`
