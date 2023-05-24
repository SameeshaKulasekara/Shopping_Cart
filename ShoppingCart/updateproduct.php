<?php

@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){

   $name = $_POST['name'];
   $unitprice = $_POST['unitprice'];
   $description = $_POST['description'];

   if(empty($name) || empty($unitprice) || empty($description)){
      $message[] = 'please fill out all!';    
   }else{

      $update_data = "UPDATE addproduct SET name='$name', unitprice='$unitprice', description='$description'  WHERE id = '$id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
         header('location:Addproduct.php');
      }else{
         $$message[] = 'please fill out all!'; 
      }

   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

   <div class="container">

   <div class="addproduct-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM addproduct WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
         <h3 class="title">Edit product</h3>
         <lable class="lable">Name</lable><input type="text" class="box" name="name" value="<?php echo $row['name']; ?>" placeholder="enter the product name">
         <lable class="lable">Unit Price</lable><input type="number" min="0" class="box" name="unitprice" value="<?php echo $row['unitprice']; ?>" placeholder="enter the product unit price">
         <lable class="lable">Description</lable><input type="text" class="box" name="description" value="<?php echo $row['description']; ?>" placeholder="enter the description">
         <input type="submit" value="update" name="update_product" class="btn">
         <a href="Addproduct.php" class="btn">Cancel</a>
   </form>

   <?php }; ?>
  
   </div>

</div>

</body>
</html>