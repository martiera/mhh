<?php
  /*

  All Emoncms code is released under the GNU Affero General Public License.
  See COPYRIGHT.txt and LICENSE.txt.

  ---------------------------------------------------------------------
  Emoncms - open source energy visualisation
  Part of the OpenEnergyMonitor project:
  http://openenergymonitor.org
 
  */

  function mhh_get()
  {
    $params = array();
    $result = db_query("SELECT * FROM mhh_params;");
    if ($result)
    {
      while ($row = db_fetch_array($result))
      {
        $params[$row['name']] = $row['value'];
      }
    }
    $result = db_query("SELECT max(lastsync) lastsync FROM mhh_nodes;");
    $row = db_fetch_array($result);
    if ($row) $params['lastsync'] = $row['lastsync'];

//    $result = db_query("SELECT data FROM feed_18 order by time desc limit 1;");
    $result = db_query("SELECT value FROM mhh_params where name='gascounter';");
    $row = db_fetch_array($result);
    if ($row)
    {
      $gasfeed = $row['value'];
      $gasresult = db_query("SELECT value FROM feeds where id=$gasfeed;");
      $gasrow = db_fetch_array($gasresult);
      if ($gasrow) $params['gascounter'] = $gasrow['value'];
    }

  return $params;

/*
    $result = db_query("SELECT value apikey FROM mhh_params where param='apikey'");
    $row = db_fetch_array($result);

    if (!$row)
    {
      db_query("INSERT INTO mhh_params ( param, value) VALUES ( 'apikey', 'YOURAPIKEY');");
      $result = db_query("SELECT value apikey FROM mhh_params where param='apikey'");
      $row = db_fetch_array($result);
    }
    return $row;
*/
  }

  function mhh_set($apikey,$keepdays,$gascounter)
  {
//    db_query("UPDATE raspberrypi SET `userid` = '$userid', `apikey` = '$apikey', `sgroup` = '$sgroup', `frequency` = '$frequency', `baseid` = '$baseid' ,`remotedomain` = '$remotedomain', `remotepath` = '$remotepath', `remoteapikey` = '$remoteapikey', `remotesend` = '$remotesend' ");
    //Update keep days
    db_query("UPDATE mhh_params SET value = '$keepdays' where name='keepdays';");

    //Update API key
    db_query("UPDATE mhh_params SET value = '$apikey' where name='apikey';");

    //Update gas counter
//    echo $settings['gascounter'];
    $result = db_query("SELECT value FROM mhh_params where name='gascounter';");
    $row = db_fetch_array($result);
    if ($row)
    {
      $gasfeed = $row['value'];
      db_query("UPDATE feeds SET value = '$gascounter' where id=$gasfeed;");
    }
  }

  function mhh_running()
  { 
    $time = time();
    db_query("UPDATE raspberrypi SET `running` = '$time' ");
  }

?>
