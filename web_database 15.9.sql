-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2023 at 10:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_database`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUserTokens` ()   BEGIN
    DECLARE total_tokens_to_redistribute INT;
    DECLARE user_count INT;
    DECLARE user_rank INT;
    DECLARE user_total_score INT;
    DECLARE user_tokens_to_receive INT;
    
   
    SET total_tokens_to_redistribute = (SELECT SUM(total_tokens) * 0.8 FROM user);
    
    
    SET user_count = (SELECT COUNT(*) FROM user WHERE total_score > 0);
    
   
    SET user_rank = 0;
    
    
    SET user_total_score = -1; 
    
    WHILE user_rank < user_count DO
       
        SET user_total_score = (SELECT total_score FROM user WHERE total_score > 0 ORDER BY total_score DESC LIMIT 1 OFFSET user_rank);
        
        
        SET user_tokens_to_receive = ROUND(total_tokens_to_redistribute * (user_total_score / (SELECT SUM(total_score) FROM user WHERE total_score > 0)));
        
        
        UPDATE user
        SET total_tokens = total_tokens + user_tokens_to_receive
        WHERE total_score = user_total_score;
        
        SET user_rank = user_rank + 1;
    END WHILE;
    
    
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` varchar(50) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
('3412', 'Καθαριότητα'),
('2341', 'Ποτά - Αναψυκτικά'),
('4123', 'Προσωπική φροντίδα'),
('1234', 'Τρόφιμα');

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `position` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `total_tokens` int(11) NOT NULL,
  `premonth_tokens` int(11) NOT NULL,
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offer_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `shop_id` bigint(20) NOT NULL,
  `user_username` varchar(30) NOT NULL,
  `price` float NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `register_date` date NOT NULL,
  `availability` tinyint(4) NOT NULL DEFAULT 1,
  `price_lower_than_preday` float NOT NULL,
  `price_lower_than_preweek` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `offer`
--
DELIMITER $$
CREATE TRIGGER `dislikes_subtracts_points` AFTER UPDATE ON `offer` FOR EACH ROW BEGIN
UPDATE USER
SET total_score = total_score - 1
WHERE (NEW.dislikes = OLD.dislikes + 1 AND USER.user_username = NEW.user_username); 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `likes_add_points` AFTER UPDATE ON `offer` FOR EACH ROW BEGIN
UPDATE USER
SET total_score = total_score + 5
WHERE (NEW.likes = OLD.likes + 1 AND USER.user_username = NEW.user_username);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_points_after_offer` AFTER INSERT ON `offer` FOR EACH ROW BEGIN
    DECLARE lowest_price DOUBLE;
    DECLARE p_id INT;
    
    SELECT product_id INTO p_id
    FROM product
    WHERE product_name = NEW.product_name;
    
    SET lowest_price = (
        SELECT MIN(price)
        FROM price_variety
        WHERE p_id = product_id
    );
    
    IF NEW.price < (lowest_price * 0.8) THEN
        UPDATE user
        SET total_score = total_score + 50
        WHERE user_username = NEW.user_username;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_shop_offers` AFTER INSERT ON `offer` FOR EACH ROW BEGIN
    UPDATE shop
    SET offers = 1
    WHERE shop_id = NEW.shop_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_shop_offers_on_delete` AFTER DELETE ON `offer` FOR EACH ROW BEGIN
    DECLARE shop_offer_count INT;
    SET shop_offer_count = (SELECT COUNT(*) FROM offer WHERE shop_id = OLD.shop_id);
    
    IF shop_offer_count = 0 THEN
        UPDATE shop
        SET offers = 0
        WHERE shop_id = OLD.shop_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_user_offers` AFTER INSERT ON `offer` FOR EACH ROW BEGIN
    UPDATE user
    SET offers = offers + 1
    WHERE user_username = NEW.user_username;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `price_variety`
--

CREATE TABLE `price_variety` (
  `price_variety_id` int(50) NOT NULL,
  `product_id` int(50) NOT NULL,
  `price_date` date NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `price_variety`
--

INSERT INTO `price_variety` (`price_variety_id`, `product_id`, `price_date`, `price`) VALUES
(6162, 1, '2022-12-01', 8.96),
(6163, 1, '2022-12-02', 8.94),
(6164, 1, '2022-12-03', 9.04),
(6165, 1, '2022-12-05', 8.99),
(6166, 1, '2022-12-06', 9.12),
(6167, 2, '2022-12-01', 1.53),
(6168, 2, '2022-12-02', 1.55),
(6169, 2, '2022-12-03', 1.55),
(6170, 2, '2022-12-05', 1.55),
(6171, 2, '2022-12-06', 1.55),
(6172, 3, '2022-12-01', 5.82),
(6173, 3, '2022-12-02', 5.8),
(6174, 3, '2022-12-03', 5.6),
(6175, 3, '2022-12-05', 6.08),
(6176, 3, '2022-12-06', 6.12),
(6177, 4, '2022-12-01', 17.24),
(6178, 4, '2022-12-02', 17.54),
(6179, 4, '2022-12-03', 17.76),
(6180, 4, '2022-12-05', 17.56),
(6181, 4, '2022-12-06', 17.51),
(6182, 5, '2022-12-01', 3.44),
(6183, 5, '2022-12-02', 3.44),
(6184, 5, '2022-12-03', 3.43),
(6185, 5, '2022-12-05', 3.44),
(6186, 5, '2022-12-06', 3.43),
(6187, 6, '2022-12-01', 0.4),
(6188, 6, '2022-12-02', 0.4),
(6189, 6, '2022-12-03', 0.41),
(6190, 6, '2022-12-05', 0.4),
(6191, 6, '2022-12-06', 0.41),
(6192, 8, '2022-12-01', 2.38),
(6193, 8, '2022-12-02', 2.44),
(6194, 8, '2022-12-03', 2.48),
(6195, 8, '2022-12-05', 2.44),
(6196, 8, '2022-12-06', 2.44),
(6197, 9, '2022-12-01', 3.74),
(6198, 9, '2022-12-02', 3.74),
(6199, 9, '2022-12-03', 3.93),
(6200, 9, '2022-12-05', 3.76),
(6201, 9, '2022-12-06', 3.74),
(6202, 10, '2022-12-01', 4.14),
(6203, 10, '2022-12-02', 4.13),
(6204, 10, '2022-12-03', 4.13),
(6205, 10, '2022-12-05', 3.79),
(6206, 10, '2022-12-06', 3.82),
(6207, 11, '2022-12-01', 1.93),
(6208, 11, '2022-12-02', 1.93),
(6209, 11, '2022-12-03', 1.92),
(6210, 11, '2022-12-05', 1.93),
(6211, 11, '2022-12-06', 1.93),
(6212, 12, '2022-12-01', 2.61),
(6213, 12, '2022-12-02', 2.61),
(6214, 12, '2022-12-03', 2.56),
(6215, 12, '2022-12-05', 2.61),
(6216, 12, '2022-12-06', 2.58),
(6217, 13, '2022-12-01', 5.09),
(6218, 13, '2022-12-02', 4.63),
(6219, 13, '2022-12-03', 4.96),
(6220, 13, '2022-12-05', 5.08),
(6221, 13, '2022-12-06', 5.08),
(6222, 14, '2022-12-01', 8.69),
(6223, 14, '2022-12-02', 8.69),
(6224, 14, '2022-12-03', 8.62),
(6225, 14, '2022-12-05', 8.69),
(6226, 14, '2022-12-06', 8.7),
(6227, 15, '2022-12-01', 4.73),
(6228, 15, '2022-12-02', 5.1),
(6229, 15, '2022-12-03', 5.46),
(6230, 15, '2022-12-05', 5.01),
(6231, 15, '2022-12-06', 5.23),
(6232, 16, '2022-12-01', 2.38),
(6233, 16, '2022-12-02', 2.4),
(6234, 16, '2022-12-03', 2.31),
(6235, 16, '2022-12-05', 2.42),
(6236, 16, '2022-12-06', 2.47),
(6237, 17, '2022-12-01', 9.36),
(6238, 17, '2022-12-02', 9.42),
(6239, 17, '2022-12-03', 9.62),
(6240, 17, '2022-12-05', 9.68),
(6241, 17, '2022-12-06', 9.64),
(6242, 18, '2022-12-01', 5.65),
(6243, 18, '2022-12-02', 5.61),
(6244, 18, '2022-12-03', 5.63),
(6245, 18, '2022-12-05', 5.63),
(6246, 18, '2022-12-06', 5.61),
(6247, 19, '2022-12-01', 1.27),
(6248, 19, '2022-12-02', 1.32),
(6249, 19, '2022-12-03', 1.31),
(6250, 19, '2022-12-05', 1.29),
(6251, 19, '2022-12-06', 1.29),
(6252, 20, '2022-12-01', 2.79),
(6253, 20, '2022-12-02', 2.83),
(6254, 20, '2022-12-03', 2.82),
(6255, 20, '2022-12-05', 2.7),
(6256, 20, '2022-12-06', 3.43),
(6257, 21, '2022-12-01', 2.03),
(6258, 21, '2022-12-02', 2.21),
(6259, 21, '2022-12-03', 2.2),
(6260, 21, '2022-12-05', 2.42),
(6261, 21, '2022-12-06', 2.5),
(6262, 22, '2022-12-01', 5.22),
(6263, 22, '2022-12-02', 5.22),
(6264, 22, '2022-12-03', 5.22),
(6265, 22, '2022-12-05', 5.22),
(6266, 22, '2022-12-06', 5.22),
(6267, 23, '2022-12-01', 1.35),
(6268, 23, '2022-12-02', 1.47),
(6269, 23, '2022-12-03', 1.47),
(6270, 23, '2022-12-05', 1.47),
(6271, 23, '2022-12-06', 1.47),
(6272, 24, '2022-12-01', 2.34),
(6273, 24, '2022-12-02', 2.32),
(6274, 24, '2022-12-03', 2.33),
(6275, 24, '2022-12-05', 1.89),
(6276, 24, '2022-12-06', 2.01),
(6277, 25, '2022-12-01', 1.31),
(6278, 25, '2022-12-02', 1.31),
(6279, 25, '2022-12-03', 1.3),
(6280, 25, '2022-12-05', 1.31),
(6281, 25, '2022-12-06', 1.3),
(6282, 26, '2022-12-01', 2.88),
(6283, 26, '2022-12-02', 2.88),
(6284, 26, '2022-12-03', 2.88),
(6285, 26, '2022-12-05', 2.88),
(6286, 26, '2022-12-06', 2.87),
(6287, 27, '2022-12-01', 4.25),
(6288, 27, '2022-12-02', 4.13),
(6289, 27, '2022-12-03', 4.35),
(6290, 27, '2022-12-05', 4.2),
(6291, 27, '2022-12-06', 4.11),
(6292, 28, '2022-12-01', 4.71),
(6293, 28, '2022-12-02', 4.71),
(6294, 28, '2022-12-03', 4.69),
(6295, 28, '2022-12-05', 4.71),
(6296, 28, '2022-12-06', 4.71),
(6297, 29, '2022-12-01', 7.69),
(6298, 29, '2022-12-02', 8.6),
(6299, 29, '2022-12-03', 8.42),
(6300, 29, '2022-12-05', 9.08),
(6301, 29, '2022-12-06', 9.07),
(6302, 30, '2022-12-01', 23.86),
(6303, 30, '2022-12-02', 23.79),
(6304, 30, '2022-12-03', 23.85),
(6305, 30, '2022-12-05', 23.46),
(6306, 30, '2022-12-06', 23.89),
(6307, 31, '2022-12-01', 3.39),
(6308, 31, '2022-12-02', 2.71),
(6309, 31, '2022-12-03', 2.92),
(6310, 31, '2022-12-05', 3.19),
(6311, 31, '2022-12-06', 2.78),
(6312, 32, '2022-12-01', 5.97),
(6313, 32, '2022-12-02', 5.95),
(6314, 32, '2022-12-03', 5.7),
(6315, 32, '2022-12-05', 6.25),
(6316, 32, '2022-12-06', 6.23),
(6317, 34, '2022-12-01', 1.14),
(6318, 34, '2022-12-02', 1.12),
(6319, 34, '2022-12-03', 1.13),
(6320, 34, '2022-12-05', 1.13),
(6321, 34, '2022-12-06', 1.13),
(6322, 35, '2022-11-30', 2.03),
(6323, 35, '2022-12-01', 2.03),
(6324, 35, '2022-12-02', 2.03),
(6325, 35, '2022-12-03', 2.03),
(6326, 35, '2022-12-05', 2.03),
(6327, 37, '2022-12-01', 2.05),
(6328, 37, '2022-12-02', 2.06),
(6329, 37, '2022-12-03', 2.04),
(6330, 37, '2022-12-05', 2.04),
(6331, 37, '2022-12-06', 2.05),
(6332, 38, '2022-12-01', 7.34),
(6333, 38, '2022-12-02', 7.37),
(6334, 38, '2022-12-03', 7.34),
(6335, 38, '2022-12-05', 7.34),
(6336, 38, '2022-12-06', 7.34),
(6337, 40, '2022-12-01', 4.77),
(6338, 40, '2022-12-02', 4.76),
(6339, 40, '2022-12-03', 4.58),
(6340, 40, '2022-12-05', 4.72),
(6341, 40, '2022-12-06', 4.64);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `subcategory_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `category_name`, `subcategory_id`) VALUES
(1, 'Klinex Χλωρίνη Ultra Lemon 1250ml', '3412', 'Καθαριότητα', '3be81b50494d4b5495d5fea3081759a6'),
(2, 'Quanto Μαλακτ Μη Συμπ Μπλε 2λιτ', '3412', 'Καθαριότητα', '3be81b50494d4b5495d5fea3081759a6'),
(3, 'Bref Power Active Wc Block Ωκεαν 50γρ', '3412', 'Καθαριότητα', '3be81b50494d4b5495d5fea3081759a6'),
(4, 'Brasso Γυαλιστικό Μετάλλων 150ml', '3412', 'Καθαριότητα', '3be81b50494d4b5495d5fea3081759a6'),
(5, 'CIF Spray Κουζίνας 500ml', '3412', 'Καθαριότητα', '3be81b50494d4b5495d5fea3081759a6'),
(6, 'Ava Υγρό Πιάτων Action Λευκο Ξυδι Αντλια 650ml', '3412', 'Καθαριότητα', 'e60aca31a37a40db8a83ccf93bd116b1'),
(7, 'Omo Σκόνη 425γρ', '3412', 'Καθαριότητα', 'e60aca31a37a40db8a83ccf93bd116b1'),
(8, 'Neomat Total Eco Απορ Σκον 14πλ 700γρ', '3412', 'Καθαριότητα', 'e60aca31a37a40db8a83ccf93bd116b1'),
(9, 'Ava Υγρό Πιάτων Perle Χαμομήλι/Λεμόνι 1500ml', '3412', 'Καθαριότητα', 'e60aca31a37a40db8a83ccf93bd116b1'),
(10, 'Fairy Υγρό Απορρυπαντικό Πιάτων Power Spray 375ml', '3412', 'Καθαριότητα', 'e60aca31a37a40db8a83ccf93bd116b1'),
(11, 'Amita Motion Φυσικός Χυμός 1λιτ', '2341', 'Ποτά - Αναψυκτικά', '4f1993ca5bd244329abf1d59746315b8'),
(12, 'Cool Hellas Χυμός Πορτοκαλ Συμπ 1λιτ', '2341', 'Ποτά - Αναψυκτικά', '4f1993ca5bd244329abf1d59746315b8'),
(13, 'Life Χυμός Φυσικός Πορτοκάλι 1λιτ', '2341', 'Ποτά - Αναψυκτικά', '4f1993ca5bd244329abf1d59746315b8'),
(14, 'Life Φρουτοποτό Πορτ/Μηλ/Καρ 400ml', '2341', 'Ποτά - Αναψυκτικά', '4f1993ca5bd244329abf1d59746315b8'),
(15, 'Δέλτα Φυσικ Χυμός Smart Ροδ Βερ200ml', '2341', 'Ποτά - Αναψυκτικά', '4f1993ca5bd244329abf1d59746315b8'),
(16, 'Coca Cola Zero 2Χ1,5λιτ', '2341', 'Ποτά - Αναψυκτικά', '3010aca5cbdc401e8dfe1d39320a8d1a'),
(17, 'Red Bull Ενεργειακό Ποτό 250ml', '2341', 'Ποτά - Αναψυκτικά', '3010aca5cbdc401e8dfe1d39320a8d1a'),
(18, 'Monster Energy Drink 500ml', '2341', 'Ποτά - Αναψυκτικά', '3010aca5cbdc401e8dfe1d39320a8d1a'),
(19, 'Coca Cola 250ml', '2341', 'Ποτά - Αναψυκτικά', '3010aca5cbdc401e8dfe1d39320a8d1a'),
(20, 'Coca Cola Zero 1λιτ', '2341', 'Ποτά - Αναψυκτικά', '3010aca5cbdc401e8dfe1d39320a8d1a'),
(21, 'Nivea Μάσκα Peel Off 10ml', '4123', 'Προσωπική φροντίδα', '5a2a0575959c40d6a46614ab99b2d9af'),
(22, 'Pom Pon Eyes & Face Μαντηλάκια 20τεμ', '4123', 'Προσωπική φροντίδα', '5a2a0575959c40d6a46614ab99b2d9af'),
(23, 'Nivea Νερό Διφασ Ντεμακ Ματιών 125ml', '4123', 'Προσωπική φροντίδα', '5a2a0575959c40d6a46614ab99b2d9af'),
(24, 'Garnier Express Ντεμακιγιάζ Ματιών 2σε1 125ml', '4123', 'Προσωπική φροντίδα', '5a2a0575959c40d6a46614ab99b2d9af'),
(25, 'Pom Pon Μαντηλ Ντεμακ Sensit 20τεμ', '4123', 'Προσωπική φροντίδα', '5a2a0575959c40d6a46614ab99b2d9af'),
(26, 'Colgate Οδ/Μα Sensation Whiten.75ml', '4123', 'Προσωπική φροντίδα', '26e416b6efa745218f810c34678734b2'),
(27, 'OralB Οδ/Mα 1/2/3 75ml', '4123', 'Προσωπική φροντίδα', '26e416b6efa745218f810c34678734b2'),
(28, 'Aim Οδ/Μα Παιδ 2/6ετων 50ml', '4123', 'Προσωπική φροντίδα', '26e416b6efa745218f810c34678734b2'),
(29, 'Colgate Οδ/Μα Total Original 75ml', '4123', 'Προσωπική φροντίδα', '26e416b6efa745218f810c34678734b2'),
(30, 'OralB Οδ/Μα Pro Exp Prof Prot 75m', '4123', 'Προσωπική φροντίδα', '26e416b6efa745218f810c34678734b2'),
(31, 'Νουνού Gouda Φέτες 200γρ', '1234', 'Τρόφιμα', '4444'),
(32, 'Δομοκού Τυρί Κατίκι Ποπ 200g', '1234', 'Τρόφιμα', '4444'),
(33, 'Μεβγάλ Μανούρι 200γρ', '1234', 'Τρόφιμα', '4444'),
(34, 'Philadelphia Τυρί 300γρ', '1234', 'Τρόφιμα', '4444'),
(35, 'La Vache Qui Rit Τυρί Cheddar Φέτες 200γρ', '1234', 'Τρόφιμα', '4444'),
(36, 'Nestle Nesquik Ρόφημα Σακούλα 400γρ', '1234', 'Τρόφιμα', '2d711ee19d17429fa7f964d56fe611db'),
(37, 'Lipton Τσάι Ρόφημα 10 Φακ 1,5γρ', '1234', 'Τρόφιμα', '2d711ee19d17429fa7f964d56fe611db'),
(38, 'Lipton Τσάι Κίτρινο Φακ 20τεμΧ1,5γρ', '1234', 'Τρόφιμα', '2d711ee19d17429fa7f964d56fe611db'),
(39, 'Γιώτης Κακάο 125γρ', '1234', 'Τρόφιμα', '2d711ee19d17429fa7f964d56fe611db'),
(40, 'Lipton Χαμομήλι Φακ 10τεμΧ1γρ', '1234', 'Τρόφιμα', '2d711ee19d17429fa7f964d56fe611db');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `shop_id` bigint(20) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `shop_name` varchar(50) CHARACTER SET greek COLLATE greek_general_ci NOT NULL,
  `offers` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`shop_id`, `lat`, `lon`, `shop_name`, `offers`) VALUES
