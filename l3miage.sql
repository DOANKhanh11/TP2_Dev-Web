-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 avr. 2026 à 07:30
-- Version du serveur : 8.4.7
-- Version de PHP : 8.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `l3miage`
--

-- --------------------------------------------------------

--
-- Structure de la table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_id` (`cart_id`,`product_id`),
  KEY `idx_cart` (`cart_id`),
  KEY `idx_product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) DEFAULT '0.00',
  `stock` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `seuil_alerte` int DEFAULT '5',
  `category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roast_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight_g` int DEFAULT NULL,
  `tag` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_updated_at` (`updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `created_at`, `updated_at`, `seuil_alerte`, `category`, `origin`, `roast_level`, `weight_g`, `tag`) VALUES
(1, 'Arabica Cầu Đất Premium', 'Arabica cultivé à 1500m d altitude à Cầu Đất - Đà Lạt. Notes de fleurs et fruits, acidité douce et élégante.', 5.00, 50, '2026-04-07 09:04:09', '2026-04-07 07:05:10', 8, 'Grains entiers', 'Đà Lạt', 'Medium', 500, 'Nouveau'),
(2, 'Robusta Buôn Ma Thuột', 'Robusta emblématique de Đắk Lắk. Très corsé, amertume prononcée, crema épaisse. Idéal pour le phin.', 5.00, 80, '2026-04-07 09:04:09', '2026-04-07 07:08:56', 10, 'Grains entiers', 'Đắk Lắk', 'Dark', 500, ''),
(3, 'Moka Cầu Đất Rare', 'Variété Moka rarissime. Arôme de jasmin intense, douceur naturelle exceptionnelle.', 320000.00, 15, '2026-04-07 09:04:09', NULL, 3, 'Grains entiers', 'Đà Lạt', 'Medium-Light', 250, 'Nouveau'),
(4, 'Blend Saïgon Traditionnel', 'Assemblage Robusta 70% + Arabica 30%. Goût intense et traditionnel, parfait pour le phin vietnamien.', 95000.00, 100, '2026-04-07 09:04:09', NULL, 15, 'Grains entiers', 'TP.HCM', 'Dark', 500, ''),
(5, 'Arabica Gia Lai Single Origin', 'Arabica des hauts plateaux de Gia Lai. Profil fruité, légère acidité, notes d agrumes.', 210000.00, 30, '2026-04-07 09:04:09', NULL, 5, 'Grains entiers', 'Gia Lai', 'Medium', 500, ''),
(6, 'Robusta Đắk Nông Bio', 'Robusta cultivé en agriculture biologique, sans pesticides. Certifié bio, goût pur et naturel.', 155000.00, 25, '2026-04-07 09:04:09', NULL, 5, 'Grains entiers', 'Đắk Nông', 'Medium-Dark', 500, 'Nouveau'),
(7, 'Catimor Kon Tum', 'Variété Catimor résistante, cultivée à Kon Tum. Corps plein, notes de chocolat et caramel.', 140000.00, 40, '2026-04-07 09:04:09', NULL, 8, 'Grains entiers', 'Kon Tum', 'Dark', 500, ''),
(8, 'Blend Hanoi Classique', 'Assemblage traditionnel du Nord Vietnam. Doux et aromatique, adapté à la culture café de Hà Nội.', 110000.00, 60, '2026-04-07 09:04:09', NULL, 10, 'Grains entiers', 'Hà Nội', 'Medium', 500, 'Promo'),
(9, 'Trung Nguyên G7 Moulu', 'Grand blend Trung Nguyên finement moulu. Compatible phin et drip. Le plus vendu du Vietnam.', 145000.00, 60, '2026-04-07 09:04:09', NULL, 10, 'Café moulu', 'Đắk Lắk', 'Dark', 500, ''),
(10, 'Highlands Coffee Blend Moulu', 'Blend signature Highlands Coffee. Corps moyen, arôme persistant, mouture adaptée au filtre.', 110000.00, 75, '2026-04-07 09:04:09', NULL, 10, 'Café moulu', 'Đắk Nông', 'Medium-Dark', 200, 'Promo'),
(11, 'Mê Trang Arabica Moulu', 'Arabica moulu Mê Trang. Légère acidité, notes de fruits rouges, parfait en drip ou cafetière.', 135000.00, 40, '2026-04-07 09:04:09', NULL, 5, 'Café moulu', 'Khánh Hòa', 'Medium', 250, ''),
(12, 'Phúc Long Moulu Premium', 'Mouture premium de la maison Phúc Long. Arôme floral délicat, corps léger et raffiné.', 165000.00, 35, '2026-04-07 09:04:09', NULL, 5, 'Café moulu', 'TP.HCM', 'Medium-Light', 250, ''),
(13, 'An Thái Robusta Moulu', 'Robusta local d An Thái, mouture grossière pour phin. Très fort, saveur authentique.', 85000.00, 90, '2026-04-07 09:04:09', NULL, 15, 'Café moulu', 'Bình Định', 'Dark', 500, ''),
(14, 'G7 3-en-1 Boîte 20 sachets', 'Café instantané 3-en-1 Trung Nguyên. Pratique, goût corsé, se dissout instantanément.', 75000.00, 200, '2026-04-07 09:04:09', NULL, 20, 'Instantané', 'TP.HCM', 'Dark', 280, ''),
(15, 'Vinacafé 3-en-1 Boîte 20 sachets', 'Marque historique vietnamienne. Douceur équilibrée, dissolution rapide, format voyage idéal.', 55000.00, 150, '2026-04-07 09:04:09', NULL, 20, 'Instantané', 'Đồng Nai', 'Medium', 320, ''),
(16, 'Nescafé Vietnam 3-en-1', 'Version vietnamienne de Nescafé, plus sucrée et corsée qu en Europe. Format 20 sachets.', 65000.00, 120, '2026-04-07 09:04:09', NULL, 15, 'Instantané', 'Đồng Nai', 'Medium', 300, ''),
(17, 'G7 Black Americano Boîte 15 sachets', 'Café noir sans sucre ni lait. Format stick, pur arabica soluble. Pour les amateurs de café noir.', 85000.00, 80, '2026-04-07 09:04:09', NULL, 10, 'Instantané', 'Đắk Lắk', 'Dark', 150, 'Nouveau'),
(18, 'King Coffee 3-en-1 Boîte 20 sachets', 'Marque internationale de Mme Thảo. Goût premium, crémeux, packaging moderne.', 90000.00, 60, '2026-04-07 09:04:09', NULL, 10, 'Instantané', 'TP.HCM', 'Medium-Dark', 300, ''),
(19, 'Phúc Long Instantané Boîte 10 sachets', 'Café instantané haut de gamme Phúc Long. Notes florales préservées malgré la solubilisation.', 95000.00, 3, '2026-04-07 09:04:09', NULL, 8, 'Instantané', 'TP.HCM', 'Medium-Light', 150, ''),
(20, 'Cà Phê Chồn Weasel Authentique', 'Café Weasel 100% authentique. Arôme complexe et enveloppant, corps soyeux. La référence du café de luxe vietnamien.', 850000.00, 8, '2026-04-07 09:04:09', NULL, 2, 'Spécialité', 'Đắk Lắk', 'Medium', 100, ''),
(21, 'Cà Phê Chồn Blend 50%', 'Mélange 50% Weasel + 50% Arabica premium. Expérience Weasel accessible, arôme remarquable.', 420000.00, 12, '2026-04-07 09:04:09', NULL, 3, 'Spécialité', 'Đắk Lắk', 'Medium', 200, 'Promo'),
(22, 'Café aux Œufs de Hà Nội', 'Recette traditionnelle de Hà Nội : jaune d œuf battu en mousse épaisse sur café noir. Onctueux et unique.', 38000.00, 4, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Hà Nội', 'Dark', 0, ''),
(23, 'Café au Sel de Đà Nẵng', 'Spécialité de Đà Nẵng : crème salée légèrement sucrée sur café noir. Contraste savoureux et surprenant.', 45000.00, 2, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Đà Nẵng', 'Dark', 0, 'Nouveau'),
(24, 'Café à la Noix de Coco', 'Café vietnamien mélangé à du lait de coco frais. Doux, exotique, très populaire à Hội An.', 42000.00, 20, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Hội An', 'Medium', 0, ''),
(25, 'Cà Phê Muối Crème Salée', 'Version en kit à préparer chez soi. Inclut poudre de café, mix crème salée. 10 portions.', 120000.00, 15, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Đà Nẵng', 'Dark', 150, 'Nouveau'),
(26, 'Café Beurre de Cacahuète', 'Fusion créative : café robusta + beurre de cacahuète vietnamien. Notes grillées, très gourmand.', 48000.00, 10, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'TP.HCM', 'Dark', 0, 'Nouveau'),
(27, 'Phin Aluminium Traditionnel 8cm', 'Filtre phin classique en aluminium. Diamètre 8cm, 1 tasse. Fabrication vietnamienne traditionnelle.', 25000.00, 30, '2026-04-07 09:04:09', NULL, 5, 'Accessoires', 'Việt Nam', NULL, 150, ''),
(28, 'Phin Inox Premium 10cm', 'Phin en inox 304 alimentaire. Diamètre 10cm, 2 tasses. Bonne rétention de chaleur, très durable.', 65000.00, 15, '2026-04-07 09:04:09', NULL, 3, 'Accessoires', 'Việt Nam', NULL, 200, 'Nouveau'),
(29, 'Phin Inox Double Paroi 12cm', 'Phin professionnel double paroi, maintien thermique optimal. Idéal pour les amateurs exigeants.', 120000.00, 8, '2026-04-07 09:04:09', NULL, 3, 'Accessoires', 'Việt Nam', NULL, 280, ''),
(30, 'Verre À Café Vietnamien 200ml', 'Verre traditionnel vietnamien avec socle métallique. Lot de 4 verres. Style authentique des cafés de rue.', 85000.00, 20, '2026-04-07 09:04:09', NULL, 5, 'Accessoires', 'Việt Nam', NULL, 400, ''),
(31, 'Kit Dégustation Phin Complet', 'Set cadeau : 1 phin inox 10cm + 2 verres + 200g café Robusta Buôn Ma Thuột moulu. Idéal en cadeau.', 250000.00, 10, '2026-04-07 09:04:09', NULL, 2, 'Accessoires', 'Việt Nam', NULL, 600, 'Nouveau'),
(32, 'Cuillère Doseuse Café', 'Cuillère doseuse en inox, 10g par mesure. Gravure Vietnam. Accessoire indispensable pour le phin.', 15000.00, 50, '2026-04-07 09:04:09', NULL, 10, 'Accessoires', 'Việt Nam', NULL, 30, ''),
(33, 'Boîte Conservation Café Hermétique', 'Boîte hermétique avec valve d évacuation CO2. Conserve la fraîcheur des grains jusqu à 6 mois. 500ml.', 95000.00, 12, '2026-04-07 09:04:09', NULL, 3, 'Accessoires', 'Việt Nam', NULL, 250, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
