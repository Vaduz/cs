#!/bin/bash --
PATH='/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin'
renice -19 `cat /usr/games/hlds/hlds.pid` > /dev/null
