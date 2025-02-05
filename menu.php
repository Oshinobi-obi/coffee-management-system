<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Loris | Menu</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- Here is Drinks Section with Radio Button -->
<section class="products">

   <h1 class="title">Drinks</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE `category` IN ('Fruit Yogurt','Hot Brewed','Ice Coffee','Milktea','Non Coffee')");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" id="price_<?= $fetch_products['id']; ?>" name="price" value="<?= $fetch_products['med_price']; ?>">
         <input type="hidden" name="med_price" value="<?= $fetch_products['med_price']; ?>">
         <input type="hidden" name="large_price" value="<?= $fetch_products['large_price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <input type="hidden" name="category" value="<?= $fetch_products['category']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <?php
            if ($fetch_products['availability'] == "Available") {
               echo '<button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>';
            } else {
               echo '<button type="button" class="fas fa-shopping-cart" disabled></button>';
            }
         ?>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="availability"><?= $fetch_products['availability']; ?></div>
         <div class="flex">
            <div class="price">
               <input type="radio" name="size" value="Medium" onclick="updatePrice('Medium', <?= $fetch_products['med_price']; ?>, <?= $fetch_products['large_price']; ?>, 'price_<?= $fetch_products['id']; ?>')" required><span>₱</span><?= $fetch_products['med_price']; ?> | Medium <br>
               <input type="radio" name="size" value="Large" onclick="updatePrice('Large', <?= $fetch_products['large_price']; ?>, <?= $fetch_products['large_price']; ?>, 'price_<?= $fetch_products['id']; ?>')" required><span>₱</span><?= $fetch_products['large_price']; ?> | Large
            </div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">Product is not currently available!</p>';
         }
      ?>

   </div>

</section>

<!-- Here is Meals Section -->
<section class="products">

   <h1 class="title">Meals / Snacks / Pastries</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE `category` IN ('Meals','Snacks','Pastries')");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <input type="hidden" name="category" value="<?= $fetch_products['category']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <?php
            if ($fetch_products['availability'] == "Available") {
               echo '<button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>';
            } else {
               echo '<button type="button" class="fas fa-shopping-cart" disabled></button>';
            }
         ?>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="availability"><?= $fetch_products['availability']; ?></div>
         <div class="flex">
            <div class="price"><span>₱</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty1" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">Product is not currently available!</p>';
         }
      ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script>
   function updatePrice(size, medPrice, largePrice, priceFieldId) {
      if (size === 'Medium') {
         document.getElementById(priceFieldId).value = medPrice;
      } else if (size === 'Large') {
         document.getElementById(priceFieldId).value = largePrice;
      }
   }
</script>

<script src="js/script.js"></script>

</body>
</html>