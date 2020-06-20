-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 20, 2020 at 09:39 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laboitedeconcert`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `town` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `postal_code` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `number`, `street`, `town`, `postal_code`, `country`, `id_user`, `id_product`) VALUES
(1, 69, 'Chemin de la côte à Farot', 'Orgeval', 78630, 'France', 1, NULL),
(14, 18, 'Rue du Faubourg du Temple', 'Paris', 75011, 'France', NULL, 12),
(15, 21, 'Quai Victor Augagneur', 'Lyon', 69003, 'France', NULL, 13),
(16, 6, 'Rue de l\'Antiquaille', 'Lyon', 69005, 'France', NULL, 14),
(17, 80, 'Rue de Rochechouart', 'Paris', 75018, 'France', NULL, 15),
(18, 9, 'Rue Biscornet', 'Paris', 75012, 'France', NULL, 16),
(19, 6, 'Rue Pierre Fontaine', 'Paris', 75009, 'France', NULL, 17),
(20, 7, 'Avenue de la Porte de la Villette', 'Paris', 75019, 'France', NULL, 18),
(21, 72, 'Boulevard de Rochechouart', 'Paris', 75018, 'France', NULL, 19),
(22, 211, 'Avenue Jen Jaurès', 'Paris', 75019, 'France', NULL, 20),
(23, 10, 'Quai Charles de Gaulle', 'Lyon', 69006, 'France', NULL, 21),
(27, 10, 'Rue de Grassi', 'Bordeaux', 33000, 'France', NULL, 23),
(28, 55, 'Quai de la Seine', 'Paris', 75019, 'France', NULL, 24),
(29, 2, 'Rond-Point Madame de Mondonville', 'Toulouse', 31200, 'France', NULL, 25),
(30, 20, 'Chemin de Garric', 'Toulouse', 31200, 'France', NULL, 26),
(31, 168, 'Avenue Willy Brandt', 'Lille', 59777, 'France', NULL, 27),
(32, 5, 'Place Sébastopol', 'Lille', 59777, 'France', NULL, 28),
(33, 41, 'Rue Jobin', 'Marseille', 13003, 'France', NULL, 29);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `id_user`) VALUES
(1, 1),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`) VALUES
(1, 'Salles de Concert', 'Une salle de concert est une salle de spectacle destinée au déroulement de concerts.', '1.jpg'),
(2, 'Théâtres', 'Le théâtre est à la fois l\'art de la représentation d\'un drame ou d\'une comédie mais surtout de la musique.', '2.jpg'),
(3, 'Bateaux', 'Il s\'agit d\'un endroit peu commun pour assister à un concert.', '3.jpg'),
(4, 'Bars', 'Un bar est un établissement où l\'on sert principalement des boissons alcoolisées.', '4.jpg'),
(5, 'Cafés', 'Rien de mieux que de siroter une bière en écoutant un p\'tit jazz.', '5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `quantity` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `capacity`, `price`, `images`, `isActive`, `quantity`) VALUES
(12, 'Gibus Club', 'Le Gibus est une boîte de nuit et une salle de concert parisienne d\'une capacité d\'environ 900 personnes.', 900, 9000, '12-1.jpg,12-2.jpg,12-3.jpg', 1, 1),
(13, 'Ayers Rock Boat', 'Sur un bateau, boîte de nuit et salle de concerts à la programmation rock et électro, tiki bar et restaurant.', 1036, 10500, '13-1.jpg,13-2.jpg,13-3.jpg', 1, 1),
(14, 'Théâtre de Fourvière', 'Les Nuits de Fourvière sont un festival culturel pluridisciplinaire se déroulant chaque été depuis 1946 au Théâtre antique de Fourvière.', 10090, 102000, '14-1.jpg,14-2.jpg,14-3.jpg', 1, 1),
(15, 'Le Trianon', 'Le Trianon est un théâtre parisien situé au 80, boulevard de Rochechouart dans le 18 arrondissement de Paris (France).', 1091, 10900, '15-1.jpg,15-2.jpg,15-3.jpg', 1, 1),
(16, 'Supersonic Club', 'Concerts gratuits, Nuits rock et Disquaire à Paris.', 754, 8525, '16-1.jpg,16-2.jpg,16-3.jpg', 1, 1),
(17, 'Le Bus Palladium', 'Night-club de beatniks ouvert en 1965, qui organise des concerts et sessions de DJ, avec restaurant à l\'étage.', 459, 5545, '17-1.jpg,17-2.jpg,17-3.jpeg', 1, 1),
(18, 'Glazart', 'Ancienne gare routière transformée en salle de concert underground avec des groupes et DJ émergents.', 1087, 10500, '18-1.jpg,18-2.jpg,18-3.jpg', 1, 1),
(19, 'Élysée-Montmartre', 'L\'Élysée-Montmartre est une salle de spectacle parisienne située au 72 boulevard de Rochechouart.', 1380, 13540, '19-1.jpg,19-2.jpg,19-3.jpg', 1, 1),
(20, 'Le Zénith de Paris', 'Le Zénith Paris - La Villette est une salle de concert parisienne, située dans le parc de la Villette.', 6804, 70520, '20-1.jpg,20-2.jpg,20-3.jpg', 1, 1),
(21, 'Salle 3000', 'Cet hémicycle ouvert à 180° fait partie du Centre des Congrès de Lyon et accueille spectacles et concerts.', 3000, 34550, '21-1.jpg,21-2.jpg,21-3.jpg', 1, 1),
(23, 'Théâtre Femina', 'Le Théâtre Fémina est une salle de spectacle, créée en 1921 à Bordeaux, 10 rue de Grassi.', 1200, 12000, '23-1.jpg,23-2.jpg,23-3.jpg', 1, 1),
(24, 'Antipode', 'Des produits artisanaux et issus du commerce équitable servis dans une péniche proposant aussi des spectacles.', 200, 5245, '24-1.jpg,24-2.jpg,24-3.jpg', 1, 1),
(25, 'Metronum', 'Salle de concert à Toulouse.', 850, 8550, '25-1.jpg,25-2.jpg,25-3.jpg', 1, 1),
(26, 'Nougaro', 'Salle de concert à Toulouse.', 530, 5665, '26-1.jpg,26-2.jpg,26-3.jpg', 1, 1),
(27, 'Aéronef', 'L\'Aéronef est une salle de spectacle consacrée aux musiques actuelles et autres disciplines artistiques.', 1945, 19500, '27-1.jpg,27-2.jpg,27-3.jpg', 1, 1),
(28, 'Théâtre Sébastopol', 'Le théâtre Sébastopol est un théâtre et une salle de spectacle de 1 350 places situé place Sébastopol, à Lille.', 1350, 12560, '28-1.jpg,28-2.jpg,28-3.jpg', 1, 1),
(29, 'Cabaret Aléatoire', 'Salle de concert à Marseille.', 500, 5450, '29-1.jpg,29-2.jpg,29-3.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_cart`
--

DROP TABLE IF EXISTS `products_cart`;
CREATE TABLE IF NOT EXISTS `products_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cart` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `id_product`, `id_category`) VALUES
(18, 12, 1),
(24, 14, 1),
(25, 14, 2),
(26, 15, 1),
(27, 15, 2),
(28, 16, 1),
(29, 16, 4),
(30, 17, 1),
(31, 17, 4),
(32, 18, 1),
(33, 18, 4),
(34, 19, 1),
(35, 20, 1),
(36, 21, 1),
(37, 21, 2),
(38, 13, 1),
(39, 13, 3),
(40, 13, 4),
(45, 23, 1),
(46, 23, 2),
(47, 24, 1),
(48, 24, 3),
(49, 24, 4),
(50, 25, 1),
(51, 26, 1),
(52, 27, 1),
(53, 28, 1),
(54, 28, 2),
(55, 29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `email`, `password`, `phone`, `is_admin`) VALUES
(1, 'Ballestra', 'Paul', 'admin@concert.com', '4a7d1ed414474e4033ac29ccb8653d9b', '0649075146', 1),
(5, 'Colin', 'Alexandra', 'alexandra@colin.com', '4a7d1ed414474e4033ac29ccb8653d9b', NULL, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
