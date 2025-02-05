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
   <title>Loris | Home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="hero">
   <div class="swiper hero-slider">
      <div class="swiper-wrapper">
         <div class="swiper-slide slide">
            <div class="content">
               <span>Order Now!</span>
               <h3>Milktea</h3>
               <a href="menu.php" class="btn">See Menus</a>
            </div>
            <div class="image">
               <img src="images/Milktea - Slider.png" alt="">
            </div>
         </div>
         <div class="swiper-slide slide">
            <div class="content">
               <span>Order Now!</span>
               <h3>Ice Coffee</h3>
               <a href="menu.php" class="btn">See Menus</a>
            </div>
            <div class="image">
               <img src="images/Ice Coffee - Slider.png" alt="">
            </div>
         </div>
         <div class="swiper-slide slide">
            <div class="content">
               <span>Order Now!</span>
               <h3>Meals</h3>
               <a href="menu.php" class="btn">See Menus</a>
            </div>
            <div class="image">
               <img src="images/Meals - Slider.png" alt="">
            </div>
         </div>
      </div>
      <div class="swiper-pagination"></div>
   </div>
</section>

<section class="category">

   <h1 class="title">Food Category</h1>

   <div class="box-container">
      <a href="category.php?category=Hot Brewed" class="box">
         <img src="images/Hot Brewed.png" alt="">
         <h3>Hot Brewed</h3>
      </a>
      <a href="category.php?category=Fruit Yogurt" class="box">
         <img src="images/Fruit Yogurt.png" alt="">
         <h3>Fruit Yogurt</h3>
      </a>
      <a href="category.php?category=Ice Coffee" class="box">
         <img src="images/Ice Coffee.png" alt="">
         <h3>Ice Coffee</h3>
      </a>
      <a href="category.php?category=Milktea" class="box">
         <img src="images/Milktea.png" alt="">
         <h3>Milktea</h3>
      </a>
      <a href="category.php?category=Non Coffee" class="box">
         <img src="images/Non Coffee.png" alt="">
         <h3>Non Coffee</h3>
      </a>
      <a href="category.php?category=Meals" class="box">
         <img src="images/Meals.png" alt="">
         <h3>Meals</h3>
      </a>
      <a href="category.php?category=Pastries" class="box">
         <img src="images/Pastries.png" alt="">
         <h3>Pastries</h3>
      </a>
      <a href="category.php?category=Snacks" class="box">
         <img src="images/Snacks.png" alt="">
         <h3>Snacks</h3>
      </a>
   </div>

</section>

<section class="products">

   <h1 class="title">Latest Dishes</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>₱</span><?= $fetch_products['price']; ?></div>
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

   <div class="more-btn">
      <a href="menu.php" class="btn">View All</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>
<script>
    var swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>

</body>
</html>