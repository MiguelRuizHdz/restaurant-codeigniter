-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-11-2021 a las 19:10:51
-- Versión del servidor: 10.5.12-MariaDB
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurantdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`, `active`) VALUES
(1, 'Comida', 1),
(2, 'Bebidas', 1),
(3, 'Postres', 1),
(5, 'Plato fuerte', 1),
(6, 'Ensaladas', 1),
(7, 'Malteadas', 1),
(8, 'Categoría de prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `service_charge_value` varchar(255) NOT NULL,
  `vat_charge_value` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`id`, `company_name`, `service_charge_value`, `vat_charge_value`, `address`, `phone`, `message`, `currency`) VALUES
(1, 'Moctezuma', '0', '16', 'San Nicolas de los Garza', '8125772940', 'Restaurante mexicano de comidas', 'MXN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `permission`) VALUES
(1, 'Super Administrador', 'a:32:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createStore\";i:9;s:11:\"updateStore\";i:10;s:9:\"viewStore\";i:11;s:11:\"deleteStore\";i:12;s:11:\"createTable\";i:13;s:11:\"updateTable\";i:14;s:9:\"viewTable\";i:15;s:11:\"deleteTable\";i:16;s:14:\"createCategory\";i:17;s:14:\"updateCategory\";i:18;s:12:\"viewCategory\";i:19;s:14:\"deleteCategory\";i:20;s:13:\"createProduct\";i:21;s:13:\"updateProduct\";i:22;s:11:\"viewProduct\";i:23;s:13:\"deleteProduct\";i:24;s:11:\"createOrder\";i:25;s:11:\"updateOrder\";i:26;s:9:\"viewOrder\";i:27;s:11:\"deleteOrder\";i:28;s:10:\"viewReport\";i:29;s:13:\"updateCompany\";i:30;s:11:\"viewProfile\";i:31;s:13:\"updateSetting\";}'),
(2, 'Administrador', 'a:32:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createStore\";i:9;s:11:\"updateStore\";i:10;s:9:\"viewStore\";i:11;s:11:\"deleteStore\";i:12;s:11:\"createTable\";i:13;s:11:\"updateTable\";i:14;s:9:\"viewTable\";i:15;s:11:\"deleteTable\";i:16;s:14:\"createCategory\";i:17;s:14:\"updateCategory\";i:18;s:12:\"viewCategory\";i:19;s:14:\"deleteCategory\";i:20;s:13:\"createProduct\";i:21;s:13:\"updateProduct\";i:22;s:11:\"viewProduct\";i:23;s:13:\"deleteProduct\";i:24;s:11:\"createOrder\";i:25;s:11:\"updateOrder\";i:26;s:9:\"viewOrder\";i:27;s:11:\"deleteOrder\";i:28;s:10:\"viewReport\";i:29;s:13:\"updateCompany\";i:30;s:11:\"viewProfile\";i:31;s:13:\"updateSetting\";}'),
(3, 'Chef', 'a:20:{i:0;s:9:\"viewGroup\";i:1;s:9:\"viewStore\";i:2;s:9:\"viewTable\";i:3;s:11:\"deleteTable\";i:4;s:14:\"createCategory\";i:5;s:14:\"updateCategory\";i:6;s:12:\"viewCategory\";i:7;s:14:\"deleteCategory\";i:8;s:13:\"createProduct\";i:9;s:13:\"updateProduct\";i:10;s:11:\"viewProduct\";i:11;s:13:\"deleteProduct\";i:12;s:11:\"createOrder\";i:13;s:11:\"updateOrder\";i:14;s:9:\"viewOrder\";i:15;s:11:\"deleteOrder\";i:16;s:10:\"viewReport\";i:17;s:13:\"updateCompany\";i:18;s:11:\"viewProfile\";i:19;s:13:\"updateSetting\";}'),
(4, 'Almacenista', 'a:6:{i:0;s:9:\"viewStore\";i:1;s:12:\"viewCategory\";i:2;s:13:\"createProduct\";i:3;s:13:\"updateProduct\";i:4;s:11:\"viewProduct\";i:5;s:13:\"deleteProduct\";}'),
(5, 'Mesero', 'a:7:{i:0;s:11:\"updateTable\";i:1;s:9:\"viewTable\";i:2;s:11:\"viewProduct\";i:3;s:11:\"createOrder\";i:4;s:11:\"updateOrder\";i:5;s:9:\"viewOrder\";i:6;s:11:\"viewProfile\";}'),
(6, 'Cocinero', 'a:32:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createStore\";i:9;s:11:\"updateStore\";i:10;s:9:\"viewStore\";i:11;s:11:\"deleteStore\";i:12;s:11:\"createTable\";i:13;s:11:\"updateTable\";i:14;s:9:\"viewTable\";i:15;s:11:\"deleteTable\";i:16;s:14:\"createcategoria\";i:17;s:14:\"updatecategoria\";i:18;s:12:\"viewcategoria\";i:19;s:14:\"deletecategoria\";i:20;s:13:\"createProduct\";i:21;s:13:\"updateProduct\";i:22;s:11:\"viewProduct\";i:23;s:13:\"deleteProduct\";i:24;s:11:\"createOrder\";i:25;s:11:\"updateOrder\";i:26;s:9:\"viewOrder\";i:27;s:11:\"deleteOrder\";i:28;s:10:\"viewReport\";i:29;s:13:\"updateCompany\";i:30;s:11:\"viewProfile\";i:31;s:13:\"updateSetting\";}a:32:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createStore\";i:9;s:11:\"updateStore\";i:10;s:9:\"viewStore\";i:11;s:11:\"deleteStore\";i:12;s:11:\"createTable\";i:13;s:11:\"updateTable\";i:14;s:9:\"viewTable\";i:15;s:11:\"deleteTable\";i:16;s:14:\"createCategory\";i:17;s:14:\"updateCategory\";i:18;s:12:\"viewCategory\";i:19;s:14:\"deleteCategory\";i:20;s:13:\"createProduct\";i:21;s:13:\"updateProduct\";i:22;s:11:\"viewProduct\";i:23;s:13:\"deleteProduct\";i:24;s:11:\"createOrder\";i:25;s:11:\"updateOrder\";i:26;s:9:\"viewOrder\";i:27;s:11:\"deleteOrder\";i:28;s:10:\"viewReport\";i:29;s:13:\"updateCompany\";i:30;s:11:\"viewProfile\";i:31;s:13:\"updateSetting\";}'),
(7, 'Cajero', 'a:8:{i:0;s:8:\"viewUser\";i:1;s:11:\"createOrder\";i:2;s:11:\"updateOrder\";i:3;s:9:\"viewOrder\";i:4;s:11:\"deleteOrder\";i:5;s:10:\"viewReport\";i:6;s:11:\"viewProfile\";i:7;s:13:\"updateSetting\";}'),
(8, 'Repartidor', 'a:7:{i:0;s:9:\"viewTable\";i:1;s:12:\"viewCategory\";i:2;s:11:\"viewProduct\";i:3;s:11:\"createOrder\";i:4;s:11:\"updateOrder\";i:5;s:9:\"viewOrder\";i:6;s:11:\"viewProfile\";}'),
(12, 'Prueba', 'a:4:{i:0;s:9:\"viewTable\";i:1;s:12:\"viewCategory\";i:2;s:11:\"viewProduct\";i:3;s:9:\"viewOrder\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `gross_amount` varchar(255) NOT NULL,
  `service_charge_rate` varchar(255) NOT NULL,
  `service_charge_amount` varchar(255) NOT NULL,
  `vat_charge_rate` varchar(255) NOT NULL,
  `vat_charge_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `net_amount` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `paid_status` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `bill_no`, `date_time`, `gross_amount`, `service_charge_rate`, `service_charge_amount`, `vat_charge_rate`, `vat_charge_amount`, `discount`, `net_amount`, `user_id`, `table_id`, `paid_status`, `store_id`) VALUES
