<?php
// This generates a username for you if you don't want to make one up.
$randomUser = get_current_user() . substr(md5(uniqid(true)), 2, 8);

// IRC EFNET server address. Change this only if you have issues.
define('SCRAPE_IRC_EFNET_SERVER', 'irc.Prison.NET');
// Port for the efnet server.
define('SCRAPE_IRC_EFNET_PORT', '6667');
// IRC Corrupt.net address.
define('SCRAPE_IRC_CORRUPT_SERVER', 'irc.corrupt-net.org');
// Port for the corrupt server.
define('SCRAPE_IRC_CORRUPT_PORT', '6667');
// Nick name in the IRC channel.
define('SCRAPE_IRC_EFNET_NICKNAME', "$randomUser");
define('SCRAPE_IRC_CORRUPT_NICKNAME', "$randomUser");
// User name, used to log in to the server (like a ZNC server). Use the same as Nick name if you don't know what this is for.
define('SCRAPE_IRC_EFNET_USERNAME', "$randomUser");
define('SCRAPE_IRC_CORRUPT_USERNAME', "$randomUser");
// Password used to log in to the server (like a ZNC server). Leave false if you don't require a password.
define('SCRAPE_IRC_EFNET_PASSWORD', false);
define('SCRAPE_IRC_CORRUPT_PASSWORD', false);
// "Real name" for IRC server. Use the same as Nick name if you don't know what this is for.
define('SCRAPE_IRC_EFNET_REALNAME', "$randomUser");
define('SCRAPE_IRC_CORRUPT_REALNAME', "$randomUser");