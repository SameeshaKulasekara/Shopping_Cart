<?php

@include 'config.php';

if(isset($_POST['addproduct'])){
   $name = $_POST['name'];
   $unitprice = $_POST['unitprice'];
   $description = $_POST['description'];
   $qty = isset($row['Qty']) ? $row['Qty'] : 0;

   if(empty($name) || empty($unitprice) || empty($description)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO addproduct(name, unitprice, description) VALUES('$name', '$unitprice', '$description')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }
};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM addproduct WHERE id = $id");
   header('location:Addproduct.php');
};

if (isset($_POST['updateQuantity'])) {
   $id = $_POST['id'];
   $Qty = $_POST['Qty'];
   updateQuantity($conn, $id, $Qty);
}

function updateQuantity($conn, $id, $Qty)
{
   $updateQuery = "UPDATE addproduct SET Qty = '$Qty' WHERE id = '$id'";
   $result = mysqli_query($conn, $updateQuery);
   if ($result) {
      header('Location: cart.php');
      // exit();
   } else {
      $message[] = 'Failed to update quantity.';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
   <div class="addproduct-form-container">
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>Add new product</h3>
         <div class="lable">
            <lable>Name</lable><input type="text" placeholder="enter product name" name="name" class="box">
            <lable>Unit Price</lable><input type="number" placeholder="enter product unit price" name="unitprice" class="box">
            <lable>Description</lable><input type="text" placeholder="enter description" name="description" class="box">
         </div>
            <input type="submit" class="btn" name="addproduct" value="Add New">
            <input type="reset" class="btn" name="clear" value="Clear">
      </form>
   </div>

   <?php
      $select = mysqli_query($conn, "SELECT * FROM addproduct"); 
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Unit price</th>
            <input type="text"  name="Qty" class="box">            
            <th>Qty</th>
            <th>action</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['unitprice']; ?>LKR</td>
            <td>
                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="number" name="Qty" value="<?php echo isset($row['Qty']) ? $row['Qty'] : 0; ?>">
                        <button type="submit" name="updateQuantity">Update</button>
                     </form>
                  </td>
            <td>
               <a href="updateproduct.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="cart.php?addtocart=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-add"></i> Add To Cart </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>
</div>
</body>
</html>