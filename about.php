<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit_review'])){
    if(!empty($user_id)){
        $review_text = $_POST['review_text'];
        $rate_price = $_POST['rate_price'];
        $rate_service = $_POST['rate_service'];
        $rate_food = $_POST['rate_food'];
        $datetime = date('Y-m-d H:i:s'); // Capture current date and time

        // Fetch user's name
        $user_query = "SELECT name FROM users WHERE id = :user_id";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bindParam(':user_id', $user_id);
        $user_stmt->execute();
        $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
        $name = $user ? $user['name'] : 'Anonymous';

        try {
            $insert_review_query = "INSERT INTO reviews (user_id, name, review_text, rate_price, rate_service, rate_food, datetime) VALUES (:user_id, :name, :review_text, :rate_price, :rate_service, :rate_food, :datetime)";
            $stmt = $conn->prepare($insert_review_query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':review_text', $review_text);
            $stmt->bindParam(':rate_price', $rate_price);
            $stmt->bindParam(':rate_service', $rate_service);
            $stmt->bindParam(':rate_food', $rate_food);
            $stmt->bindParam(':datetime', $datetime);
            $stmt->execute();
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } catch(PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }else{
        $error_message = "Please log in to leave a review.";
    }
}

$select_reviews_query = "SELECT * FROM reviews";
$select_reviews_result = $conn->query($select_reviews_query);
$reviews = $select_reviews_result->fetchAll(PDO::FETCH_ASSOC);

function display_stars($rating) {
    $output = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $output .= '<i class="fas fa-star"></i>';
        } else {
            $output .= '<i class="far fa-star"></i>';
        }
    }
    return $output;
}

function mask_name($name) {
    if (strlen($name) > 1) {
        return substr($name, 0, 1) . '**';
    }
    return $name;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Loris | About</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/barista.png" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>A lot of student from different school came to our shop.</p>
         <a href="menu.php" class="btn">our menu</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>choose order</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nesciunt, dolorem.</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>fast delivery</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nesciunt, dolorem.</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>enjoy food</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nesciunt, dolorem.</p>
      </div>

   </div>

</section>

<!-- steps section ends -->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="title">Customer's Reviews</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

         <!-- Display existing reviews -->
         <?php foreach($reviews as $review): ?>
         <div class="swiper-slide slide">
            <div class="review-content">
               <!-- Display masked name -->
               <p class="review-name"><?php echo mask_name($review['name']); ?></p>
               <!-- Display review content -->
               <p class="review-text"><?php echo $review['review_text']; ?></p>
               <!-- Display ratings -->
               <p>Price: <?php echo display_stars($review['rate_price']); ?></p>
               <p>Service: <?php echo display_stars($review['rate_service']); ?></p>
               <p>Food: <?php echo display_stars($review['rate_food']); ?></p>
               <!-- Display date -->
               <p class="review-date">Submitted on: <?php echo $review['datetime']; ?></p>
            </div>
         </div>
         <?php endforeach; ?>

      </div>

      <div class="swiper-pagination"></div>

   </div>

   <!-- Review form -->
   <div class="review-form">
      <h1 class="title">Leave a Review</h1>
      <?php if(isset($error_message)): ?>
      <div class="error-message"><?php echo $error_message; ?></div>
      <?php endif; ?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
         <textarea name="review_text" placeholder="Write your review here..."></textarea>
         <div class="rating-container">
            <label for="rate_price">Price Rating:</label>
            <input type="hidden" name="rate_price" id="rate_price" value="">
            <div class="star-rating" data-rating-name="rate_price"></div>
         </div>
         <div class="rating-container">
            <label for="rate_service">Service Rating:</label>
            <input type="hidden" name="rate_service" id="rate_service" value="">
            <div class="star-rating" data-rating-name="rate_service"></div>
         </div>
         <div class="rating-container">
            <label for="rate_food">Food Rating:</label>
            <input type="hidden" name="rate_food" id="rate_food" value="">
            <div class="star-rating" data-rating-name="rate_food"></div>
         </div>
         <button type="submit" name="submit_review">Submit Review</button>
      </form>
   </div>

</section>

</section>
<!-- reviews section ends -->

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

<script>
   document.addEventListener("DOMContentLoaded", function() {
      let starRatingInputs = document.querySelectorAll('.star-rating');

      starRatingInputs.forEach(function(starRatingInput) {
         let ratingName = starRatingInput.getAttribute('data-rating-name');
         let ratingInput = document.querySelector('input[name="' + ratingName + '"]');

         for (let i = 1; i <= 5; i++) {
            let star = document.createElement('input');
            star.type = 'radio';
            star.name = ratingName + '-star';
            star.id = ratingName + '-star-' + i;
            star.value = i;

            let starLabel = document.createElement('label');
            starLabel.htmlFor = ratingName + '-star-' + i;
            starLabel.classList.add('star');
            starLabel.dataset.value = i;  // Add data attribute for the number
            starRatingInput.appendChild(star);
            starRatingInput.appendChild(starLabel);

            star.addEventListener('change', function() {
               ratingInput.value = this.value;
               // Update the star colors
               let siblings = starRatingInput.querySelectorAll('input[name="'+ratingName+'-star"] ~ label');
               siblings.forEach(function(sibling) {
                  sibling.classList.remove('checked');
               });
               this.nextSibling.classList.add('checked');
            });
         }
      });
   });
</script>

</body>
</html>