(354449389, 38.2080319, 21.712654, 'Lidl 1', 0),
(360217468, 38.28931, 21.7806567, 'The Mart', 0),
(360226900, 38.2633511, 21.7434265, 'Lidl 2', 0),
(364381224, 38.2952086, 21.7908028, 'Σουπερμάρκετ Ανδρικόπουλος', 0),
(364463568, 38.2104365, 21.7642075, 'Σκλαβενίτης 1', 0),
(598279836, 38.23553, 21.7622778, 'Papakos', 0),
(633369803, 38.2612908, 21.7540236, '', 0),
(980515550, 38.2312926, 21.740082, 'Lidl 3', 0),
(1643373636, 38.3013087, 21.7814957, 'Σκλαβενίτης 2', 0),
(1643373639, 38.2949372, 21.790383, '', 0),
(1643713403, 38.2852364, 21.7666723, '', 0),
(1643713405, 38.2911121, 21.7714546, '', 0),
(1643713406, 38.2913332, 21.7666079, '', 0),
(1643818244, 38.2779126, 21.7625472, '', 0),
(1643818267, 38.2751636, 21.7574031, '', 0),
(1643818277, 38.2756942, 21.7629172, '', 0),
(1643818281, 38.2596476, 21.7489662, 'Σκλαβενίτης 3', 0),
(1643825320, 38.2945036, 21.7883123, '', 0),
(1643889596, 38.2126477, 21.7568738, '', 0),
(1657132006, 38.2613806, 21.7436127, 'Ρουμελιώτης SUPER Market', 0),
(1657132008, 38.2585236, 21.741582, 'Σκλαβενίτης 4', 0),
(1657962066, 38.2991382, 21.7854989, '', 0),
(1695934267, 38.2915409, 21.7712803, '', 0),
(1763830009, 38.2323892, 21.7473265, 'My market 1', 0),
(1763830474, 38.2322376, 21.7257294, 'ΑΒ Βασιλόπουλος 1', 0),
(1770994538, 38.2644973, 21.7603629, 'Markoulas', 0),
(1771512424, 38.2657865, 21.7593252, '', 0),
(1815896581, 38.3067563, 21.8051332, 'Lidl 4', 0),
(1971240515, 38.2399863, 21.736371, 'Ανδρικόπουλος 1', 0),
(1971240518, 38.2377144, 21.7399001, '', 0),
(1971247760, 38.2364945, 21.7373409, 'Σκλαβενίτης 5', 0),
(1971249846, 38.2427052, 21.7342362, 'My Market', 0),
(1997401665, 38.2803811, 21.7689392, '', 0),
(1997401682, 38.2767389, 21.7646316, '', 0),
(3144355008, 38.2568618, 21.7396708, 'My market 2', 0),
(3354481184, 38.1951968, 21.7323293, 'Ανδρικόπουλος 2', 0),
(4101518891, 38.2565589, 21.7418506, 'ΑΒ ΒΑΣΙΛΟΠΟΥΛΟΣ', 0),
(4356067891, 38.2450095, 21.7365286, '', 0),
(4356183595, 38.2434859, 21.733285, 'Σκλαβενίτης 6', 0),
(4357098895, 38.2438242, 21.7339549, '', 0),
(4357217589, 38.2524287, 21.7414219, '', 0),
(4357425491, 38.2512732, 21.7423925, 'Kaponis', 0),
(4357589496, 38.2427963, 21.7302559, 'Ανδρικόπουλος 3', 0),
(4358244594, 38.2454121, 21.7337191, '', 0),
(4372108797, 38.2725804, 21.8364993, 'Mini Market 1', 0),
(4484528391, 38.2795377, 21.7667136, 'Carna', 0),
(4752810729, 38.3052409, 21.7770011, 'Mini Market 2', 0),
(4931300543, 38.2425794, 21.7296435, 'Kronos', 0),
(4953268497, 38.2585639, 21.7504681, 'Φίλιππας', 0),
(4969309651, 38.3015018, 21.7940989, '', 0),
(5005384516, 38.2498065, 21.7363349, 'No supermarket', 0),
(5005409493, 38.2490852, 21.735128, 'Kiosk 1', 0),
(5005409494, 38.2493169, 21.7349115, 'Kiosk 2', 0),
(5005409495, 38.2489563, 21.7344427, 'Kiosk 3', 0),
(5005476710, 38.2569875, 21.7413066, 'Kiosk 4', 0),
(5005476711, 38.2561434, 21.7409531, 'Kiosk 5', 0),
(5132918123, 38.2523678, 21.7400704, '', 0),
(5164678230, 38.2691937, 21.7481501, 'Ανδρικόπουλος - Supermarket', 0),
(5164741179, 38.2690963, 21.7497014, 'Σκλαβενίτης 7', 0),
(5350727524, 38.233827, 21.7251655, 'ENA food cash $ cary', 0),
(5396345464, 38.3277388, 21.8764222, 'Mini Market 3', 0),
(5620198221, 38.2170935, 21.7357783, 'ΑΒ Βασιλόπουλος 2', 0),
(5620208927, 38.2160259, 21.7321204, 'Mini Market 4', 0),
(5783486253, 38.312741, 21.8203451, '', 0),
(5909978406, 38.2451867, 21.7312416, '', 0),
(7673935764, 38.2504514, 21.7396687, '3A', 0),
(7673976786, 38.2486316, 21.7389771, 'Spar', 0),
(7673986831, 38.2481545, 21.7383224, 'ΑΝΔΡΙΚΟΠΟΥΛΟΣ 1', 0),
(7674120315, 38.2429466, 21.7308044, 'ΑΝΔΡΙΚΟΠΟΥΛΟΣ 2', 0),
(7677225097, 38.2392836, 21.7265283, 'MyMarket', 0),
(7914886761, 38.2653368, 21.7575349, '', 0),
(8214753473, 38.2346622, 21.7253472, 'Ena Cash And Carry', 0),
(8214854586, 38.2358002, 21.7294915, 'ΚΡΟΝΟΣ - (Σκαγιοπουλείου)', 0),
(8214887295, 38.2379176, 21.7306406, 'Ανδρικόπουλος Super Market', 0),
(8214887306, 38.2375068, 21.7328984, '3Α Αράπης', 0),
(8214910532, 38.2361127, 21.733787, 'Γαλαξίας', 0),
(8215010716, 38.2360129, 21.7283123, 'Super Market Θεοδωρόπουλος', 0),
(8215157448, 38.2390442, 21.7340723, 'Super Market ΚΡΟΝΟΣ', 0),
(8753329904, 38.2642274, 21.7396855, '', 0),
(8753329905, 38.2658237, 21.7398813, '', 0),
(8777081651, 38.2601801, 21.7428703, 'Σκλαβενίτης 8', 0),
(8777171555, 38.2586424, 21.7460078, '3A ARAPIS', 0),
(8805335004, 38.2454669, 21.7355058, 'Μασούτης', 0),
(8805467220, 38.24957, 21.7380288, 'ΑΒ Shop & Go', 0),
(8806495733, 38.2398789, 21.7455558, '3Α ΑΡΑΠΗΣ', 0),
(9651304117, 38.2554443, 21.7408745, 'Περίπτερο', 0),
(9785182275, 38.1494223, 21.6232207, '', 0),
(9785182280, 38.1477412, 21.6206284, '', 0),
(9785335420, 38.1563067, 21.6454791, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategory_id` varchar(50) NOT NULL,
  `subcategory_name` varchar(50) NOT NULL,
  `category_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcategory_id`, `subcategory_name`, `category_id`) VALUES
('26e416b6efa745218f810c34678734b2', 'Στοματική υγιεινή', 4123),
('2d711ee19d17429fa7f964d56fe611db', 'Ροφήματα', 1234),
('3010aca5cbdc401e8dfe1d39320a8d1a', 'Αναψυκτικά - Ενεργειακά Ποτά', 2341),
('3be81b50494d4b5495d5fea3081759a6', 'Είδη γενικού καθαρισμού', 3412),
('4444', 'Τυριά', 1234),
('4f1993ca5bd244329abf1d59746315b8', 'Χυμοί', 2341),
('5a2a0575959c40d6a46614ab99b2d9af', 'Περιποίηση προσώπου', 4123),
('e60aca31a37a40db8a83ccf93bd116b1', 'Απορρυπαντικά', 3412);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `total_score` int(11) NOT NULL,
  `monthly_score` int(11) NOT NULL,
  `total_tokens` int(11) NOT NULL,
  `premonth_tokens` int(11) NOT NULL,
  `offers` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `email`, `password`, `isAdmin`, `total_score`, `monthly_score`, `total_tokens`, `premonth_tokens`, `offers`, `likes`, `dislikes`) VALUES
(1, 'Helena', 'helenat@gmail.com', '1234567890W@', 0, 90, 0, 1324, 0, 3, 0, 0),
(2, 'Petros', 'petroskatsikarelis@gmail.com', '12345678W@', 0, 25, 0, 427, 0, 5, 2, 1),
(3, 'Vasileios', 'billaros218@gmail.com', '12345678Q!', 0, 50, 0, 596, 0, 2, 0, 0),
(4, 'admin', 'admin@gmail.com', '12345678W@', 1, 0, 0, 100, 0, 0, 1, 0),
(5, 'Petros1', 'petros1@gmail.com', '12345678W@', 1, 0, 0, 100, 0, 0, 0, 0),
(6, 'Helena1', 'helena1@gmail.com', '12345678W@', 1, 0, 0, 100, 0, 0, 0, 0),
(7, 'Vasileios1', 'vasileios1@gmail.com', '12345678W@', 1, 0, 0, 100, 0, 0, 0, 0),
(8, 'Petros2', 'petros2@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0),
(9, 'helena2', 'helena2@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0),
(10, 'Vasileios2', 'vasileios2@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0),
(11, 'Petros3', 'petros3@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0),
(12, 'papadopoulos', 'papadopoulos@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0),
(13, 'katsikarelis', 'katsikarelis@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0),
(14, 'thanopoulou', 'thanopoulou@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0),
(15, 'leomessi', 'leomessi@gmail.com', '12345678W@', 0, 0, 0, 100, 0, 0, 0, 0);

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `give_tokens_to_new_user` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    SET NEW.total_tokens = 100;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_like_dislike`
--

CREATE TABLE `user_like_dislike` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `action` enum('like','dislike') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `user_like_dislike`
--
DELIMITER $$
CREATE TRIGGER `decrement_user_likes_dislikes_after_delete` AFTER DELETE ON `user_like_dislike` FOR EACH ROW BEGIN
    
    IF OLD.action = 'like' THEN
        UPDATE `user` SET `likes` = `likes` - 1 WHERE `user_id` = OLD.user_id;
    ELSE
        UPDATE `user` SET `dislikes` = `dislikes` - 1 WHERE `user_id` = OLD.user_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `increment_user_likes_dislikes_after_insert` AFTER INSERT ON `user_like_dislike` FOR EACH ROW BEGIN
    
    IF NEW.action = 'like' THEN
        UPDATE `user` SET `likes` = `likes` + 1 WHERE `user_id` = NEW.user_id;
    ELSE
        UPDATE `user` SET `dislikes` = `dislikes` + 1 WHERE `user_id` = NEW.user_id;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`),
  ADD KEY `category_name_2` (`category_name`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `category_id_2` (`category_id`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`position`),
  ADD KEY `fk_leaderboard_user` (`username`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `fk_offer_product` (`product_name`),
  ADD KEY `fk_offer_user` (`user_username`),
  ADD KEY `fk_offer_shop` (`shop_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `price_variety`
--
ALTER TABLE `price_variety`
  ADD PRIMARY KEY (`price_variety_id`),
  ADD KEY `fk_price_product` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `category_name` (`category_name`),
  ADD KEY `fk_product_category` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `fk_category_subcategory` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_username` (`user_username`);

--
-- Indexes for table `user_like_dislike`
--
ALTER TABLE `user_like_dislike`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`offer_id`),
  ADD KEY `user_like_dislike_ibfk_2` (`offer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `position` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `price_variety`
--
ALTER TABLE `price_variety`
  MODIFY `price_variety_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12302;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_like_dislike`
--
ALTER TABLE `user_like_dislike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `fk_leaderboard_user` FOREIGN KEY (`username`) REFERENCES `user` (`user_username`) ON UPDATE CASCADE;

--
-- Constraints for table `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `fk_offer_product` FOREIGN KEY (`product_name`) REFERENCES `product` (`product_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_offer_shop` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_offer_user` FOREIGN KEY (`user_username`) REFERENCES `user` (`user_username`) ON UPDATE CASCADE;

--
-- Constraints for table `price_variety`
--
ALTER TABLE `price_variety`
  ADD CONSTRAINT `fk_price_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category2` FOREIGN KEY (`category_name`) REFERENCES `category` (`category_name`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `fk_category_subcategory` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_like_dislike`
--
ALTER TABLE `user_like_dislike`
  ADD CONSTRAINT `user_like_dislike_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_like_dislike_ibfk_2` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_offers` ON SCHEDULE EVERY 1 DAY STARTS '2023-08-23 19:32:18' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM offer
    WHERE register_date <= DATE_SUB(NOW(), INTERVAL 7 DAY);
END$$

CREATE DEFINER=`root`@`localhost` EVENT `reset_total_score_monthly` ON SCHEDULE EVERY 1 MONTH STARTS '2023-10-02 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE user SET total_score = NULL;
END$$

CREATE DEFINER=`root`@`localhost` EVENT `MonthlyTokenRedistribution` ON SCHEDULE EVERY 1 MONTH STARTS '2023-09-05 17:21:30' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    CALL UpdateUserTokens();
   
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
