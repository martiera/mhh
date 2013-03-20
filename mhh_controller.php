<?php
  /*

  All Emoncms code is released under the GNU Affero General Public License.
  See COPYRIGHT.txt and LICENSE.txt.

  ---------------------------------------------------------------------
  Emoncms - open source energy visualisation
  Part of the OpenEnergyMonitor project:
  http://openenergymonitor.org
 
  */

  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  function mhh_controller()
  {
    include "Modules/mhh/mhh_model.php";
    global $session, $route;

    $format = $route['format'];
    $action = $route['action'];

    $output['content'] = "";
    $output['message'] = "";

    if ($action == "view" && $session['write'])
    { 
      $settings = mhh_get();
      if ($format == 'html') $output['content'] = view("mhh/mhh_view.php", array('settings'=>$settings));
    }

    if ($action == "set" && $session['write'])
    { 
      $keepdays = intval(get('keepdays'));
      $gascounter = get('gascounter');
      $apikey = db_real_escape_string(preg_replace('/[^.\/A-Za-z0-9]/', '', get('mhhapikey')));

      mhh_set($apikey,$keepdays,$gascounter);

      $output['message'] = "MyHeatHub settings updated"; 
    }

    return $output;
  }

?>
