<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $details = $_POST['dtls'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $med_price = $_POST['med_price'];
   $med_price = filter_var($med_price, FILTER_SANITIZE_STRING);
   $large_price = $_POST['large_price'];
   $large_price = filter_var($large_price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'Product Name Already Exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'Image Size Is Too Large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, details,category, price, med_price, large_price, image) VALUES(?,?,?,?,?,?,?)");
         $insert_product->execute([$name,$details,$category, $price, $med_price, $large_price, $image]);

         $message[] = 'New Product Added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Loris | Products</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
      <h3>Add Product</h3>
      <input type="text" required placeholder="Enter Product Name" name="name" maxlength="100" class="box">
      <textarea name="dtls" class="box" required placeholder="Enter Product Details" maxlength="500" cols="10" rows="5"></textarea>
      <input type="number" placeholder="Enter Product Price" name="price" class="box" id="productPrice">
      <input type="number" placeholder="Enter Medium Price (Drinks Only!)" name="med_price" id="med_price" maxlength="100" class="box">
      <input type="number" placeholder="Enter Large Price (Drinks Only)" name="large_price" id="large_price" maxlength="100" class="box">
      <select name="category" id="category" class="box" required>
         <option value="" disabled selected>-- Select Category --</option>
         <option value="Meals">Meals</option>
         <option value="Pastries">Pastries</option>
         <option value="Snacks">Snacks</option>
         <option value="Hot Brewed">Hot Brewed</option>
         <option value="Ice Coffee">Ice Coffee</option>
         <option value="Non Coffee">Non Coffee</option>
         <option value="Milktea">Milktea</option>
         <option value="Fruit Yogurt">Fruit Yogurt</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_products = $conn->prepare("SELECT * FROM `products`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="flex">
         <?php if ($fetch_products['category'] == "Meals" || $fetch_products['category'] == "Snacks" || $fetch_products['category'] == "Pastries") { ?>
            <div class="price">₱<?= $fetch_products['price']; ?><span></span></div>
         <?php } else { ?>
            <div class="price">
               ₱<?= $fetch_products['med_price']; ?> - ₱<?= $fetch_products['large_price']; ?>
            </div>
         <?php } ?>
         <div class="category"><?= $fetch_products['category']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <h1>Details:</h1>
      <div class="name"><?= $fetch_products['details']; ?></div>
      <div class="availability"><?= $fetch_products['availability']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete This Product?');">Delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Product is not currently available!</p>';
      }
   ?>

   </div>

</section>


<!-- show products section ends -->

<!-- custom js file link  -->
<script>
   function togglePrices() {
      var category = document.getElementById("category").value;
      var medPrice = document.getElementById("med_price");
      var largePrice = document.getElementById("large_price");
      var productPrice = document.getElementById("productPrice");

      if (category === "Meals" || category === "Pastries" || category === "Snacks") {
         medPrice.style.display = "none";
         largePrice.style.display = "none";
         productPrice.style.display = "block";
      } else {
         medPrice.style.display = "block";
         largePrice.style.display = "block";
         productPrice.style.display = "none";
      }
   }

   document.getElementById("category").addEventListener("change", togglePrices);

   togglePrices();

   if (document.getElementById("category").value === "") {
      document.getElementById("med_price").style.display = "none";
      document.getElementById("large_price").style.display = "none";
      document.getElementById("productPrice").style.display = "block";
   }
</script>

<script src="../js/admin_script.js"></script>

</body>
</html>