-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 04:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loris_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'Loris', '8cb2237d0679ca88db6464eac60da96345513964'),
(2, 'LorisAM', '8cb2237d0679ca88db6464eac60da96345513964'),
(3, 'LorisPM', '8cb2237d0679ca88db6464eac60da96345513964');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `size` varchar(50) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `size`, `price`, `quantity`, `image`) VALUES
(76, 4, 8, 'French Vanilla', 'Large', 39, 1, 'Picsart_24-05-09_01-06-11-629.jpg'),
(77, 4, 25, 'Americano', 'Large', 89, 1, 'Picsart_24-05-08_14-41-54-813.jpg'),
(78, 4, 22, 'Creamy Croissant', '', 30, 1, 'Picsart_24-05-08_14-21-26-042.jpg'),
(79, 1, 8, 'French Vanilla', 'Medium', 29, 1, 'Picsart_24-05-09_01-06-11-629.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(2, 1, 'Dan', 'dan@gmail.com', '123456', 'Wala pa ako tulog');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'Mico', '9098874204', 'intertasmico@gmail.com', 'cash on delivery', 'Quezon City, San Bartolome, Phase 2, Pascualer Ville., Blk 3 Lot 30A - 1116', 'French Vanilla (Medium - ₱29 x 1), French Vanilla (Large - ₱39 x 1), Rice, Egg, and Pork ( - ₱79 x 1), Rice, Egg, and Burger Steak ( - ₱69 x 1), Caramel Latte (Large - ₱39 x 1)', 255, '2024-05-18', 'completed'),
(2, 4, 'Ian Ramos', '0967297760', 'ramos.ianchristian.clemente@gmail.com', 'cash on delivery', 'Quezon City, Pasong Tamo, Sikaplane, 06, 06 - 1107', 'Caramel Latte (Medium - ₱29 x 1), French Vanilla (Large - ₱39 x 1)', 68, '2024-05-18', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `med_price` varchar(50) NOT NULL,
  `large_price` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `availability` enum('Available','Not Available') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `category`, `price`, `med_price`, `large_price`, `image`, `availability`) VALUES
(1, 'Rice, Egg, and Burger Steak', '1 Rice, 1 Egg, and 1 Burger Steak', 'Meals', '69', '0', '0', 'RicewithEgga dBurgerSteak.jpg', 'Available'),
(2, 'Rice, Egg, and Sausage', '1 Rice, 1 Egg, and 1 Sausage', 'Meals', '69', '0', '0', 'RicewithEggandSausage.jpg', 'Available'),
(3, 'Rice, Egg, and Pork', '1 Rice, 1 Egg, and 1 Breaded Pork', 'Meals', '79', '0', '0', 'RicewithEggandPork.jpg', 'Available'),
(4, 'Siomai', '8 pieces shumai. Good for two persons.', 'Snacks', '39', '0', '0', 'Siomai.jpg', 'Available'),
(5, 'French Fries', 'French Fries that is good for sizes of Solo, Barkada, Family.', 'Snacks', '59', '0', '0', 'FrenchFries.jpg', 'Available'),
(6, 'Nachos', 'Nachos with ketchup and mayonnaise a good threat for two persons.', 'Snacks', '49', '0', '0', 'Nachos.jpg', 'Available'),
(7, 'Caramel Latte', 'Indulgent layers of rich coffee and creamy caramel harmonize in a decadent, flavor-packed delight.', 'Ice Coffee', '39', '29', '39', 'Picsart_24-05-09_01-02-10-429.jpg', 'Not Available'),
(8, 'French Vanilla', 'Smooth, robust coffee flavor infused with creamy notes of French vanilla for a luxurious and comforting taste experience.', 'Ice Coffee', '39', '29', '39', 'Picsart_24-05-09_01-06-11-629.jpg', 'Available'),
(9, 'Cafe Con Leche', 'Bold espresso mingles with creamy, sweetened milk, reminiscent of the authentic Spanish-inspired café con leche, offering a delightful balance of richness and sweetness.', 'Ice Coffee', '39', '29', '39', 'Picsart_24-05-09_01-02-45-251.jpg', 'Available'),
(10, 'Taro', 'Velvety milk tea infused with the subtly sweet and nutty essence of taro, creating a comforting and unique flavor experience.', 'Milktea', '39', '29', '39', 'MilkTea1.jpg', 'Available'),
(11, 'Winter Melon', 'Smooth milk tea meets the delicate sweetness of winter melon, resulting in a refreshing and subtly floral flavor sensation.', 'Milktea', '39', '29', '39', 'MilkTea2.jpg', 'Available'),
(12, 'Matcha', 'Vibrant and earthy matcha blends seamlessly with creamy milk tea, offering a harmonious balance of green tea flavor and smooth richness.', 'Milktea', '39', '29', '39', 'MilkTea3.jpg', 'Available'),
(13, 'Lemonade Yogurt', 'Lemonade infused with the refreshing sweetness of assorted fruits and the creamy tartness of yogurt, creating a vibrant and revitalizing beverage bursting with flavor.', 'Fruit Yogurt', '49', '39', '49', 'FruitYogurt1.jpg', 'Available'),
(14, 'Blue Berry Yogurt', 'Blueberries mixed with creamy yogurt in a refreshing fusion, delivering a delightful balance of sweet and tangy flavors in every sip.', 'Fruit Yogurt', '49', '39', '49', 'FruitYogurt2.jpg', 'Available'),
(15, 'Strawberry Yogurt', 'Ripe strawberries blended with creamy yogurt create a harmonious combination of sweet and zesty flavor, reminiscent of a refreshing fruit parfait.', 'Fruit Yogurt', '49', '39', '49', 'FruitYogurt3.jpg', 'Available'),
(16, 'Oreo Shake', 'Rich and creamy milkshake blended with chunks of Oreo cookies, offering a delectable blend of chocolatey goodness and cookie crunch in every sip.', 'Non Coffee', '69', '59', '69', 'Picsart_24-05-09_01-13-09-135.jpg', 'Available'),
(17, 'Hershey&#39;s Kisses Shake', 'Indulgent milkshake infused with the iconic flavors of Hershey\'s chocolate and the sweet, creamy richness of Hershey\'s Kisses, delivering a blissful blend of cocoa perfection.', 'Non Coffee', '69', '59', '69', 'Picsart_24-05-09_01-11-35-740.jpg', 'Available'),
(18, 'Melted Caramel Shake', 'Decadent milkshake swirled with warm, gooey caramel, creating a luscious blend of sweetness and richness reminiscent of a melted caramel confection.', 'Non Coffee', '69', '59', '69', 'Picsart_24-05-09_01-12-22-794.jpg', 'Available'),
(20, 'Red Velvet Cupcake', 'A decadent red velvet cupcake, adorned with velvety cream cheese frosting and delicate red velvet crumbles, offering a symphony of rich cocoa and tangy sweetness in every bite.', 'Pastries', '35', '0', '0', 'Picsart_24-05-08_14-22-35-861.jpg', 'Available'),
(21, 'Crushed Oreo Donut', 'A luscious crushed Oreo donut, generously coated in a silky glaze and sprinkled with a symphony of crushed Oreo cookies, providing a delightful contrast of crunchy chocolate goodness and pillowy softness.', 'Pastries', '30', '0', '0', 'Picsart_24-05-08_14-27-22-662.jpg', 'Available'),
(22, 'Creamy Croissant', 'A heavenly creamy croissant, oozing with a velvety smooth vanilla custard filling and dusted with a whisper of powdered sugar, creating a harmonious balance of buttery flakiness and creamy indulgence.', 'Pastries', '30', '0', '0', 'Picsart_24-05-08_14-21-26-042.jpg', 'Available'),
(23, 'Cappuccino', 'Indulge in the rich, velvety texture of our cappuccino, expertly crafted with the perfect balance of smooth espresso, creamy steamed milk, and airy foam for an irresistible coffee experience.', 'Hot Brewed', '89', '79', '89', 'Picsart_24-05-08_14-43-59-199.jpg', 'Available'),
(24, 'Spanish Latte', 'Treat yourself to the tantalizing blend of bold espresso and silky condensed milk in our Spanish latte, a decadent twist on a classic coffee favorite that promises a smooth and indulgent taste sensation.', 'Hot Brewed', '89', '79', '89', 'Picsart_24-05-08_14-42-58-836.jpg', 'Available'),
(25, 'Americano', 'Savor the simplicity of our Americano, meticulously crafted with rich espresso and hot water for a bold and invigorating coffee experience that&#39;s perfect for any time of day.', 'Hot Brewed', '89', '79', '89', 'Picsart_24-05-08_14-41-54-813.jpg', 'Available'),
(26, 'Apple', 'This is Apple', 'Snacks', '15', '', '', 'Red_Apple.jpg', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `review_text` varchar(255) NOT NULL,
  `rate_price` int(11) NOT NULL,
  `rate_service` int(11) NOT NULL,
  `rate_food` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`user_id`, `name`, `review_text`, `rate_price`, `rate_service`, `rate_food`, `datetime`) VALUES
(1, 'Mico', 'Budget Friendly sya, mababait ang staffs, and masarap ang foods.', 5, 5, 5, '2024-05-16 11:13:52'),
(4, 'Ian Ramos', 'Good for the Price. Medyo mabagal service. Masarap but needs improvement', 5, 2, 3, '2024-05-18 03:13:55'),
(11, 'Mcrey Ronquillo', 'Medyo hindi masarap kape, mabagal ang service', 5, 5, 5, '2024-05-18 03:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(1, 'Mico', 'intertasmico@gmail.com', '9098874204', 'f3cb2b95725e7ac80403b965742a7cdff611d42c', 'Quezon City, San Bartolome, Phase 2, Pascualer Ville., Blk 3 Lot 30A - 1116'),
(2, 'John Cris Florano', 'florano.johncris.capalar03@gmail.com', '0994216093', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Santa Monica, Pugong Ginto Street, 46, 46 - 1117'),
(3, 'Eduard Allen', 'eduard.allen.morales.blanco@gmail.com', '0938866581', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Commonwealth, Dahlia Street, Purok 17, Unit V - 1121'),
(4, 'Ian Ramos', 'ramos.ianchristian.clemente@gmail.com', '0967297760', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Pasong Tamo, Sikaplane, 06, 06 - 1107'),
(5, 'Mhel Bandibad', 'bandibadmhelroco@gmail.com', '0927797304', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Santa Monica, Pugong Ginto Street, 90, 90 - 1117'),
(6, 'Ezer Jan Andalan', 'andalan.ezerjan.elmidulan@gmail.com', '0999167643', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Novaliches Proper, Phase 2, Blk 4, Lot 4 - 1121'),
(7, 'Vista Valentino', 'vista.valentino.samson@gmail.com', '0927036457', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Commonwealth, Kamagong Street, 013, 013 - 1121'),
(8, 'Dan Gajultos', 'lychee.gajultosdanerick@gmail.com', '0991118196', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Santa Monica, Mayang Pula Street, #153, #153 - 1117'),
(9, 'Elaika Bernardo', 'bernardo.elaika1@gmail.com', '0909884893', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Gulod, Senading Street, 36, 36 - 1117'),
(10, 'Erica Bonabon', 'bonabon.ericaclaudette.lucino@gmail.com', '0948486749', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Gulod, Masaya Street, Lot 8 Blk 1, Lot 8 Blk 1 INT - 1117'),
(11, 'Mcrey Ronquillo', 'ronquillo.mcrey.morota@gmail.com', '0992937711', '8cb2237d0679ca88db6464eac60da96345513964', 'Quezon City, Kaligayahan, Kingfisher Street, #27, #27 - 1124');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
