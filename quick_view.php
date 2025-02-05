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
   <title>Loris | Quick View</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="title">Quick View</h1>

   <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
      <input type="hidden" name="category" value="<?= $fetch_products['category']; ?>">
      <input type="hidden" name="med_price" value="<?= $fetch_products['med_price']; ?>">
      <input type="hidden" name="large_price" value="<?= $fetch_products['large_price']; ?>">
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <h1 class="fntdtl">Details:</h1>
      <div class="details">"<?= $fetch_products['details']; ?>"</div>
      <div class="availability"><?= $fetch_products['availability']; ?></div>
      <div class="flex">
         <?php 
            if ($fetch_products['availability'] == "Available") {
               if ($fetch_products['category'] == "Meals" || $fetch_products['category'] == "Snacks" || $fetch_products['category'] == "Pastries") {
                  echo '<div class="price">₱'.$fetch_products['price'].'</div>';
               } else {
                  echo '<div class="price">';
                  echo '<input type="radio" name="size" value="Medium" onclick="updatePrice(\'Medium\', '.$fetch_products['med_price'].', '.$fetch_products['large_price'].', \'price_'.$fetch_products['id'].'\')" required>₱'.$fetch_products['med_price'].' | Medium <br>';
                  echo '<input type="radio" name="size" value="Large" onclick="updatePrice(\'Large\', '.$fetch_products['large_price'].', '.$fetch_products['large_price'].', \'price_'.$fetch_products['id'].'\')" required>₱'.$fetch_products['large_price'].' | Large';
                  echo '</div>';
               }
               echo '<input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">';
               echo '<button type="submit" name="add_to_cart" class="cart-btn">Add To Cart</button>';
            } else {
               echo '<p class="empty">Product is not currently available!</p>';
            }
         ?>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">Product is not currently available!</p>';
      }
   ?>

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
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>