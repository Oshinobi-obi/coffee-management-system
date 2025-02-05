<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

   $address = $_POST['City'] .', '.$_POST['Barangay'].', '.$_POST['Street_Name'].', '.$_POST['Building'] .', '. $_POST['House_Number'] .' - '. $_POST['Postal_Code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'Address Saved!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Loris | Update Address</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form autocomplete="off" action="" method="post">
      <h3>Your Address</h3>
      <input type="text" class="box" placeholder="City." required maxlength="50" name="City">
      <input type="text" class="box" placeholder="Barangay." required maxlength="50" name="Barangay">
      <input type="text" class="box" placeholder="Street Name." required maxlength="50" name="Street_Name">
      <input type="text" class="box" placeholder="Building." required maxlength="50" name="Building">
      <input type="text" class="box" placeholder="House Number." required maxlength="50" name="House_Number">
      <input type="number" class="box" placeholder="Postal Code" required min="0" maxlength="4" name="Postal_Code">
      <input type="submit" value="save address" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php' ?>
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>