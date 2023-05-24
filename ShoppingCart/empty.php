<?php

session_start(); 

$_SESSION['cart'] = array(); 

$response = array(
    'success' => true,
    'message' => 'Cart emptied successfully'
);
echo json_encode($response);

?>

