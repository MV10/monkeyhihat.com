# DJ and VJ Notes

## New for Version 5.0.0

The features described on this page apply to version 5.0.0 and later.


## Line-Level Audio

Rather than relying on playback (and system volume level), as is normally done for at-home use, the program supports any audio capture source on the computer -- the line-in or microphone jack, for example. When properly configured, the input does not have to be "audible" on the PC.

#### Windows Line-Level Audio

Under the Windows Sound API (WASAPI), a device will not be "known" until it is actually used. After that it will be remembered even if it is not connected, so for this to work you should plug in something which actively generates output into line-in or mic-in at least once.

You will need to know the "Friendly Name" of the device, which goes into the configuration file as the `CaptureDeviceName` in the `[windows]` section. Run MHH with the `--devices` command. You will see output similar to this:

```
WASAPI Device Information (excluding "Not Present" devices)
---------------------------------------------------------------

Playback devices:
  Digital Audio (S/PDIF) (Realtek(R) Audio) (Disabled)
  CABLE Input (VB-Audio Virtual Cable) (Disabled)
  DELL U4323QE (NVIDIA High Definition Audio) (Active)

Capture devices:
  Line In (Realtek(R) Audio) (Unplugged)
  CABLE Output (VB-Audio Virtual Cable) (Disabled)
  Microphone (Realtek(R) Audio) (Active)

Default devices:
  Playback: DELL U4323QE (NVIDIA High Definition Audio)
  Capture:  Microphone (Realtek(R) Audio)
```

Notice the `Microphone` capture device is marked `(Active)`. To respond to audio from that, modify the `CaptureDeviceName` setting in your configuration file (typically `mhh.conf` in the application directory).

> The device name must match _exactly_ or it will not be found.

```
[windows]
LoopbackApi=WindowsInternal
CaptureDeviceName=Microphone (Realtek(R) Audio)
```

#### Linux Line-Level Audio

Most modern Linux systems are using PipeWire, and that's all I have tested on and will be able to support. In the past I also ran this with Pulse Audio, and it worked, although I had to manually configure a default capture device. PipeWire seems to do a much better job of "noticing" things plugged into line-in or mic-in and temporarily making them the default. You can, of course, use other programs to change the configuration. Under Linux, the capture devices will have their own volume level.

You will need to know the "Friendly Name" of the device, which goes into the configuration file as the `CaptureDeviceName` in the `[linux]` section. The config also allows you to specify a `OpenALContextDeviceName`, but normally you will leave this blank to use the `OpenAL Soft` default. Run MHH with the `--devices` command. You will see output similar to this:

```
OpenAL Device Information
---------------------------------------------------------------

Context devices:
  OpenAL Soft

Default context device:
  OpenAL Soft
  Using: "OpenAL Soft"

Playback devices:
  TU104 HD Audio Controller Digital Stereo (HDMI 2)

Capture devices:
  Starship/Matisse HD Audio Controller Analog Stereo
  Monitor of TU104 HD Audio Controller Digital Stereo (HDMI 2)

Default devices:
  Playback: TU104 HD Audio Controller Digital Stereo (HDMI 2)
  Capture: Starship/Matisse HD Audio Controller Analog Stereo

---------------------------------------------------------------

Currently running media player services:
  spotify (Playing: Some Shit About Love / 10 Lives / Saliva)
  brave.instance2343 (Stopped)

---------------------------------------------------------------
```

In this case, I have an audio source connected to the motherboard's line-in jack, so PipeWire made the motherboard the default capture device, named `Starship/Matisse HD Audio Controller Analog Stereo`. Since that is the default, nothing has to be specified in the config file. But notice the HDMI audio source is also listed under "Capture Devices." If I had a source plugged into line-in but wanted to use HDMI, I'd have to set it in the config file:

> The device name must match _exactly_ or it will not be found.

```
[linux]
LoopbackApi=OpenALSoft
OpenALContextDeviceName=
CaptureDeviceName=Monitor of TU104 HD Audio Controller Digital Stereo (HDMI 2)
```


