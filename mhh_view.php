<?php
  /*

  All Emoncms code is released under the GNU Affero General Public License.
  See COPYRIGHT.txt and LICENSE.txt.

  ---------------------------------------------------------------------
  Emoncms - open source energy visualisation
  Part of the OpenEnergyMonitor project:
  http://openenergymonitor.org
 
  */

?>

<h2>MyHeatHub</h2>

<div style="width:400px; float:left;">
<form action="set" method="GET" >
<p><b>MyHeatHub local settings: </b></p>

<p>Gas counter value<br><input type="text" name="gascounter" value="<?php echo $settings['gascounter']; ?>" /></p>

<br><input type="submit" class="btn" value="Save" />

</div>

<div style="width:400px; float:left;" >
<p><b>MyHeatHub server settings</b></p>

<p>MHH apikey<br><input type="text" name="mhhapikey" value="<?php echo $settings['apikey']; ?>" /></p>
<p>Local keep days<br><input type="text" name="keepdays" value="<?php echo $settings['keepdays']; ?>" /></p>
<p><b>Last synced values: </b><?php $date = new DateTime(); $date->setTimestamp($settings['lastsync']); echo $date->format('Y.m.d H:i:s'); ?></p>
<p><b>Last MHH sync run: </b><?php $date = new DateTime(); $date->setTimestamp($settings['mhhexec']); echo $date->format('Y.m.d H:i:s'); ?></p>

</form>
</div>
