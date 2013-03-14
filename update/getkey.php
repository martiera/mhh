<?php

  /*

    All Emoncms code is released under the GNU Affero General Public License.
    See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org

  */


  // Connect to the database
  define('EMONCMS_EXEC', 1);
  require "../../../settings.php";
  require "../../../db.php";
  db_connect();

  //Get apikey
  $api_result = db_query("SELECT * FROM mhh_params where param='apikey'");
  $api_row = db_fetch_array($api_result);
  $apikey = trim($api_row['value']);

  echo $apikey;

?>

