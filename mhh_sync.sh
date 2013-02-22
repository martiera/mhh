#!/bin/bash
while [ true ]
do
  # run this scripts randomly every 5-6min
  /usr/bin/php -q mhh_sync.php
  sleep $[ ( $RANDOM % 60 )  + 1 + 300 ]s
done
