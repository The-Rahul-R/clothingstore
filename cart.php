
<?php
session_start();
 include 'connection.php';
 $conn = Connect();
?>
<?php error_reporting (E_ALL ^ E_NOTICE); ?>


<html lang="en">
<title>User List</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type = "text/css" href ="css/cart.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="container">
  <div class="navbar">
    <div class="logo">
      <a href="index.html"><img src="https://i.ibb.co/kDVwgwp/logo.png" alt="RedStore" width="125px" /></a>
    </div>
    <nav>
      <ul id="MenuItems">
        <li><a href="index.php">Home</a></li>
        <li><a href="store.php">Products</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="account.html">Account</a></li>
      </ul>
    </nav>
    <a href="cart.html"><img src="https://i.ibb.co/PNjjx3y/cart.png" alt="" width="30px" height="30px" /></a>
    <img src="https://i.ibb.co/6XbqwjD/menu.png" alt="" class="menu-icon" onclick="menutoggle()" />
  </div>
</div>

<!-- cart items details -->
<?php
if(!empty($_SESSION["cart"]))
{
  ?>
  <div class="w3-container">
      <div class="w3-jumbo " align="center">
        <h1>Your Shopping Cart</h1>
        
        
        
      </div>
      <br>
    </div>
    <div class="w3-responsive" style="padding-left: 100px; padding-right: 100px;" >
<table class="w3-table w3-striped">
  <thead class="thead-dark">
<tr>
<th width="20%">Product image</th>   
<th width="20%">Product Name</th>
<th width="10%">Quantity</th>
<th width="10%">Price Details</th>
<th width="15%">Order Total</th>
<th width="5%">Action</th>
</tr>
</thead>


<?php  

$total = 0;
foreach($_SESSION["cart"] as $keys => $values)
{
?>
<tr>
<td><img src="<?php  echo $values["product_image"]?>"></td>    
<td><?php echo $values["product_name"]; ?></td>
<td><?php echo $values["product_quantity"] ?></td>
<td>&#8377; <?php echo $values["product_price"]; ?></td>
<td>&#8377; <?php echo number_format($values["product_quantity"] * $values["product_price"], 2); ?></td>
<td><a href="cart.php?action=delete&id=<?php echo $values["product_id"]; ?>"><i class="fa fa-trash fa-2x w3-text-red"></i></a></td>
</tr>
<?php 
$total = $total + ($values["product_quantity"] * $values["product_price"]);
}
?>
<tr>
<td colspan="3" align="right">Total</td>
<td align="right">&#8377; <?php echo number_format($total, 2); ?></td>
<td></td>
</tr>
</table>
        <br><br><br>        
<a href="cart.php?action=empty"><button class="w3-btn w3-red"><span class="fa-trash fa fa-2x"></span> Empty Cart</button></a>
<a href="store.php" style="padding-left: 20px"><button class="w3-btn w3-sand"><span class="fa-shopping-bag fa fa-2x"></span> continue to shop</button></a>  
<a href="#" style="padding-left: 800px"><button class="w3-btn w3-pale-green"><span class="fa-credit-card fa fa-2x"></span> Checkout</button></a>        
        
<?php
}
if(empty($_SESSION["cart"]))
{
  ?>
  <div class="w3-container">
      <div class="w3-jumbo">
        <h1>Your Shopping Cart</h1>
        <p>your cart is empty!. Go back and <a href="store.php">order now.</a></p>
        
      </div>
      
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
}
?>
 
    
 
<?php


if(isset($_POST["add"]))
{
if(isset($_SESSION["cart"]))
{
$item_array_id = array_column($_SESSION["cart"], "product_id");
if(!in_array($_GET["id"], $item_array_id))
{
$count = count($_SESSION["cart"]);

$item_array = array(
'product_id' => $_GET["id"],
'product_name' => $_POST["hidden_name"],
'product_price' => $_POST["hidden_price"],
'product_quantity' => $_POST["quantity"],
'product_image' => $_POST["hidden_image"],    
        
);
$_SESSION["cart"][$count] = $item_array;
echo '<script>window.location="cart.php"</script>';
}
else
{
echo '<script>alert("Products already added to cart")</script>';
echo '<script>window.location="cart.php"</script>';
}
}


else
{
$item_array = array(
'product_id' => $_GET["id"],
'product_name' => $_POST["hidden_name"],
'product_price' => $_POST["hidden_price"],
'product_quantity' => $_POST["quantity"],
'product_image' => $_POST["hidden_image"],    
);
$_SESSION["cart"][0] = $item_array;
}
}
if(isset($_GET["action"]))
{
if($_GET["action"] == "delete")
{
foreach($_SESSION["cart"] as $keys => $values)
{
if($values["product_id"] == $_GET["id"])
{
unset($_SESSION["cart"][$keys]);
echo '<script>alert("product has been removed")</script>';
echo '<script>window.location="cart.php"</script>';
}
}
}
}


if(isset($_GET["action"]))
{
if($_GET["action"] == "empty")
{
foreach($_SESSION["cart"] as $keys => $values)
{

unset($_SESSION["cart"]);
echo '<script>alert("Cart is made empty!")</script>';
echo '<script>window.location="cart.php"</script>';

}
}
}


?>
    




<script>
  var MenuItems = document.getElementById('MenuItems');
  MenuItems.style.maxHeight = '0px';

  function menutoggle() {
    if (MenuItems.style.maxHeight === '0px') {
      MenuItems.style.maxHeight = '200px';
    } else {
      MenuItems.style.maxHeight = '0px';
    }
  }
</script>




</html>


