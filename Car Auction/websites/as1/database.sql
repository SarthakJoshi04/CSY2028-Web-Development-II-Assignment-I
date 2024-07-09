-- Adminer 4.8.1 MySQL 11.2.2-MariaDB-1:11.2.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE TABLE `auction` (
  `auction_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `end_date` date NOT NULL,
  `car_image` mediumblob NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`auction_id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `auction_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `auction_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `auction` (`auction_id`, `title`, `description`, `end_date`, `car_image`, `user_id`, `category_id`) VALUES
(2,	'Porsche 911 GT3',	'The Porsche 911 GT3 is a high-performance sports car renowned for its track-focused capabilities and thrilling driving experience. Featuring a naturally aspirated flat-six engine, precise handling, and aerodynamic enhancements, the GT3 represents a pinnacle of Porsche\'s engineering prowess, delivering an exhilarating blend of power and agility for enthusiasts seeking an uncompromising driving experience.',	'2024-03-23',	'porsche911.jpg',	2,	6),
(3,	'BMW X3',	'The BMW X3 is a luxury compact crossover SUV known for its stylish design, premium interior, and dynamic driving characteristics. Offering a well-balanced combination of comfort and sportiness, the X3 caters to those seeking a versatile and upscale vehicle with ample space, advanced technology features, and a refined driving experience.',	'2024-03-24',	'bmwX3.jpg',	2,	9),
(4,	'Toyota GR Supra',	'The 2024 Toyota GR Supra embodies a blend of striking design and high-performance engineering. This sports car, with its turbocharged inline-six engine, offers enthusiasts a thrilling driving experience, complemented by agile handling and a sleek, aerodynamic exterior. Boasting a modern and driver-focused interior, the GR Supra continues the legacy of the iconic Supra model, delivering a perfect fusion of style and performance.',	'2024-03-25',	'supra.jpg',	2,	6),
(5,	'Tesla Model 3',	'The Tesla Model 3 is an all-electric sedan celebrated for its impressive range, cutting-edge technology, and sleek design. Known for its acceleration, the Model 3 features Autopilot capabilities and a minimalist interior with a large touchscreen interface, making it a popular choice for those seeking an environmentally friendly and technologically advanced electric vehicle.',	'2024-03-26',	'tesla3.jpg',	2,	2),
(7,	'Ford Mustang',	'The Ford Mustang is an iconic American muscle car that epitomizes performance and style. Known for its aggressive design, powerful engine options, and exhilarating driving dynamics, the Mustang has been a symbol of the American automotive spirit since its debut. Whether in coupe or convertible form, the Mustang continues to captivate enthusiasts with its timeless appeal and a legacy deeply rooted in the pursuit of driving excitement.',	'2024-03-25',	'mustang.jpg',	4,	3),
(8,	'Chevrolet Bel Air',	'The Chevrolet Bel Air is a classic American car that became an emblem of the automotive industry in the 1950s and 1960s. Known for its distinctive chrome trim, stylish tailfins, and iconic two-tone color schemes, the Bel Air exemplified the era\'s fascination with bold design. As a symbol of post-war prosperity, the Bel Air remains a nostalgic and collectible piece of automotive history, representing an era of elegance and innovation.',	'2024-03-28',	'chevroletbelair.jpg',	4,	8),
(9,	'Honda Accord',	'The Honda Accord is a widely acclaimed midsize sedan known for its reliability, fuel efficiency, and well-rounded driving experience. Renowned for its practicality and thoughtful design, the Accord appeals to a broad range of drivers with its comfortable interior, advanced safety features, and a reputation for delivering a harmonious balance of performance and everyday usability.',	'2024-03-29',	'hondaaccord.jpg',	4,	10),
(10,	'Toyota Prius',	'The Toyota Prius is a pioneering hybrid vehicle that revolutionized the automotive industry by popularizing fuel-efficient and environmentally friendly technology. Renowned for its hybrid powertrain, the Prius combines a gasoline engine with an electric motor to deliver impressive fuel economy, making it a symbol of eco-conscious driving. With a distinctive aerodynamic design, the Prius remains a symbol of sustainability and efficiency in the automotive landscape.',	'2024-03-30',	'toyotaprius.jpg',	4,	7),
(11,	'Jeep Wrangler',	'Conquer off-road terrain with the legendary Jeep Wrangler 4x4. Built for adventure, this rugged vehicle is ready to tackle any trail.',	'2024-03-24',	'jeepwrangler.jpg',	4,	5),
(12,	'BMW 7',	'Command attention on the road with the BMW 7 Series Saloon. This executive saloon offers a luxurious and powerful driving experience.',	'2024-03-18',	'bmw7.jpg',	4,	4),
(15,	'BYD Atto 3',	'The BYD ATTO 3 is a fully electric compact SUV that emphasizes both style and safety.  It boasts a range of up to 420 kilometers (261 miles) on a single charge and comes equipped with advanced driver-assistance features to keep you secure on the road.',	'2024-03-25',	'bydatto3.jpg',	3,	2),
(16,	'Lamborghini Urus',	'The Lamborghini Urus is the world\'s first super SUV, blending the heart of a Lamborghini supercar with the functionality of an SUV. It boasts a powerful twin-turbo V8 engine for incredible acceleration and a luxurious interior for comfortable cruising on any road.',	'2024-03-26',	'lamborghiniurus.jpg',	3,	9),
(22,	'Rolls Royce Phantom',	'The Rolls Royce Phantom is the epitome of luxury motoring. It boasts a powerful V12 engine for a smooth ride and an exquisitely crafted interior designed for ultimate comfort and personalization.',	'2024-03-24',	'rollsroycephantom.jpg',	3,	13),
(23,	'Bugatti Chiron',	'The Bugatti Chiron is a high-performance hypercar known for its unparalleled speed and luxury. With a quad-turbocharged W16 engine producing over 1,500 horsepower, the Chiron can reach speeds exceeding 260 mph, making it one of the fastest production cars in the world. Its sleek design, cutting-edge technology, and limited production numbers contribute to its reputation as a pinnacle of automotive engineering and opulence.',	'2024-03-28',	'bugattichiron.jpg',	3,	6),
(24,	'Koenigsegg Agera',	'The Koenigsegg Agera is an exceptional hypercar renowned for its remarkable performance and cutting-edge engineering. Equipped with a powerful twin-turbocharged V8 engine, the Agera boasts an impressive combination of speed and agility. Its aerodynamic design, lightweight construction, and advanced technologies contribute to its status as a pinnacle of automotive innovation and luxury.',	'2024-03-24',	'koenigseggagera.jpg',	3,	6),
(25,	'Ford Ranger',	'The Ford Ranger is a midsize pickup truck known for its versatile performance and rugged design. Renowned for its capability both on and off the road, the Ranger offers a practical and comfortable driving experience. With a range of engine options and modern features, it caters to individuals seeking a reliable and efficient pickup for various lifestyles and work needs.',	'2024-03-13',	'fordranger.jpg',	3,	5);

CREATE TABLE `bid` (
  `bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `bid_amount` int(10) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`bid_id`),
  KEY `auction_id` (`auction_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`auction_id`) REFERENCES `auction` (`auction_id`),
  CONSTRAINT `bid_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `bid` (`bid_id`, `bid_amount`, `auction_id`, `user_id`) VALUES
(1,	72000,	12,	2),
(3,	32000,	15,	2),
(4,	91000,	2,	3),
(5,	68000,	11,	3),
(6,	67000,	7,	3),
(7,	50000,	3,	4),
(8,	100000,	22,	4),
(9,	89000,	4,	4),
(10,	26000,	5,	4),
(11,	12000,	25,	2);

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1,	'Estate'),
(2,	'Electric'),
(3,	'Coupe'),
(4,	'Saloon'),
(5,	'4x4'),
(6,	'Sports'),
(7,	'Hybrid'),
(8,	'Vintage'),
(9,	'SUV'),
(10,	'Sedan'),
(13,	'Luxury');

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `review_text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `review` (`review_id`, `review_text`, `user_id`) VALUES
(1,	'user2 said: Mine had a bit of a scratch on the side. But the delivery was on time. Still, a little disappointed because of the damaged car.',	4),
(2,	'user1 said: Totally satisfied. Great value and the delivery was quick. Much appreciated!!!',	4),
(3,	'user3 said: The car was good but I can\'t say the same for the delivery. They really tested my patience.',	3),
(4,	'user3 said: When I got the car, it was a different car from what they had posted in the website. Had to go through extra hassle to return it.',	2);

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`user_id`, `email`, `username`, `password`) VALUES
(1,	'admin@gmail.com',	'admin',	'$2y$10$tlsMT2F1OHvGYV24j.29FOZMRv/zqB08zjaKPEMa1Hox6cu41ZSxi'),
(2,	'user1@gmail.com',	'user1',	'$2y$10$EJmj71qztHcrdoVLwvCrveV/5UnRQZzD80evGmy9.hZmYk4gglOte'),
(3,	'user2@gmail.com',	'user2',	'$2y$10$2Jj1eS3NxZcb60Qnf.BtU.QU74elUGoSKU3jE8MCHKDho.8pwtZPe'),
(4,	'user3@gmail.com',	'user3',	'$2y$10$0QP.wSP.tfHpJGjy9fePcesLWttZVXw3ZI8I6Jn5F6W/BSFcH1zvK');

-- 2024-03-11 14:43:00