<?php

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);
      $category = $_POST['category']; // Added to fetch category
      $category = filter_var($category, FILTER_SANITIZE_STRING);

      if ($category == 'Meals' || $category == 'Snacks' || $category == 'Pastries') {
         $price = $_POST['price'];
         $size = '';
      } else {
         $size = $_POST['size'];
         if ($size == 'Medium') {
            $price = $_POST['med_price'];
         } else if ($size == 'Large') {
            $price = $_POST['large_price'];
         }
      }

      $price = filter_var($price, FILTER_SANITIZE_STRING);

      // Check if the same product with the same size is already in the cart
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ? AND size = ?");
      $check_cart_numbers->execute([$pid, $user_id, $size]);

      if($check_cart_numbers->rowCount() > 0){
         // If the same product with the same size is already in the cart, update the quantity
         $fetch_cart = $check_cart_numbers->fetch(PDO::FETCH_ASSOC);
         $new_qty = $fetch_cart['quantity'] + $qty;
         $update_cart = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE pid = ? AND user_id = ? AND size = ?");
         $update_cart->execute([$new_qty, $pid, $user_id, $size]);
         $message[] = 'Quantity Updated in Cart!';
      } else {
         // If the product with the same size is not in the cart, insert it
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, size, price, quantity, image) VALUES(?,?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $size, $price, $qty, $image]);
         $message[] = '1 Product is Added to Cart!';
      }

   }

}
?>