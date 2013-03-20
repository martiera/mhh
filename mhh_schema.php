<?php

$schema['mhh_nodes'] = array(
  'nodeid' => array('type' => 'int(11)'),
  'name' => array('type' => 'text'),
  'sync' => array('type' => 'tinyint(1)'),
  'lastsync' => array('type' => 'int(10)'),
  'lastvalue' => array('type' => 'decimal(10,2)'),
  'feedid' => array('type' => 'int(11)'),
  'filter' => array('type' => 'tinyint(1)')
);

$schema['mhh_params'] = array(
  'name' => array('type' => 'text'),
  'value' => array('type' => 'text')
);

$schema['mhh_relays'] = array(
  'id' => array('type' => 'int(11)'),
  'name' => array('type' => 'text'),
  'type' => array('type' => 'text')
);

$schema['mhh_noderelay'] = array(
  'nodeid' => array('type' => 'int(11)'),
  'relayid' => array('type' => 'int(11)'),
  'status' => array('type' => 'tinyint(1)'),
  'setstatus' => array('type' => 'tinyint(1)'),
  'type' => array('type' => 'int(10)')
);




?>