(1, 'RSTRNT-587C', '1637082130', '140.00', '3', '4.20', '16', '22.40', '20', '146.60', 1, 1, 1, 1),
(3, 'RSTRNT-1791', '1637220468', '120.00', '3', '3.60', '16', '19.20', '', '142.80', 1, 2, 1, 1),
(4, 'RSTRNT-7B46', '1637524580', '30.00', '3', '0.90', '16', '4.80', '', '35.70', 1, 2, 1, 1),
(5, 'RSTRNT-1905', '1637561018', '350.00', '0', '0', '16', '56.00', '', '406.00', 1, 4, 1, 1),
(6, 'RSTRNT-09A3', '1637561088', '358.00', '0', '0', '16', '57.28', '', '415.28', 1, 2, 1, 1),
(7, 'RSTRNT-1C0E', '1637561102', '120.00', '0', '0', '16', '19.20', '', '139.20', 1, 8, 1, 1),
(8, 'RSTRNT-A670', '1637561197', '488.00', '0', '0', '16', '78.08', '', '566.08', 1, 2, 1, 1),
(10, 'RSTRNT-EA16', '1637562516', '702.00', '0', '0', '16', '112.32', '', '814.32', 1, 1, 1, 1),
(11, 'RSTRNT-7866', '1637603118', '233.00', '3', '6.99', '16', '37.28', '', '277.27', 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `rate`, `amount`) VALUES
(2, 1, 4, '2', '70', '140.00'),
(6, 3, 2, '3', '40', '120.00'),
(8, 4, 3, '1', '30', '30.00'),
(12, 7, 3, '4', '30', '120.00'),
(13, 6, 6, '2', '179', '358.00'),
(14, 5, 4, '5', '70', '350.00'),
(20, 8, 6, '2', '179', '358.00'),
(21, 8, 4, '1', '70', '70.00'),
(22, 8, 3, '2', '30', '60.00'),
(31, 10, 11, '2', '179', '358.00'),
(32, 10, 9, '2', '59', '118.00'),
(33, 10, 8, '2', '19', '38.00'),
(34, 10, 3, '1', '30', '30.00'),
(35, 10, 7, '2', '79', '158.00'),
(40, 11, 13, '2', '27', '54.00'),
(41, 11, 11, '1', '179', '179.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` text NOT NULL,
  `store_id` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `category_id`, `store_id`, `name`, `price`, `description`, `image`, `active`) VALUES
