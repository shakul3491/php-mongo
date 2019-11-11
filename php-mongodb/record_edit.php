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
      $id           = $_POST['id'];

      if(!$name || !$price || !$id){
        $flag = 5;
      }else{
          $insRec       = new MongoDB\Driver\BulkWrite;
          $insRec->update(['_id'=>new MongoDB\BSON\ObjectID($id)],['$set' =>['name' =>$name, 'price'=>$price]], ['multi' => false, 'upsert' => false]);
          $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
          $result       = $manager->executeBulkWrite('testdb.cars', $insRec, $writeConcern);
          if($result->getModifiedCount()){
            $flag = 4;
          }else{
            $flag = 2;
          }
      }
  }
  header("Location: index.php?flag=$flag");
  exit;
