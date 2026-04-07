-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 avr. 2026 à 07:09
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

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
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) DEFAULT '0.00',
  `stock` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `seuil_alerte` int DEFAULT '5',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roast_level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight_g` int DEFAULT NULL,
  `tag` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `created_at`, `updated_at`, `seuil_alerte`, `category`, `origin`, `roast_level`, `weight_g`, `tag`) VALUES
('f9718df0-324f-11f1-beae-9c2dcde5cc07', 'Arabica Cầu Đất Premium', 'Arabica cultivé à 1500m d altitude à Cầu Đất - Đà Lạt. Notes de fleurs et fruits, acidité douce et élégante.', 5.00, 50, '2026-04-07 09:04:09', '2026-04-07 07:05:10', 8, 'Grains entiers', 'Đà Lạt', 'Medium', 500, 'Nouveau'),
('f971af54-324f-11f1-beae-9c2dcde5cc07', 'Robusta Buôn Ma Thuột', 'Robusta emblématique de Đắk Lắk. Très corsé, amertume prononcée, crema épaisse. Idéal pour le phin.', 5.00, 80, '2026-04-07 09:04:09', '2026-04-07 07:08:56', 10, 'Grains entiers', 'Đắk Lắk', 'Dark', 500, ''),
('f971b24a-324f-11f1-beae-9c2dcde5cc07', 'Moka Cầu Đất Rare', 'Variété Moka rarissime. Arôme de jasmin intense, douceur naturelle exceptionnelle.', 320000.00, 15, '2026-04-07 09:04:09', NULL, 3, 'Grains entiers', 'Đà Lạt', 'Medium-Light', 250, 'Nouveau'),
('f971b470-324f-11f1-beae-9c2dcde5cc07', 'Blend Saïgon Traditionnel', 'Assemblage Robusta 70% + Arabica 30%. Goût intense et traditionnel, parfait pour le phin vietnamien.', 95000.00, 100, '2026-04-07 09:04:09', NULL, 15, 'Grains entiers', 'TP.HCM', 'Dark', 500, ''),
('f971b63b-324f-11f1-beae-9c2dcde5cc07', 'Arabica Gia Lai Single Origin', 'Arabica des hauts plateaux de Gia Lai. Profil fruité, légère acidité, notes d agrumes.', 210000.00, 30, '2026-04-07 09:04:09', NULL, 5, 'Grains entiers', 'Gia Lai', 'Medium', 500, ''),
('f971b81d-324f-11f1-beae-9c2dcde5cc07', 'Robusta Đắk Nông Bio', 'Robusta cultivé en agriculture biologique, sans pesticides. Certifié bio, goût pur et naturel.', 155000.00, 25, '2026-04-07 09:04:09', NULL, 5, 'Grains entiers', 'Đắk Nông', 'Medium-Dark', 500, 'Nouveau'),
('f971b9c6-324f-11f1-beae-9c2dcde5cc07', 'Catimor Kon Tum', 'Variété Catimor résistante, cultivée à Kon Tum. Corps plein, notes de chocolat et caramel.', 140000.00, 40, '2026-04-07 09:04:09', NULL, 8, 'Grains entiers', 'Kon Tum', 'Dark', 500, ''),
('f971bc0f-324f-11f1-beae-9c2dcde5cc07', 'Blend Hanoi Classique', 'Assemblage traditionnel du Nord Vietnam. Doux et aromatique, adapté à la culture café de Hà Nội.', 110000.00, 60, '2026-04-07 09:04:09', NULL, 10, 'Grains entiers', 'Hà Nội', 'Medium', 500, 'Promo'),
('f971bde1-324f-11f1-beae-9c2dcde5cc07', 'Trung Nguyên G7 Moulu', 'Grand blend Trung Nguyên finement moulu. Compatible phin et drip. Le plus vendu du Vietnam.', 145000.00, 60, '2026-04-07 09:04:09', NULL, 10, 'Café moulu', 'Đắk Lắk', 'Dark', 500, ''),
('f971bf6a-324f-11f1-beae-9c2dcde5cc07', 'Highlands Coffee Blend Moulu', 'Blend signature Highlands Coffee. Corps moyen, arôme persistant, mouture adaptée au filtre.', 110000.00, 75, '2026-04-07 09:04:09', NULL, 10, 'Café moulu', 'Đắk Nông', 'Medium-Dark', 200, 'Promo'),
('f971c0e8-324f-11f1-beae-9c2dcde5cc07', 'Mê Trang Arabica Moulu', 'Arabica moulu Mê Trang. Légère acidité, notes de fruits rouges, parfait en drip ou cafetière.', 135000.00, 40, '2026-04-07 09:04:09', NULL, 5, 'Café moulu', 'Khánh Hòa', 'Medium', 250, ''),
('f971c282-324f-11f1-beae-9c2dcde5cc07', 'Phúc Long Moulu Premium', 'Mouture premium de la maison Phúc Long. Arôme floral délicat, corps léger et raffiné.', 165000.00, 35, '2026-04-07 09:04:09', NULL, 5, 'Café moulu', 'TP.HCM', 'Medium-Light', 250, ''),
('f971c450-324f-11f1-beae-9c2dcde5cc07', 'An Thái Robusta Moulu', 'Robusta local d An Thái, mouture grossière pour phin. Très fort, saveur authentique.', 85000.00, 90, '2026-04-07 09:04:09', NULL, 15, 'Café moulu', 'Bình Định', 'Dark', 500, ''),
('f971c5f7-324f-11f1-beae-9c2dcde5cc07', 'G7 3-en-1 Boîte 20 sachets', 'Café instantané 3-en-1 Trung Nguyên. Pratique, goût corsé, se dissout instantanément.', 75000.00, 200, '2026-04-07 09:04:09', NULL, 20, 'Instantané', 'TP.HCM', 'Dark', 280, ''),
('f971c7c3-324f-11f1-beae-9c2dcde5cc07', 'Vinacafé 3-en-1 Boîte 20 sachets', 'Marque historique vietnamienne. Douceur équilibrée, dissolution rapide, format voyage idéal.', 55000.00, 150, '2026-04-07 09:04:09', NULL, 20, 'Instantané', 'Đồng Nai', 'Medium', 320, ''),
('f971ca26-324f-11f1-beae-9c2dcde5cc07', 'Nescafé Vietnam 3-en-1', 'Version vietnamienne de Nescafé, plus sucrée et corsée qu en Europe. Format 20 sachets.', 65000.00, 120, '2026-04-07 09:04:09', NULL, 15, 'Instantané', 'Đồng Nai', 'Medium', 300, ''),
('f971cbe6-324f-11f1-beae-9c2dcde5cc07', 'G7 Black Americano Boîte 15 sachets', 'Café noir sans sucre ni lait. Format stick, pur arabica soluble. Pour les amateurs de café noir.', 85000.00, 80, '2026-04-07 09:04:09', NULL, 10, 'Instantané', 'Đắk Lắk', 'Dark', 150, 'Nouveau'),
('f971cda6-324f-11f1-beae-9c2dcde5cc07', 'King Coffee 3-en-1 Boîte 20 sachets', 'Marque internationale de Mme Thảo. Goût premium, crémeux, packaging moderne.', 90000.00, 60, '2026-04-07 09:04:09', NULL, 10, 'Instantané', 'TP.HCM', 'Medium-Dark', 300, ''),
('f971d013-324f-11f1-beae-9c2dcde5cc07', 'Phúc Long Instantané Boîte 10 sachets', 'Café instantané haut de gamme Phúc Long. Notes florales préservées malgré la solubilisation.', 95000.00, 3, '2026-04-07 09:04:09', NULL, 8, 'Instantané', 'TP.HCM', 'Medium-Light', 150, ''),
('f971d5fa-324f-11f1-beae-9c2dcde5cc07', 'Cà Phê Chồn Weasel Authentique', 'Café Weasel 100% authentique. Arôme complexe et enveloppant, corps soyeux. La référence du café de luxe vietnamien.', 850000.00, 8, '2026-04-07 09:04:09', NULL, 2, 'Spécialité', 'Đắk Lắk', 'Medium', 100, ''),
('f971d91e-324f-11f1-beae-9c2dcde5cc07', 'Cà Phê Chồn Blend 50%', 'Mélange 50% Weasel + 50% Arabica premium. Expérience Weasel accessible, arôme remarquable.', 420000.00, 12, '2026-04-07 09:04:09', NULL, 3, 'Spécialité', 'Đắk Lắk', 'Medium', 200, 'Promo'),
('f971efe3-324f-11f1-beae-9c2dcde5cc07', 'Café aux Œufs de Hà Nội', 'Recette traditionnelle de Hà Nội : jaune d œuf battu en mousse épaisse sur café noir. Onctueux et unique.', 38000.00, 4, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Hà Nội', 'Dark', 0, ''),
('f971f184-324f-11f1-beae-9c2dcde5cc07', 'Café au Sel de Đà Nẵng', 'Spécialité de Đà Nẵng : crème salée légèrement sucrée sur café noir. Contraste savoureux et surprenant.', 45000.00, 2, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Đà Nẵng', 'Dark', 0, 'Nouveau'),
('f971f281-324f-11f1-beae-9c2dcde5cc07', 'Café à la Noix de Coco', 'Café vietnamien mélangé à du lait de coco frais. Doux, exotique, très populaire à Hội An.', 42000.00, 20, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Hội An', 'Medium', 0, ''),
('f971f3dc-324f-11f1-beae-9c2dcde5cc07', 'Cà Phê Muối Crème Salée', 'Version en kit à préparer chez soi. Inclut poudre de café, mix crème salée. 10 portions.', 120000.00, 15, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'Đà Nẵng', 'Dark', 150, 'Nouveau'),
('f971f5eb-324f-11f1-beae-9c2dcde5cc07', 'Café Beurre de Cacahuète', 'Fusion créative : café robusta + beurre de cacahuète vietnamien. Notes grillées, très gourmand.', 48000.00, 10, '2026-04-07 09:04:09', NULL, 5, 'Spécialité', 'TP.HCM', 'Dark', 0, 'Nouveau'),
('f971f807-324f-11f1-beae-9c2dcde5cc07', 'Phin Aluminium Traditionnel 8cm', 'Filtre phin classique en aluminium. Diamètre 8cm, 1 tasse. Fabrication vietnamienne traditionnelle.', 25000.00, 30, '2026-04-07 09:04:09', NULL, 5, 'Accessoires', 'Việt Nam', NULL, 150, ''),
('f971faae-324f-11f1-beae-9c2dcde5cc07', 'Phin Inox Premium 10cm', 'Phin en inox 304 alimentaire. Diamètre 10cm, 2 tasses. Bonne rétention de chaleur, très durable.', 65000.00, 15, '2026-04-07 09:04:09', NULL, 3, 'Accessoires', 'Việt Nam', NULL, 200, 'Nouveau'),
('f971fcea-324f-11f1-beae-9c2dcde5cc07', 'Phin Inox Double Paroi 12cm', 'Phin professionnel double paroi, maintien thermique optimal. Idéal pour les amateurs exigeants.', 120000.00, 8, '2026-04-07 09:04:09', NULL, 3, 'Accessoires', 'Việt Nam', NULL, 280, ''),
('f971ff17-324f-11f1-beae-9c2dcde5cc07', 'Verre À Café Vietnamien 200ml', 'Verre traditionnel vietnamien avec socle métallique. Lot de 4 verres. Style authentique des cafés de rue.', 85000.00, 20, '2026-04-07 09:04:09', NULL, 5, 'Accessoires', 'Việt Nam', NULL, 400, ''),
('f9720159-324f-11f1-beae-9c2dcde5cc07', 'Kit Dégustation Phin Complet', 'Set cadeau : 1 phin inox 10cm + 2 verres + 200g café Robusta Buôn Ma Thuột moulu. Idéal en cadeau.', 250000.00, 10, '2026-04-07 09:04:09', NULL, 2, 'Accessoires', 'Việt Nam', NULL, 600, 'Nouveau'),
('f972033c-324f-11f1-beae-9c2dcde5cc07', 'Cuillère Doseuse Café', 'Cuillère doseuse en inox, 10g par mesure. Gravure Vietnam. Accessoire indispensable pour le phin.', 15000.00, 50, '2026-04-07 09:04:09', NULL, 10, 'Accessoires', 'Việt Nam', NULL, 30, ''),
('f972059c-324f-11f1-beae-9c2dcde5cc07', 'Boîte Conservation Café Hermétique', 'Boîte hermétique avec valve d évacuation CO2. Conserve la fraîcheur des grains jusqu à 6 mois. 500ml.', 95000.00, 12, '2026-04-07 09:04:09', NULL, 3, 'Accessoires', 'Việt Nam', NULL, 250, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