(2, '[\"2\"]', '[\"1\"]', 'Gatorade', '40', 'Gatorade ', 'assets/images/product_image/619a72cab2eb0.png', 1),
(3, '[\"3\"]', '[\"1\"]', 'Pay de limón', '30', 'prueba', 'assets/images/product_image/619a74c258087.png', 1),
(4, '[\"1\"]', '[\"1\"]', 'Enchiladas', '70', '5 enchiladas', 'assets/images/product_image/619a7164ce1dd.jpg', 1),
(6, '[\"1\"]', '[\"1\"]', 'Boneless', '179', '1 pechuga de pollo cortada en cubos\r\n2 ramas de apio en bastones\r\n½ taza de salsa picante tipo búfalo\r\n½ taza de salsa de habanero\r\n½ taza de pulpa de mango\r\n2 cucharaditas de peperoncino\r\n¼ de taza de jugo de limón\r\n2 tazas de harina tempura\r\n1 taza de agua fría\r\n1 taza de fécula de maíz\r\nAceite (suficiente para freír)', 'assets/images/product_image/619bb94cebe28.jpg', 1),
(7, '[\"7\"]', '[\"1\"]', 'Malteada de chocolate', '79', '550 grs Helado de vainilla\r\n4 cdas Jarabe de chocolate\r\n6 pzas Galleta oreo\r\n600 ml Leche\r\n130 grs Hielo en cubos', 'assets/images/product_image/619bb961d0b2b.png', 1),
(8, '[\"2\"]', '[\"1\"]', 'Coca-Cola', '19', 'Coca-Cola en lata', 'assets/images/product_image/619bb92947365.jpg', 1),
(9, '[\"6\"]', '[\"1\"]', 'Ensalada', '59', '3 Tazas Lechuga Crespa\r\n1 Taza Tomate Cherry\r\n1/2 Taza Albahaca Fresca\r\n1/4 Taza Cebolla Larga\r\n1/2 Taza Choclo', 'assets/images/product_image/619bb93d9d706.jpg', 1),
(10, '[\"5\"]', '[\"1\"]', 'Medallones de res', '249', '200g Setas\r\n15g Albahaca\r\n50ml Salsa de soya\r\n50ml Aceite de ajonjolí\r\n30ml Aceite de oliva', 'assets/images/product_image/619bb9fac6c77.jpg', 1),
(11, '[\"5\"]', '[\"1\"]', 'Carne', '179', '- Una berenjena en rodajas.\r\n\r\n- Un Calabacín en rodajas.\r\n\r\n- Un zucchini en rodajas.\r\n\r\n- Una zanahoria en rodajas.                                                      ', 'assets/images/product_image/619bb9efa4c8b.jpg', 1),
(12, '[\"1\"]', '[\"1\"]', 'Tamal Verde', '27', 'Tamal en hoja de maíz con salsa verde y pollo.                                                      ', 'assets/images/product_image/619bb8c44668a.jpg', 1),
(13, '[\"1\"]', '[\"1\"]', 'TamaldeChicharron', '27', 'Tamal de chicharrón en hoja de maíz', 'assets/images/product_image/619bd64026af0.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `stores`
--

INSERT INTO `stores` (`id`, `name`, `active`) VALUES
(1, 'Moctezuma', 1),
(4, 'Moctezuma Sendero', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `capacity` varchar(255) NOT NULL,
  `available` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tables`
--

INSERT INTO `tables` (`id`, `table_name`, `capacity`, `available`, `active`, `store_id`) VALUES
(1, 'M1', '4', 1, 1, 1),
(2, 'M2', '6', 1, 1, 1),
(3, 'M3', '4', 1, 1, 1),
(4, 'M4', '4', 1, 1, 1),
(5, 'M5', '6', 1, 1, 1),
(6, 'M6', '4', 1, 1, 1),
(7, 'M7', '4', 1, 1, 1),
(8, 'M8', '4', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `gender`, `store_id`) VALUES
(1, 'admin', '$2y$10$wdPKnje6ByTE6pi.j9HrROA.j4u4EF7m.bhgLhVLpUd9Oz9vrsCAi', 'admin@gmail.com', 'Miguel', 'Ruiz', '8181888600', 1, 1),
(2, 'Karla', '$2y$10$J4/hvDs/.rW8nrd8N9kfuuh0Msh4djj6LyhQvG3l8/9clc7ge7At.', 'Karla@gmail.com', 'Karla', 'Hernandez', '8111626620', 1, 1),
(3, 'yordan', '$2y$10$J4/hvDs/.rW8nrd8N9kfuuh0Msh4djj6LyhQvG3l8/9clc7ge7At.', 'yordan@gmail.com', 'Yordan', 'Renteria', '8124465063', 2, 1),
(4, 'chef lopez', '$2y$10$iChrqXTZ/IEoUdJMQOIm.ePYCKvdaX.sPnt7F5QDaFkL.0tUVdZbi', 'chef@test.com', 'Chef', 'Lopez', '8181817273', 1, 1),
(5, 'mesero', '$2y$10$rEb5ZIBRMYQtwQTkpbQKUu4C8vFWzVUw3Jqb2oMctB3oOBYj82xAq', 'waiter@gmail.com', 'Miguel Mesero', 'Ruiz', '8181817233', 1, 1),
(10, 'Prueba', '$2y$10$vOdz1UgpngegKT19xntI.uhBnt.Gm3mOXNM9rzWURf1lOf3H3p0hy', 'prueba1@gmail.com', 'Prueba', 'Prueba', '8181818182', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 3),
(5, 5, 5),
(6, 6, 2),
(7, 7, 2),
(8, 8, 3),
(9, 9, 11),
(10, 10, 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