## Streaming Images

Spout and NDI are two popular protocols for sharing realtime image data between applications. [Spout](https://spout.zeal.co/) is Windows-only and runs on the local PC. [NDI](https://ndi.video/) is cross-platform, it can run over networks, dedicated hardware is available, and it can integrate with professional-grade mixers, broadcast systems, and even video camera feeds.

You can only use one of the streaming systems at a time. You can send or receive, but not both. Sending is as easy as turning it on. Receiving will require writing custom shaders to use the received images. Audio is not supported.

[OMT](https://www.openmediatransport.org/) is another popular cross-platform send/receive protocol which is similar to NDI. I am evaluating adding support.


## Spout Support

Spout is a Windows-only protocol (it uses Microsoft's DirectX graphics API). Enabling Spout output to other applications on the same PC is easy. The Spout name is always _Monkey Hi Hat_. Simply change the `SpoutSender` setting in your configuration file to true:

```
[windows]
SpoutSender=true
```

Spout input is supported, but you will need to write visualizer or FX shaders to support it. The test shader [`streaming.conf`](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/streaming.conf) has comments that explain all the necessary visualizer / FX settings. In the config file, you must provide the sender name and an optional flag indicating if the image needs to be vertically flipped (normally it does, and this defaults to true if omitted):

```
[windows]
SpoutReceiveFrom= sending_program_name
SpoutReceiveInvert= true
```

A placeholder image is shown until the sender is available. If the sending program stops or becomes unreachable, the last image it sent is preserved as long as the shader is running.


## NDI Support

NDI is a cross-platform protocol. Enabling NDI output to other NDI devices locally and on the LAN is easy. There is an `[ndi]` section in the `mhh.conf` application config file. Change the `NDISender` setting to true, and if desired, specify an `NDIDeviceName`, otherwise the name _Monkey Hi Hat_ will be used. You can also specify a comma-delimited `NDIGroupList` to limit where this output is visible.

```
[ndi]
NDISender=true
NDIDeviceName=DJ Baby Anne Studio Viz Box
NDIGroupList=studio,monitor
```

The first time you run in send mode on Windows, the Windows Firewall may prompt you to allow network access. Click Ok and you will not be prompted again.

NDI input is supported, but you will need to write visualizer or FX shaders to support it. The test shader [`streaming.conf`](https://github.com/MV10/monkey-hi-hat/blob/master/testcontent/streaming.conf) has comments that explain all the necessary visualizer / FX settings. In the config file, you must provide the machine and sender name in the format shown below, and an optional flag indicating if the image needs to be vertically flipped (normally it does, and this defaults to true if omitted):

```
[windows]
NDIReceiveFrom= MACHINE_NAME (SENDER NAME)
NDIRecieveInvert= true
```

A placeholder image is shown until the sender is available. If the sending program stops or becomes unreachable, the last image it sent is preserved as long as the shader is running.


## Troubleshooting Received Images

If the received images are blank, dim, or darkly discolored, check the final output shader (either the visualization's final pass, or the post-processing FX's final pass). The output color's alpha (transparency) channel should always be 1.0. Because Monkey Hi Hat and Shadertoy don't care about the alpha channel, sometimes it is set to zero, or calculated to some interim value as a side-effect. Some Spout and NDI clients render in a way that alpha is blended with a black background.

I try to ensure it doesn't happen in the installed shaders (when Spout and NDI support was added, I had to fix more than 30 shaders). If you see this problem with a visualizer or FX that shipped with Monkey Hi Hat, please open an Issue to report it in the [Volt's Laboratory](https://github.com/MV10/volts-laboratory/issues) repository where MHH shaders are kept and I will fix it.


## Spout / NDI Commands

Several commands are available for controlling streaming content:

  * `--streaming status`
  * `--streaming send spout|ndi "sender name" ["spout_group_list"]`
  * `--streaming receive spout "sender name"`
  * `--streaming receive ndi "machine (sender name)"`
  * `--streaming stop send|receive`

Note that you may only receive from a single source at any time.
