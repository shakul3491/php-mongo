<?php
//echo phpinfo();exit;
require_once('dbconn.php');

$flag    = isset($_GET['flag'])?intval($_GET['flag']):0;
$message ='';
if($flag){
  $message = $messages[$flag];
}
//$filter = ['x' => ['$gt' => 1]]; 'sort' => ['_id' => 1], 'limit' => 5 , "projection" => ['category' => 0]
$filter = [ ];
$options = [
    'sort' => ['name' => -1], 
];

if (isset($_POST['search'])) {

  //print_r($_POST['name']);
  $filter = [ 'name' => $_POST['name']];
  $query = new MongoDB\Driver\Query($filter, $options);
  $cursor = $manager->executeQuery('testdb.cars', $query);
  //exit;
} else {

$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('testdb.cars', $query);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php mongodb tutorial - view insert update delete records</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="logo">
                <h3>
                  PHP mongoDB Search, View, Insert, Update, Delete records
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="mini-layout">
                  <form name="search" method="post" style="float: right;">
                    <input type="name" name="name" placeholder="Car Name">
                    <input type="submit" class='btn' name="search" value="Search">
                  </form>
                   <form id="form1" name='form1' action="record_add.php" method="post">
                   <input type='hidden' name='id' id='id' value="" />
                    <table>
                      <tr>
                        <td><input type='text' name='name' id='name' placeholder="Car Name" /></td>
                        <td><input type='text' name='price' id='price' placeholder="Price" /></td>
                        <!-- <td><input type='text' name='category' id='category' placeholder="Category" /></td> -->
                        <td><input class='btn' type='submit' name='btn' id='btn' value="Add Records" /></td>
                      </tr>
                    </table>
                   </form>
                    <h3>Products Listing</h3>
                    <p>
                      <?php if($flag == 2 || $flag == 5){ ?>
                        <div class="error"><?php echo $message; ?></div>
                      <?php  } elseif($flag && $flag != 2 ){ ?>
                        <div class="success"><?php echo $message; ?></div>
                      <?php  } ?>
                    </p>
                    <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Car Name</th>
                          <th>Price</th>
                          <!-- <th>Category</th> -->
                          <th>Action</th>
                        </tr>
                     </thead>
                    <?php 
                    $i =1; 
                    foreach ($cursor as $document) { ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $document->name;  ?></td>
                        <td><?php echo $document->price;  ?></td>
                        <!-- <td><?php echo $document->category;  ?></td> -->
                        <td><a class='editlink' data-id=<?php echo $document->_id; ?> href='javascript:void(0)'>Edit</a> |
                          <a onClick ='return confirm("Do you want to remove this record?");' href='record_delete.php?id=<?php echo $document->_id; ?>'>Delete</td>
                      </tr>
                   <?php $i++;  
                    } 
                  ?>
                    </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
$(function(){
  $('.editlink').on('click', function(){
    var id = $(this).data('id');
    if(id){
      $.ajax({
          method: "GET",
          url: "record_ajax.php",
          data: { id: id}
        })
        .done(function( result ) {
          result = $.parseJSON(result);
          $('#name').val(result['name']);
          $('#price').val(result['price']);
          //$('#category').val(result['category']);
          $('#id').val(result['id']);
          $('#btn').val('Update Records');
          $('#form1').attr('action', 'record_edit.php');
        });
      }
    });
});

</script>
</body>
</html>
