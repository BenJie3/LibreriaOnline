-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2025 a las 23:10:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libreriaonline`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`admin_id`, `user_id`, `created_at`) VALUES
(3, 9, '2025-05-10 23:07:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `category` enum('fiction','non-fiction','infantil','academicos','otros') NOT NULL,
  `format` enum('physical','digital') NOT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `price`, `stock`, `image_url`, `category`, `format`, `description`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Cien años de soledad', 'Gabriel García Márquez', 19.99, 12, 'https://imagessl7.casadellibro.com/a/l/s5/17/9788466379717.webp', 'fiction', 'physical', 'Una de las obras maestras de la literatura latinoamericana que narra la historia de la familia Buendía a lo largo de siete generaciones en el pueblo ficticio de Macondo.', '<h1>Cien años de soledad</h1><h2>Capítulo 1</h2><p>Muchos años después, frente al pelotón de fusilamiento, el coronel Aureliano Buendía había de recordar aquella tarde remota en que su padre lo llevó a conocer el hielo...</p>', '2025-05-04 22:41:19', '2025-05-11 00:05:52'),
(2, 'El principito', 'Antoine de Saint-Exupéry', 14.95, 17, 'https://imagessl2.casadellibro.com/a/l/s5/92/9788419087492.webp', 'fiction', 'physical', 'Una fábula filosófica sobre la amistad, el amor y el sentido de la vida, narrada a través de los ojos de un pequeño príncipe que viaja por diversos planetas.', '<h1>El principito</h1><h2>Capítulo 1</h2><p>Cuando yo tenía seis años vi en un libro sobre la selva virgen que se titulaba \"Historias vividas\", una magnífica lámina...</p>', '2025-05-04 22:41:19', '2025-05-11 00:01:09'),
(3, '1984', 'George Orwell', 16.50, 4, 'https://images.cdn3.buscalibre.com/fit-in/360x360/f4/ad/f4adafca3285c21412f0aca63bb2e19f.jpg', 'fiction', 'physical', 'Una novela distópica que describe un futuro totalitario donde el gobierno controla cada aspecto de la vida de los ciudadanos, incluyendo sus pensamientos.', '<h1>1984</h1><h2>Capítulo 1</h2><p>Era un día luminoso y frío de abril y los relojes daban las trece. Winston Smith, con la barbilla hundida en el pecho...</p>', '2025-05-04 22:41:19', '2025-05-11 00:01:39'),
(4, 'Historia del Arte', 'E.H. Gombrich', 29.99, 5, 'https://imagessl8.casadellibro.com/a/l/s5/08/9780714873008.webp', 'non-fiction', 'physical', 'Una obra clásica que recorre la historia del arte desde la antigüedad hasta la época moderna, con un enfoque accesible para todo tipo de lectores.', '<h1>Historia del Arte</h1><h2>Introducción</h2><p>No existe, realmente, el Arte. Tan sólo hay artistas...</p>', '2025-05-04 22:41:19', '2025-05-05 20:44:22'),
(5, 'Breve historia del tiempo', 'Stephen Hawking', 18.75, 10, 'https://www.planetadelibros.com.mx/usuaris/libros/fotos/376/m_libros/portada_historia-del-tiempo_stephen-hawking_202302171851.jpg', 'non-fiction', 'physical', 'Un libro de divulgación científica que explica conceptos complejos de física y cosmología de manera accesible para el público general.', '<h1>Breve historia del tiempo</h1><h2>Capítulo 1: Nuestra imagen del universo</h2><p>Un conocido científico (algunos dicen que fue Bertrand Russell)...</p>', '2025-05-04 22:41:19', '2025-05-05 20:45:26'),
(6, 'Don Quijote de la Mancha', 'Miguel de Cervantes', 12.99, 2, 'https://images.cdn2.buscalibre.com/fit-in/360x360/a6/5e/a65e980e9c5ece70d648568274eb9ac5.jpg', 'fiction', 'digital', 'La obra cumbre de la literatura española que narra las aventuras del ingenioso hidalgo Don Quijote y su fiel escudero Sancho Panza.', '<h1>Don Quijote de la Mancha</h1><h2>Capítulo I</h2><p>En un lugar de la Mancha, de cuyo nombre no quiero acordarme...</p>', '2025-05-04 22:41:19', '2025-05-10 23:38:31'),
(7, 'La metamorfosis', 'Franz Kafka', 9.95, 0, 'https://images.cdn2.buscalibre.com/fit-in/360x360/be/e9/bee9773ea6aa90c80b9f0f5e1d99f648.jpg', 'fiction', 'digital', 'La historia de Gregorio Samsa, un comerciante que se despierta un día convertido en un monstruoso insecto, y las consecuencias que esto tiene en su vida y su familia.', '<h1>La metamorfosis</h1><h2>I</h2><p>Cuando Gregorio Samsa se despertó una mañana después de un sueño intranquilo...</p>', '2025-05-04 22:41:19', '2025-05-05 20:50:52'),
(8, 'El universo en una cáscara de nuez', 'Stephen Hawking', 15.50, 0, 'https://bibliometro.cl/wp-content/uploads/bfi_thumb/universo-cascara-nuez-245x350-ojdhpcu9uijduoty76ugmkz4ki0ss5vy8i8amwiopk.jpg', 'non-fiction', 'digital', 'Un fascinante viaje por las fronteras de la física teórica, donde Hawking explora las posibilidades de viajes en el tiempo, agujeros negros y otras dimensiones.', '<h1>El universo en una cáscara de nuez</h1><h2>Capítulo 1: Breve historia de la relatividad</h2><p>Albert Einstein, el descubridor de las teorías especial y general de la relatividad...</p>', '2025-05-04 22:41:19', '2025-05-05 20:52:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `user_id`, `book_id`, `quantity`, `added_at`) VALUES
(1, 2, 3, 1, '2025-04-04 16:00:00'),
(2, 3, 1, 2, '2025-04-04 17:30:00'),
(3, 4, 8, 1, '2025-04-04 18:15:00'),
(4, 5, 2, 1, '2025-04-04 19:00:00'),
(5, 1, 5, 1, '2025-04-04 20:20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` enum('consulta','pedido','devolucion','sugerencia') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Juan Pérez', 'juan.perez@email.com', 'consulta', '¿Tienen planes de incluir más libros digitales en el catálogo?', '2025-04-01 14:30:00'),
(2, 'María Gómez', 'maria.gomez@email.com', 'pedido', 'Mi pedido #2 aún no ha llegado, ¿pueden confirmar el estado?', '2025-04-02 15:45:00'),
(3, 'Carlos López', 'carlos.lopez@email.com', 'sugerencia', 'Sugeriría agregar una sección de libros infantiles más amplia.', '2025-04-03 16:15:00'),
(4, 'Ana Rodríguez', 'ana.rodriguez@email.com', 'devolucion', 'Quiero devolver un libro físico que recibí dañado.', '2025-04-03 17:00:00'),
(5, 'Luis Martínez', 'luis.martinez@email.com', 'consulta', '¿Cómo accedo al lector de libros digitales después de la compra?', '2025-04-04 18:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `status`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 1, 34.94, 'delivered', 'Calle de los Libros 456, Ciudad Literaria', '2025-04-01 16:30:00', '2025-05-04 22:44:30'),
(2, 2, 29.99, 'shipped', 'Avenida Lectura 789, Ciudad Literaria', '2025-04-02 20:15:00', '2025-05-04 22:44:30'),
(3, 3, 47.24, 'processing', 'Plaza del Lector 101, Ciudad Literaria', '2025-04-03 15:00:00', '2025-05-04 22:44:30'),
(4, 4, 12.99, 'pending', 'Calle Novela 202, Ciudad Literaria', '2025-04-04 22:45:00', '2025-05-04 22:44:30'),
(5, 1, 24.90, 'cancelled', 'Calle de los Libros 456, Ciudad Literaria', '2025-03-15 18:00:00', '2025-05-04 22:44:30'),
(11, 6, 19.99, 'pending', 'CALLE 10 11', '2025-05-11 00:03:37', '2025-05-11 00:03:37'),
(12, 6, 19.99, 'pending', 'CALLE 10 11', '2025-05-11 00:05:40', '2025-05-11 00:05:40'),
(13, 6, 19.99, 'pending', 'CALLE 10 11', '2025-05-11 00:05:52', '2025-05-11 00:05:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `book_id`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 1, 19.99),
(2, 1, 2, 1, 14.95),
(3, 2, 4, 1, 29.99),
(4, 3, 5, 1, 18.75),
(5, 3, 2, 2, 14.95),
(6, 4, 6, 1, 12.99),
(7, 5, 7, 1, 9.95),
(8, 5, 8, 1, 15.50),
(14, 11, 1, 1, 19.99),
(15, 12, 1, 1, 19.99),
(16, 13, 1, 1, 19.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'juanperez', 'juan.perez@email.com', '$2y$10$XJ8k9z3Q8Z5Y7W4V2N1M9u4Qz7t9k8L3m2n5p6q7r8s9t0u1v2w3x', 'Juan', 'Pérez', 'Calle de los Libros 456, Ciudad Literaria', '+34 600 123 456', '2025-05-04 22:44:30', '2025-05-04 22:44:30'),
(2, 'mariagomez', 'maria.gomez@email.com', '$2y$10$Y9l0m1n2p3q4r5s6t7u8v9w0x1y2z3A4B5C6D7E8F9G0H1I2J3K4L', 'María', 'Gómez', 'Avenida Lectura 789, Ciudad Literaria', '+34 600 789 123', '2025-05-04 22:44:30', '2025-05-04 22:44:30'),
(3, 'carloslopez', 'carlos.lopez@email.com', '$2y$10$Z0a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z', 'Carlos', 'López', 'Plaza del Lector 101, Ciudad Literaria', '+34 600 456 789', '2025-05-04 22:44:30', '2025-05-04 22:44:30'),
(4, 'anarodriguez', 'ana.rodriguez@email.com', '$2y$10$A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6A', 'Ana', 'Rodríguez', 'Calle Novela 202, Ciudad Literaria', '+34 600 321 654', '2025-05-04 22:44:30', '2025-05-04 22:44:30'),
(5, 'luismartinez', 'luis.martinez@email.com', '$2y$10$B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6A7B', 'Luis', 'Martínez', 'Paseo de los Poetas 303, Ciudad Literaria', '+34 600 987 321', '2025-05-04 22:44:30', '2025-05-04 22:44:30'),
(6, 'Lennin', 'lenninbenjaminmc@gmail.com', '$2y$10$b9RYLWuJVcE9CqYJ8tYRGOAHkOay4W67jhHp/FKkFloQBE/d0169S', 'Lennin Benjamin', 'Mendoza Carrillo', 'CALLE 10 11', '7445872293', '2025-05-05 16:43:11', '2025-05-05 16:43:11'),
(9, 'admin', 'admin@gmail.com', '$2y$10$m8qWxpwhB7QkGPgPcDtJOOOYdvBrh6dVmD.fPsbag35HZrhQ3NkyK', 'admin', '123', 'NULL', 'NULL', '2025-05-10 23:06:36', '2025-05-10 23:06:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_format` (`format`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD UNIQUE KEY `uk_user_book` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indices de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `idx_email` (`email`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
