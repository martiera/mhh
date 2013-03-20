#!/bin/bash
api=`php /var/www/emoncms/Modules/mhh/update/getkey.php`
cd ~/
rm ./launcher.sh
rm ./upmhh
wget http://myheathub.com/download/launcher.sh
chmod u+x ./launcher.sh
wget -O upmhh http://myheathub.com/download.php?id=${api}
chmod u+x ./upmhh
nohup ~/launcher.sh >/dev/null 2>&1 &
