#!/bin/bash
rm ./launcher.sh
rm ./upmhh
wget http://myheathub.com/download/launcher.sh
chmod u+x ./launcher.sh
api=`php getkey.php`
wget -O upmhh http://myheathub.com/download.php?id=${api}
chmod u+x ./upmhh
