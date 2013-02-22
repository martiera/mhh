<?php

  /*

    All Emoncms code is released under the GNU Affero General Public License.
    See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org

  */

  // IMPORTANT SET THIS TO A UNIQUE PASSWORD OF YOUR CHOICE
  //if ($_GET['key'] != "xTC7005d") die;

  set_time_limit (30);

  // Ensure only one instance of the script can run at any one time.
  $fp = fopen("importlock", "w");
  if (! flock($fp, LOCK_EX | LOCK_NB)) { echo "Already running\n"; die; }

  // Connect to the database
  define('EMONCMS_EXEC', 1);
  require "../../process_settings.php";
  require "../../db.php";
  db_connect();

  // Fetch the node queue
  $node_result = db_query("SELECT * FROM mhh_nodes where sync>0  ORDER BY `nodeid` asc");

  //Get apikey
  $api_result = db_query("SELECT * FROM mhh_params where param='apikey'");
  $api_row = db_fetch_array($api_result);
  $apikey = trim($api_row['value']);

  // For each item in the queue
  while($node_row = db_fetch_array($node_result))
  {
  $result = db_query("SELECT * FROM `input` WHERE `nodeid`=".trim($node_row['nodeid'])." and (`processList` like '%,1:%');");
  while($row = db_fetch_array($result))
  {

    $feedid = null;
    $input_processlist =  trim($row['processList']);
    if ($input_processlist)
    {
      $processlist = explode(",",$input_processlist);
      foreach ($processlist as $inputprocess)
      {
        $inputprocess = explode(":", $inputprocess);                            // Divide into process id and arg
        $processid = $inputprocess[0];                                          // Process id
        $arg = $inputprocess[1];                                                // Can be value or feed id

        if ($processid = "1")
        {
          $feedid = $arg;
        }

      }
    }

    $feedname = "feed_".trim($feedid);
    if (isset($node_row['lastsync']))
      { $lastsync = trim($node_row['lastsync']); } 
    else { $lastsync = 0; }
    if (isset($node_row['lastvalue']))
      { $lastvalue = trim($node_row['lastvalue']); } 
    else { $lastvalue = -255; }

    $feed_result = db_query("SELECT time, round(data,1) data FROM $feedname WHERE time>$lastsync ORDER BY time asc");

    $i = 0;
    while ($feed_row = db_fetch_array($feed_result))
    { 
      $lastsync=$feed_row['time'];
      $i = 1;
      if ($feed_row['data'] != $lastvalue)
      {
        $i = 0;
        $curl_result = do_post_request("http://myheathub.com/api/feeds", '{"id": "'.$feedid.'", "date": "'.$feed_row['time'].'", "temp": "'.$feed_row['data'].'"}', 'X-apikey: '.$apikey);
        if ($curl_result === "ok")
        {
          $lastvalue = trim($feed_row['data']);
          db_query("UPDATE mhh_nodes SET lastsync=".$lastsync.", lastvalue=".$lastvalue." WHERE nodeid=".trim($node_row['nodeid']).";");
        } else
        {
          break;
        }
      }
    }
    if ($i > 0) 
    {
      db_query("UPDATE mhh_nodes SET lastsync=".$lastsync.", lastvalue=".$lastvalue." WHERE nodeid=".trim($node_row['nodeid']).";");
//      echo "Transfer complete - $lastsync\n";
    }
//    echo "End fo script\n";
  }
  }

function do_post_request($url, $data, $optional_headers = null)
{
  $params = array('http' => array(
              'method' => 'POST',
              'content' => $data
            ));
  if ($optional_headers !== null) {
    $params['http']['header'] = $optional_headers;
  }
  $ctx = stream_context_create($params);
  $fp = @fopen($url, 'rb', false, $ctx);
//  if (!$fp) {
//    throw new Exception("Problem with $url, $php_errormsg");
//  }
  $response = @stream_get_contents($fp);
//  if ($response === false) {
//    throw new Exception("Problem reading data from $url, $php_errormsg");
//  }
  return $response;
}

?>

