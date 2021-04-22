<?php


require_once __DIR__ . '/ThriftSQL.phar';


$hive = new \ThriftSQL\Hive('172.20.103.38', 10000, 'hive', 'hive');
$hiveTables = $hive
  ->connect()->getIterator('select * from tbd.agent_type');


echo "<pre>";
print_r($hiveTables);
echo "<pre>";

foreach ($hiveTables as $rowNum => $row) {
  echo "<pre>";
  print_r($row);
  echo "</pre>";
}


$hive->disconnect();
