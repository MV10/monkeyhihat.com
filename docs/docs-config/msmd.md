# [msmd] Section

The _msmd_ section is used by the [monkey-see-monkey-do](https://github.com/MV10/monkey-see-monkey-do) background service, which can launch Monkey Hi Hat if commands are received while it is not running. It will start Monkey Hi Hat, then relay the commands to it.

`UnsecuredRelayPort` is 50002 by default. This is the TCP port MSMD listens to on the local network. If it is not specified the service will log an error and exit. Like the Monkey Hi Hat _UnsecuredPort_ setting in the [setup] section, the word "Unsecured" is just a reminder that it shouldn't be exposed to the Internet or any public network.

`RelayIPType` defaults to 0 but the config template sets this to 4. This restricts the service to IPv4 or IPv6 for localhost name resolution. Setting it to 0 queries both IPv4 and IPv6. Due to an issue in the runtime's socket-handling layer it can be very slow to query IPv6 when the network isn't actually using IPv6. Most small and home networks only need IPv4.

`LaunchWaitSeconds` defaults to 5 seconds, but the config template sets this to 9. This is how long the service waits for the application to start before it relays the commands it received.
