<?php 

/*$client = new MongoDB\Driver\Manager(
    'mongodb+srv://mongoUser:<mongoUser>@cluster0-elpyl.mongodb.net/test?retryWrites=true&w=majority');

var_dump($client);exit;*/
/*$manager = new MongoDB\Driver\Manager("mongodb://admin:Admin@123@cluster0-shard-00-00-reodz.mongodb.net:27017,cluster0-shard-00-01-reodz.mongodb.net:27017,cluster0-shard-00-02-reodz.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");//ssl=true
  $filter = [ ];
$options = [
    'sort' => ['_id' => -1],
];

$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('mongotest.test', $query);
    var_dump($cursor);*/
    $manager     =   new MongoDB\Driver\Manager("mongodb+srv://admin:Admin@123@cluster0-hubva.mongodb.net/test?retryWrites=true&w=majority");

		$query = new MongoDB\Driver\Query();
$db = $manager->executeQuery('student_db.student_records',$query);
  

		print_r($db);exit;

?>