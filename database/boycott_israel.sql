-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 02:52 AM
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
-- Database: `boycott_israel`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternative_products`
--

CREATE TABLE `alternative_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'active',
  `ref_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alternative_products`
--

INSERT INTO `alternative_products` (`id`, `name`, `brand`, `image`, `link`, `status`, `ref_id`, `created_at`, `description`) VALUES
(1, 'Mojo', 'AKIJ', 'https://i.chaldn.com/_mpimage/mojo-soft-drink-2-ltr?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D130804&q=best&v=1', 'https://www.akijfood.com/', 'active', 11, '2025-04-08 06:59:38', 'Mojo is a cola flavored carbonated soft drink manufactured by the Akij Food and Beverage Limited (AFBL).[1] The soft drink brand Mojo has been recognized by Bangladesh Brand Forum as the \"number one beverage brand in Bangladesh\" in the \"Best Brand Award 2024\".'),
(5, 'Rc Cola', 'Dr Pepper', 'https://www.bdgift.com/pp/beverage/bv614.jpg', 'https://en.wikipedia.org/wiki/RC_Cola', 'active', 11, '2025-04-08 08:17:47', NULL),
(7, 'Fresh Cola', 'Fresh', 'https://www.mgi.org/assets/images/sku/Fresh-Cola-250.jpg', 'https://www.mgi.org/businessverticals/beverage-cold', 'active', 11, '2025-04-08 08:22:21', 'Fresh Cola is a unique and exciting drink prepared to match the taste of the new generation. Made from a full state of the art technology. Made in Bangladesh'),
(8, 'Fresh Cola', 'Fresh', 'https://www.mgi.org/assets/images/sku/Fresh-Cola-250.jpg', 'https://www.mgi.org/businessverticals/beverage-cold', 'active', 11, '2025-04-08 08:25:18', 'Fresh Cola is a unique and exciting drink prepared to match the taste of the new generation. Made from a full state of the art technology. Made in Bangladesh');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Food & Beverages', 'Packaged food, snacks, soft drinks, and beverages', '2025-04-12 07:49:34'),
(2, 'Electronics', 'Phones, laptops, accessories, and electronic gadgets', '2025-04-12 07:49:34'),
(3, 'Personal Care', 'Skincare, soaps, shampoos, and cosmetics', '2025-04-12 07:49:34'),
(4, 'Cleaning Products', 'Detergents, surface cleaners, and sanitizers', '2025-04-12 07:49:34'),
(5, 'Health & Wellness', 'Medicines, supplements, and wellness items', '2025-04-12 07:49:34'),
(6, 'Baby Products', 'Diapers, baby food, and care items', '2025-04-12 07:49:34'),
(7, 'Clothing', 'Apparel and fashion items', '2025-04-12 07:49:34'),
(8, 'Shoes', 'Footwear including casual, formal, and sports shoes', '2025-04-12 07:49:34'),
(9, 'Jewelry & Accessories', 'Watches, sunglasses, jewelry', '2025-04-12 07:49:34'),
(10, 'Supermarket Essentials', 'Groceries and daily household items', '2025-04-12 07:49:34'),
(11, 'Kitchen & Home Appliances', 'Mixers, grinders, electric kettles, etc.', '2025-04-12 07:49:34'),
(12, 'Snacks & Confectionery', 'Chips, chocolates, candies, biscuits', '2025-04-12 07:49:34'),
(13, 'Dairy Products', 'Milk, butter, cheese, yogurt, etc.', '2025-04-12 07:49:34'),
(14, 'Meat & Seafood', 'Packaged meats and seafood', '2025-04-12 07:49:34'),
(15, 'Bottled Water & Juices', 'Packaged drinking water and juices', '2025-04-12 07:49:34'),
(16, 'Bags & Backpacks', 'School bags, travel bags, handbags', '2025-04-12 07:49:34'),
(17, 'Books & Stationery', 'Notebooks, pens, educational materials', '2025-04-12 07:49:34'),
(18, 'Batteries & Power', 'Batteries, chargers, power strips', '2025-04-12 07:49:34'),
(19, 'Telecom & SIM', 'Mobile SIM cards and telecom services', '2025-04-12 07:49:34'),
(20, 'Alcohol & Tobacco', 'Beer, wine, cigarettes, cigars', '2025-04-12 07:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `is_israeli` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `image`, `link`, `is_israeli`, `description`, `status`, `category_id`, `created_by`, `created_at`) VALUES
(11, 'Coke', 'CocaCola', 'https://gofresh.com.bd/wp-content/uploads/2020/04/coca-cola-bottle-1.jpg', 'https://www.coca-colacompany.com', 1, 'The Central Beverage Company, known as Coca-Cola Israel, is a private Israeli manufacturer and distributor of soft drinks, dairy products and alcoholic beverages. The company is the exclusive franchisee of The Coca-Cola Company in Israel.', 'active', 1, 1, '2025-04-12 23:04:49'),
(14, 'Pepsi', 'Pepsico', 'https://m.media-amazon.com/images/I/91LnEhnul6L._SL1500_.jpg', 'http://example.com/link/to/document', 1, '', 'inactive', 1, 1, '2025-04-12 23:04:49'),
(17, '7up ', 'Pepsico', 'https://images.othoba.com/images/thumbs/0561350_7-up-500ml-pet-bottle.jpeg', 'http://example.com/link/to/document', 1, '', 'active', 1, 2, '2025-04-12 23:04:49'),
(18, 'Cadbury 5 Star', 'Mondelez International', 'https://rasanasa.com/public/uploads/all/1jTjPLPZR47np1cItghaTV3UNLCFJ8R4XUtKLeSk.jpg', 'https://www.foodbusinessnews.net/articles/17261-mondelez-invests-in-israel-food-tech-startup#:~:text=CHICAGO%20%E2%80%94%20Mondelez%20International%20Inc.%20on,%2Dtextural%2C%20sensorial%20experiences.%E2%80%9D', 1, 'ondelez International Inc. on Nov. 10 announced a seed investment in Torr FoodTech, an early stage company based in Israel that has developed proprietary technology Mondelez said “brings real, simple ingredients together to offer multi-textural, sensorial experiences', 'pending', 1, 1, '2025-04-12 23:04:49'),
(21, 'Wheel', 'Wheel', 'https://i.chaldn.com/_mpimage/wheel-washing-powder-2-in-1-clean-fresh-1-kg?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D128372&q=best&v=1', 'https://www.example.com/info', 1, 'A high-quality wheel product manufactured in Israel.', 'active', 2, 1, '2025-04-12 17:04:49'),
(22, 'Adidas', 'Adidas', 'https://media.very.co.uk/i/very/VV6CT_SQ1_0000000019_BLACK_WHITE_ASf', 'https://www.example.com/info', 1, 'A premium sportswear brand product available in the Israeli market.', 'active', 7, 1, '2025-04-12 17:04:49'),
(23, 'Cisco', 'Cisco', 'https://eu-images.contentstack.com/v3/assets/blt6d90778a997de1cd/blt4637c2d1f49b2a24/654e3a154a99bf040afdf1fa/cisco_Anucha_Cheechang_shutterstock.jpg', 'https://www.example.com/info', 1, 'The Company integrates platforms across networking, security, collaboration, applications and the cloud. Through its fully owned Israeli subsidiaries, Cisco Systems has a broad base of complicity with Israel’s occupation economy, predominantly through the provision of services to the Israeli military.', 'active', 2, 1, '2025-04-12 17:04:49'),
(24, 'Dell', 'Dell', 'https://yt3.googleusercontent.com/pZP2iQbfmYh_U1LnzYud2wcVFvkkk-NFS1zVl_jHKFevbZeFn7mz_hjh126y8RD_CPy5LlZW=s900-c-k-c0x00ffffff-no-rj', 'https://www.example.com/info', 1, 'Dell\'s products include personal computers and servers. In 2023, Dell Technologies won the Israeli Ministry of Defense\'s server tender, which is considered the largest server tender in Israel so far. The scope is USD 150 million for a period of two years, during which Dell will provide servers and maintenance to the Israeli military and the Israeli Ministry of Defense (IMOD). The Michael & Susan Dell Foundation, established by Dell\'s founders, is known to provide direct support to Israel.', 'active', 2, 1, '2025-04-12 17:04:49'),
(25, 'Apple', 'Apple', 'https://yt3.googleusercontent.com/s5hlNKKDDQWjFGzYNnh8UeOW2j2w6id-cZGx7GdAA3d5Fu7zEi7ZMXEyslysuQUKigXNxtAB=s900-c-k-c0x00ffffff-no-rj', 'https://www.example.com/info', 1, 'Acquired several Israeli companies and conducts limited R&D activities in Israel focusing on semiconductor technologies. Apple matches worker donations to IDF and illegal settlements, employees allege although not confirmed.', 'active', 2, 1, '2025-04-12 17:04:49'),
(27, 'Google', 'Google', 'https://play-lh.googleusercontent.com/1-hPxafOxdYpYZEOKzNIkSP43HXCNftVJVttoo4ucl7rsMASXW3Xr6GlXURCubE1tA=w3840-h2160-rw', 'https://www.example.com/info', 1, 'Google has established R&D centers in Israel, focusing primarily on search algorithms, advertising technologies, and security. Additionally, it has acquired Israeli startups, including Waze. In collaboration with Amazon, Google launched Project Nimbus in 2021 to provide cloud services to the Israeli government and military. While this project aims to enhance Israel\'s technological infrastructure, it has also faced criticism for aiding surveillance and impacting Palestinian rights.', 'active', 2, 1, '2025-04-12 17:04:49'),
(28, 'HP', 'HP', 'https://logos-world.net/wp-content/uploads/2020/11/HP-Logo.png', 'https://www.example.com/info', 1, 'HP has R&D centers in Kiryat Gat contributing to printing and computing technologies. HP was the sole provider of Itanium servers for the Aviv System, which is Israeli Administration of Border Crossings, Population and Immigration.', 'active', 2, 1, '2025-04-12 17:04:49'),
(29, 'IBM', 'IBM', 'https://www.euractiv.com/wp-content/uploads/sites/2/2023/06/shutterstock_2068727069-scaled.jpg', 'https://www.example.com/info', 1, 'Has a strong R&D presence in Israel that focuses on cloud, AI, and cybersecurity technologies and has acquired several Israeli tech companies.', 'active', 2, 1, '2025-04-12 17:04:49'),
(30, 'Intel', 'Intel', 'https://i.pcmag.com/imagery/articles/05H4n2dV0nMnFiEUnPG4Sgl-6..v1569492159.jpg', 'https://www.example.com/info', 1, 'Has multiple facilities in Israel and has developed several of its chips at its Israeli R&D centers. Intel\'s Fab 28 plant producing 7 nm chips is based in Kiryat Gat which is founded just west of the ruins of the Palestinian village of Iraq al-Manshiyya. On 26 December 2023, Intel announced its largest investment to date—a $25 billion plan to construct a new chip factory in Israel.', 'active', 2, 1, '2025-04-12 17:04:49'),
(31, 'Micron', 'Micron', 'https://dmassets.micron.com/is/image/microntechnology/product-ddr5-macro-generic-hero-02%3A3-2-all-others?ts=1742249160175&dpr=off', 'https://www.example.com/info', 1, 'One of Micron\'s factories is based in Kiryat Gat which is founded just west of the ruins of an old Palestinian village.', 'active', 2, 1, '2025-04-12 17:04:49'),
(32, 'Microsoft', 'Microsoft', 'https://c8.alamy.com/comp/GFE8WF/kiev-ukraine-april-28-2016-collection-of-microsoft-products-logos-GFE8WF.jpg', 'https://www.example.com/info', 1, 'Acquired several Israeli startups and has a large R&D presence in the country that specializes in cybersecurity and AI technologies. Microsoft has a history of deep engagement with the Israeli high-tech industry and close ties to the Israeli military. In 2023, Microsoft is expected to open the first Cloud Datacenter Region in Israel.', 'active', 2, 1, '2025-04-12 17:04:49'),
(33, 'NVIDIA', 'NVIDIA', 'https://yt3.googleusercontent.com/btm1_PK-7VRUr9GY2D0UV_2XfbUZPBjghyptjSO1crsfN86HyTYDWPmUbq7JxC3H0Lxe_s067nA=s900-c-k-c0x00ffffff-no-rj', 'https://www.example.com/info', 1, 'NVIDIA’s operations in Israel mainly involve AI and deep learning technologies. NVIDIA also acquired the Israeli company Mellanox Technologies which is prominent in networking products. Nvidia recently raised $10 million for Israeli charities aiding war-affected civilians, donated computers to those evacuated from the north and south of Israel, and provided hot meals from its Yokneam office.', 'active', 2, 1, '2025-04-12 17:04:49'),
(34, 'Oracle', 'Oracle', 'https://cdn.springpeople.com/media/Oracle-Symbol.png', 'https://www.example.com/info', 1, 'Acquired several Israeli companies and has a presence in Israel mainly through sales and support services.', 'active', 2, 1, '2025-04-12 17:04:49'),
(35, 'Qualcomm', 'Qualcomm', 'https://s7d1.scene7.com/is/image/dmqualcommprod/new-snapdragon-chip-image_jpeg-1?$QC_Responsive$&fmt=png-alpha', 'https://www.example.com/info', 1, 'Qualcomm operates R&D facilities in Israel focusing on wireless communication technologies.', 'active', 2, 1, '2025-04-12 17:04:49'),
(37, 'Nestlé', 'Nestlé', 'https://i.redd.it/1m0xlabyviq81.jpg', 'https://www.example.com/info', 1, 'Nestlé, a Swiss multinational, has a presence in Israel through its investment in Osem, a major Israeli food producer. This investment connects Nestlé to various local industries and markets, broadening its involvement in the region.', 'active', 1, 1, '2025-04-12 17:04:49'),
(38, 'Fiverr', 'Fiverr', 'https://99designs-blog.imgix.net/blog/wp-content/uploads/2018/09/fiverr-2018.png?auto=format&q=60&fit=max&w=930', 'https://www.example.com/info', 1, 'An online marketplace for freelance services, Fiverr was founded in Israel and has since grown globally. It connects businesses with freelancers offering digital services in various categories.', 'active', 2, 1, '2025-04-12 17:04:49'),
(39, 'Disney', 'Disney', 'https://lumiere-a.akamaihd.net/v1/images/au_shop_disney_po_card_m_b2c9fa25.jpeg?region=0,0,1024,640&width=768', 'https://www.example.com/info', 1, 'Following the attacks in Israel, The Walt Disney Company is donating $2 million to organizations that are providing humanitarian relief to Israel.', 'active', 2, 1, '2025-04-12 17:04:49'),
(40, 'Unilever', 'Unilever', 'https://www.happi.com/wp-content/uploads/2024/04/45_main-70.jpg', 'https://www.example.com/info', 1, 'Unilever owns multiple brands including Ben & Jerry\'s. When Ben & Jerry\'s decided to stop selling its products in Israel, Unilever sold off the Israeli distribution rights to Avi Zinger to circumvent their decision and to force Ben & Jerry\'s brand name to continue selling in Israel.', 'active', 1, 1, '2025-04-12 17:04:49'),
(41, 'test', 'test', 'https://ca-times.brightspotcdn.com/dims4/default/b351fe2/2147483647/strip/true/crop/5672x3781+0+0/resize/1200x800!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fbb%2F89%2Fcdd7abb74a39a6a49c458b595ba3%2Fapple-annual-meeting-5', 'test.com', 1, ' test stests', 'pending', 3, 1, '2025-04-13 00:04:53'),
(42, 'test', 'test', 'https://ca-times.brightspotcdn.com/dims4/default/b351fe2/2147483647/strip/true/crop/5672x3781+0+0/resize/1200x800!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fbb%2F89%2Fcdd7abb74a39a6a49c458b595ba3%2Fapple-annual-meeting-5', 'test.com', 1, ' test stests', 'pending', 3, 1, '2025-04-13 00:05:13'),
(43, 'test2', 'test', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKD-_6rk185nm0IP2NJND-AXt6Gu18flA1fQ&s', 'http://example.com/link/to/document', 1, 'test', 'pending', 16, 2, '2025-04-13 00:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `password`, `created_at`, `role`) VALUES
(1, 'admin', '01860222102', '$2y$10$ma0S/85HVTCd/FMQAtzOye8nHwVtFRRGFDEfKpKw.StLzxjTWAHDO', '2025-04-07 19:10:56', 'admin'),
(2, 'mehedi', '01301005347', '$2a$12$FV94M7gWKsvFXBZW..CzS.1JDx/sFPjBlvYX04Aj00fMDmB9BriAa', '2025-04-07 19:10:56', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternative_products`
--
ALTER TABLE `alternative_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_id` (`ref_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternative_products`
--
ALTER TABLE `alternative_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternative_products`
--
ALTER TABLE `alternative_products`
  ADD CONSTRAINT `alternative_products_ibfk_1` FOREIGN KEY (`ref_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
