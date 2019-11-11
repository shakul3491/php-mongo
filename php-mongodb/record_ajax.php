<?php
require_once('dbconn.php');
$id    = $_GET['id'];
$result = array();
if($id){
  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
  $options = [
   'projection' => ['_id' => 0],
];
  $query = new MongoDB\Driver\Query($filter,$options);
  $cursor = $manager->executeQuery('testdb.cars', $query);
  foreach($cursor as $row){
    $result ['name'] = $row->name;
    $result ['price']        = $row->price;
    $result ['id']           = $id;
  }
  echo json_encode($result);
}
