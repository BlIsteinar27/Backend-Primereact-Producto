-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-01-2025 a las 13:29:24
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbpedidos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productss`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `miniatura` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `productss`
--

INSERT INTO `productss` (`id`, `nombre`, `categoria`, `precio`, `descuento`, `rating`, `stock`, `marca`, `miniatura`) VALUES
(1, 'Essence Mascara Lash Princess', 'beauty', 9.99, 7.17, 4.94, 5, 'Essence', 'https://cdn.dummyjson.com/products/images/beauty/Essence%20Mascara%20Lash%20Princess/thumbnail.png'),
(2, 'Eyeshadow Palette with Mirror', 'beauty', 19.99, 5.50, 3.28, 44, 'Glamour Beauty', 'https://cdn.dummyjson.com/products/images/beauty/Eyeshadow%20Palette%20with%20Mirror/thumbnail.png'),
(3, 'Powder Canister', 'beauty', 14.99, 18.14, 3.82, 59, 'Velvet Touch', 'https://cdn.dummyjson.com/products/images/beauty/Powder%20Canister/thumbnail.png'),
(4, 'Red Lipstick', 'beauty', 12.99, 19.03, 2.51, 68, 'Chic Cosmetics', 'https://cdn.dummyjson.com/products/images/beauty/Red%20Lipstick/thumbnail.png'),
(5, 'Red Nail Polish', 'beauty', 8.99, 2.46, 3.91, 71, 'Nail Couture', 'https://cdn.dummyjson.com/products/images/beauty/Red%20Nail%20Polish/thumbnail.png'),
(6, 'Calvin Klein CK One', 'fragrances', 49.99, 0.32, 4.85, 17, 'Calvin Klein', 'https://cdn.dummyjson.com/products/images/fragrances/Calvin%20Klein%20CK%20One/thumbnail.png'),
(7, 'Chanel Coco Noir Eau De', 'fragrances', 129.99, 18.64, 2.76, 41, 'Chanel', 'https://cdn.dummyjson.com/products/images/fragrances/Chanel%20Coco%20Noir%20Eau%20De/thumbnail.png'),
(8, 'Dior J\'adore', 'fragrances', 89.99, 17.44, 3.31, 91, 'Dior', 'https://cdn.dummyjson.com/products/images/fragrances/Dior%20J\'adore/thumbnail.png'),
(9, 'Maybelline Fit Me Foundation', 'makeup', 12.99, 10.00, 4.70, 50, 'Maybelline', 'https://example.com/maybelline_fit_me_thumbnail.png'),
(10, 'L\'Oreal Paris Infallible Lipstick', 'makeup', 10.99, 5.00, 4.50, 30, 'L\'Oreal Paris', 'https://example.com/loreal_infallible_thumbnail.png'),
(11, 'NYX Professional Makeup Setting Spray', 'makeup', 8.99, 15.00, 4.80, 60, 'NYX', 'https://example.com/nyx_setting_spray_thumbnail.png'),
(12, 'Urban Decay Naked Palette', 'makeup', 54.00, 20.00, 4.90, 25, 'Urban Decay', 'https://example.com/urban_decay_naked_thumbnail.png'),
(13, 'Clinique Moisture Surge Gel Cream', 'skincare', 39.50, 10.00, 4.75, 45, 'Clinique', 'https://example.com/clinique_moisture_thumbnail.png'),
(14, 'Neutrogena Hydro Boost Water Gel', 'skincare', 29.99, 15.00, 4.60, 80, 'Neutrogena', 'https://example.com/neutrogena_hydro_thumbnail.png'),
(15, 'CeraVe Hydrating Cleanser', 'skincare', 14.99, 5.00, 4.70, 90, 'CeraVe', 'https://example.com/cerave_cleanser_thumbnail.png'),
(16, 'The Ordinary Niacinamide Serum', 'skincare', 6.50, 0.00, 4.85, 100, 'The Ordinary', 'https://example.com/the_ordinary_thumbnail.png'),
(17, 'Garnier Micellar Cleansing Water', 'skincare', 9.99, 10.00, 4.40, 75, 'Garnier', 'https://example.com/garnier_micellar_thumbnail.png'),
(18, 'Burt\'s Bees Lip Balm', 'personal care', 3.99, 0.00, 4.60, 150, 'Burt\'s Bees', 'https://example.com/burts_bees_thumbnail.png'),
(19, 'Dove Body Wash', 'personal care', 8.49, 5.00, 4.50, 120, 'Dove', 'https://example.com/dove_bodywash_thumbnail.png'),
(21, 'Kit de Oficina', 'Oficina', 5.99, 3.99, 3.40, 25, 'mongol', 'adhnlaindna');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productss`
--
ALTER TABLE `productss`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productss`
--
ALTER TABLE `productss`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
