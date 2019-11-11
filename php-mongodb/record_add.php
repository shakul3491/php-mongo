<?php
  require_once('dbconn.php');
  $name = '';
  $price        = 0;
  //$category     = '';
  $flag         = 0;
  if(isset($_POST['btn'])){
      $name = $_POST['name'];
      $price        = $_POST['price'];
      //$category     = $_POST['category'];

      if(!$name || !$price ){
        $flag = 5;
      }else{
          $insRec       = new MongoDB\Driver\BulkWrite;
          $insRec->insert(['name' =>$name, 'price'=>$price]);
          $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
          $result       = $manager->executeBulkWrite('testdb.cars', $insRec, $writeConcern);

          if($result->getInsertedCount()){
            $flag = 3;
          }else{
            $flag = 2;
          }
      }
  }
  header("Location: index.php?flag=$flag");
  exit;
