<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

if ($_SERVER['PHP_SELF'] == '/index.php') {
   $page = 'index';
} else {
   $page = basename($_SERVER['PHP_SELF'], '.php');
}
?>

<header class="header">

   <section class="flex">

      <a href="index.php" class="logo">Loris | Cafe</a>

      <nav class="navbar">
         <a href="index.php" <?php echo ($page == 'index') ? 'class="active"' : ''; ?>>HOME</a>
         <a href="menu.php" <?php echo ($page == 'menu') ? 'class="active"' : ''; ?>>MENU</a>
         <a href="orders.php" <?php echo ($page == 'orders') ? 'class="active"' : ''; ?>>ORDERS</a>
         <a href="about.php" <?php echo ($page == 'about') ? 'class="active"' : ''; ?>>ABOUT</a>
         <a href="contact.php" <?php echo ($page == 'contact') ? 'class="active"' : ''; ?>>CONTACT</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">Profile</a>
            <a href="components/user_logout.php" onclick="return confirm('Logout on all sessions?');" class="delete-btn">Logout</a>
         </div>
         <?php
            }else{
         ?>
            <p class="name">Please login to make transactions!</p>
            <a href="login.php" class="btn">Login</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>