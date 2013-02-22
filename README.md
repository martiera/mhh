#MyHeatHub emoncms module

The MyHeadHub module for Emoncms will be middleware for two systems to synchronize data. With that possibility Emoncms can be used to monitor and control heating.

##Features:
- possibility to send data from emoncms to myheadhub (optional)
- makes raspberrypi_run.php to run as daemon
- enables monitoring for critical damens

##Requirements
- Raspberry PI emoncms module (https://github.com/emoncms/raspberrypi)
- monit (sudo apt-get install monit)

##Installation
###To run raspberrypi_run.php as daemon:
- modify script shl/rpic and set variables RPI_BIN and RPI_SCRIPT according to your Emoncms installation
- sudo cp shl/rpic /etc/init.d/
- sudo update-rc.d rpic defaults
- sudo service rpic start
Service will be started and log file will be available at /var/log/rpic.log

###To enable daemon monitoring:
- sudo apt-get install monit
- edit monit configuration file (sudo vi /etc/monit/monitrc) and uncomment 3 lines starting with "set httpd port 2812 and" "
- sudo cp shl/monitrc/rpic /etc/monit/conf.d/   (for raspberrypi_run.php)
- sudo cp shl/monitrc/mysql /etc/monit/conf.d/  (for MySQL)
- sudo cp shl/monitrc/sshd /etc/monit/conf.d/   (for SSH)
- sudo cp shl/monitrc/apache /etc/monit/conf.d/ (for Apache)
- sudo monit quit      (stop monit process)
- sudo monit           (start monit process)
- sudo monit start all (enable monitoring for all daemons)
- sudo monit status    (see status of monitored daemons)
