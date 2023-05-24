<?php
@include 'config.php';

function calculateTotalPrice($conn)
{
   $totalPrice = 0;
   $select = mysqli_query($conn, "SELECT * FROM addproduct WHERE Qty > 0");
   while ($row = mysqli_fetch_assoc($select)) {
      $Qty = $row['Qty'];
      $unitprice = $row['unitprice'];
      $totalPrice += ($Qty * $unitprice);
   }
   return $totalPrice;
}

if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM addproduct WHERE id = $id");
   header('location: Addproduct.php');
   exit();
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
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>

<?php
if (isset($message)) {
   foreach ($message as $msg) {
      echo '<span class="message">' . $msg . '</span>';
   }
}
?>

   <div class="cart-section">
      <h3>Shopping Cart</h3>
      <table class="cart-table">
         <thead>
            <tr>
               <th>Product</th>
               <th>Price</th>
               <th>Quantity</th>
               <th>Total</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $select = mysqli_query($conn, "SELECT * FROM addproduct WHERE Qty > 0");
            while ($row = mysqli_fetch_assoc($select)) {
               $Qty = $row['Qty'];
               $unitprice = $row['unitprice'];
               $total = $Qty * $unitprice;
               mysqli_query($conn, "UPDATE addproduct SET Qty = $Qty WHERE id = {$row['id']}");
            ?>
               <tr>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $unitprice; ?></td>
                  <td><?php echo $Qty; ?></td>
                  <td><?php echo $total; ?></td>
                  <td>
                  <div class="w3-padding w3-xlarge w3-teal">
                  <a href="Addproduct.php?delete=<?php echo $row['id']; ?>"><i class="w3-margin-left material-icons">close</i></p>
            </div></td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
      <p><b>Cart Total: <?php echo calculateTotalPrice($conn); ?></b></p>
      <button type="button" class="btn btn-primary" onclick="emptyCart()">Empty Cart</button>
     </div>

<script>
function emptyCart() {
  var confirmation = confirm("Are you sure you want to empty the cart?");
  if (confirmation) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "empty.php", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          alert(response.message);
          location.reload(); 
        } else {
          alert("Failed to empty the cart. Please try again.");
        }
      }
    };
    xhr.send();
  }
}
</script>

</body>
</html>
