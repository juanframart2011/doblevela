-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2014 a las 17:16:40
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `_f1901-01`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalog_category_product`
--

CREATE TABLE IF NOT EXISTS `catalog_category_product` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position',
  PRIMARY KEY (`category_id`,`product_id`),
  KEY `IDX_CATALOG_CATEGORY_PRODUCT_PRODUCT_ID` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Product To Category Linkage Table';

--
-- Volcado de datos para la tabla `catalog_category_product`
--

INSERT INTO `catalog_category_product` (`category_id`, `product_id`, `position`) VALUES
(2, 49, 1),
(2, 52, 1),
(2, 53, 1),
(2, 54, 1),
(2, 55, 1),
(2, 56, 1),
(3, 49, 1),
(3, 51, 1),
(3, 52, 1),
(3, 53, 1),
(3, 54, 1),
(3, 55, 1),
(3, 56, 1),
(15, 49, 1),
(15, 51, 1),
(15, 52, 1),
(17, 49, 1),
(18, 50, 1),
(19, 51, 1),
(23, 54, 1),
(28, 55, 1),
(28, 56, 1),
(47, 53, 1),
(95, 52, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalog_product_entity`
--

CREATE TABLE IF NOT EXISTS `catalog_product_entity` (
  `entity_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Entity ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_set_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Set ID',
  `type_id` varchar(32) NOT NULL DEFAULT 'simple' COMMENT 'Type ID',
  `sku` varchar(64) DEFAULT NULL COMMENT 'SKU',
  `has_options` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Has Options',
  `required_options` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Required Options',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Creation Time',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Update Time',
  PRIMARY KEY (`entity_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_ENTITY_TYPE_ID` (`entity_type_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_ATTRIBUTE_SET_ID` (`attribute_set_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_SKU` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Product Table' AUTO_INCREMENT=57 ;

--
-- Volcado de datos para la tabla `catalog_product_entity`
--

INSERT INTO `catalog_product_entity` (`entity_id`, `entity_type_id`, `attribute_set_id`, `type_id`, `sku`, `has_options`, `required_options`, `created_at`, `updated_at`) VALUES
(49, 4, 9, 'simple', 'woody', 0, 0, '2014-08-12 09:21:05', '2014-09-05 07:24:08'),
(50, 4, 9, 'simple', 'boligrafo futbol', 0, 0, '2014-08-12 09:23:54', '2014-08-12 09:29:43'),
(51, 4, 9, 'simple', 'boligrafo evas set', 0, 0, '2014-08-12 09:26:10', '2014-08-12 09:30:25'),
(52, 4, 9, 'simple', 'Boligrafo caroline', 0, 0, '2014-08-12 09:28:09', '2014-08-12 09:31:32'),
(53, 4, 4, 'simple', 'reloj cronix', 0, 0, '2014-08-12 10:23:51', '2014-08-12 10:25:24'),
(54, 4, 12, 'simple', 'Portagafete Frank', 0, 0, '2014-08-12 10:28:58', '2014-08-12 10:28:58'),
(55, 4, 13, 'simple', 'Audifonos roule', 0, 0, '2014-08-12 10:35:44', '2014-08-12 10:35:44'),
(56, 4, 13, 'simple', 'HOLOGRAFIC', 0, 0, '2014-08-14 08:05:20', '2014-09-05 07:21:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalog_product_entity_decimal`
--

CREATE TABLE IF NOT EXISTS `catalog_product_entity_decimal` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute ID',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity ID',
  `value` decimal(12,4) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `UNQ_CAT_PRD_ENTT_DEC_ENTT_ID_ATTR_ID_STORE_ID` (`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_DECIMAL_STORE_ID` (`store_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_DECIMAL_ENTITY_ID` (`entity_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_DECIMAL_ATTRIBUTE_ID` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Product Decimal Attribute Backend Table' AUTO_INCREMENT=673 ;

--
-- Volcado de datos para la tabla `catalog_product_entity_decimal`
--

INSERT INTO `catalog_product_entity_decimal` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(620, 4, 80, 0, 49, '10.0000'),
(621, 4, 75, 0, 49, '10.0000'),
(622, 4, 76, 0, 49, NULL),
(623, 4, 120, 0, 49, NULL),
(624, 4, 80, 0, 50, '5.0000'),
(625, 4, 75, 0, 50, '18.0000'),
(626, 4, 76, 0, 50, NULL),
(627, 4, 120, 0, 50, NULL),
(631, 4, 80, 0, 51, '30.0000'),
(632, 4, 75, 0, 51, '300.0000'),
(633, 4, 76, 0, 51, NULL),
(634, 4, 120, 0, 51, NULL),
(635, 4, 80, 0, 52, '78.0000'),
(636, 4, 75, 0, 52, '500.0000'),
(637, 4, 76, 0, 52, NULL),
(638, 4, 120, 0, 52, NULL),
(654, 4, 80, 0, 53, '900.0000'),
(655, 4, 75, 0, 53, '1200.0000'),
(656, 4, 76, 0, 53, NULL),
(657, 4, 120, 0, 53, NULL),
(661, 4, 80, 0, 54, '1000.0000'),
(662, 4, 75, 0, 54, '340.0000'),
(663, 4, 76, 0, 54, NULL),
(664, 4, 120, 0, 54, NULL),
(665, 4, 80, 0, 55, '390.0000'),
(666, 4, 75, 0, 55, '200.0000'),
(667, 4, 76, 0, 55, '140.0000'),
(668, 4, 120, 0, 55, NULL),
(669, 4, 80, 0, 56, '13.0000'),
(670, 4, 75, 0, 56, '36.0000'),
(671, 4, 76, 0, 56, '20.0000'),
(672, 4, 120, 0, 56, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalog_product_entity_text`
--

CREATE TABLE IF NOT EXISTS `catalog_product_entity_text` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value ID',
  `entity_type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute ID',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity ID',
  `value` text COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `UNQ_CATALOG_PRODUCT_ENTITY_TEXT_ENTITY_ID_ATTRIBUTE_ID_STORE_ID` (`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_TEXT_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_TEXT_STORE_ID` (`store_id`),
  KEY `IDX_CATALOG_PRODUCT_ENTITY_TEXT_ENTITY_ID` (`entity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Product Text Attribute Backend Table' AUTO_INCREMENT=552 ;

--
-- Volcado de datos para la tabla `catalog_product_entity_text`
--

INSERT INTO `catalog_product_entity_text` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(506, 4, 72, 0, 49, 'Bolígrafo de bambú en textura lisa, clip y punta de plástico. Mecanismo de click.'),
(507, 4, 73, 0, 49, 'Bolígrafo de bambú en textura lisa, clip y punta de plástico. Mecanismo de click.'),
(508, 4, 83, 0, 49, NULL),
(509, 4, 106, 0, 49, NULL),
(510, 4, 72, 0, 50, 'Bolígrafo de plástico con balón giratorio, sistema retráctil.'),
(511, 4, 73, 0, 50, 'Bolígrafo de plástico con balón giratorio, sistema retráctil.'),
(512, 4, 83, 0, 50, NULL),
(513, 4, 106, 0, 50, NULL),
(516, 4, 72, 0, 51, 'Juego de bolígrafo metálico y lámpara de aluminio, con luz LED, correa, botón de encendido. Baterías incluidas (4 pilas). Incluye caja color negro. Medidas de la lámpara 7.1 x 1.8 cm. Medidas de la caja 7.8 x 16.3 x 2.3 cm'),
(517, 4, 73, 0, 51, 'Juego de bolígrafo metálico y lámpara de aluminio, con luz LED, correa, botón de encendido.'),
(518, 4, 83, 0, 51, NULL),
(519, 4, 106, 0, 51, NULL),
(520, 4, 72, 0, 52, 'Bolígrafo con USB y apuntador láser, con capacidad de 4 gb, botón de encendido para apuntador. Incluye estuche de aluminio plateado. Baterías incluidas. Medidas del estuche: 17.8 x 6 cm'),
(521, 4, 73, 0, 52, 'Bolígrafo con USB y apuntador láser, con capacidad de 4 gb, botón de encendido para apuntador.'),
(522, 4, 83, 0, 52, NULL),
(523, 4, 106, 0, 52, NULL),
(534, 4, 72, 0, 53, 'Medición de temperatura\r\nMedición de humedad\r\nUtiliza 1 batería AA (no incluida)'),
(535, 4, 73, 0, 53, 'Medición de temperatura'),
(536, 4, 83, 0, 53, NULL),
(537, 4, 106, 0, 53, NULL),
(540, 4, 72, 0, 54, 'Portagafete de plástico, de cuerpo hueco, forma de bata de doctor, con hilo elastico, clip posterior para sujetar a la ropa y broche para gafete.'),
(541, 4, 73, 0, 54, 'Portagafete de plástico.'),
(542, 4, 83, 0, 54, NULL),
(543, 4, 106, 0, 54, NULL),
(544, 4, 72, 0, 55, 'Audífonos personales con estuche cuadrado y esquinas redondeadas. Con 2 pares de repuestos de protectores de goma, soporte para enrollar cable, tapa plástica transparente. Extensión total: 116 cm.'),
(545, 4, 73, 0, 55, 'Audífonos personales con estuche cuadrado y esquinas redondeadas.'),
(546, 4, 83, 0, 55, NULL),
(547, 4, 106, 0, 55, NULL),
(548, 4, 72, 0, 56, 'Brazalete plastificado brillante con textura holográfica de círculos, broche de seguridad a presión inviolable. Área máxima de impresión: 7 x 1 cm.'),
(549, 4, 73, 0, 56, 'Brazalete plastificado brillante con textura holográfica de círculos, broche de seguridad a presión inviolable.'),
(550, 4, 83, 0, 56, NULL),
(551, 4, 106, 0, 56, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `catalog_category_product`
--
ALTER TABLE `catalog_category_product`
  ADD CONSTRAINT `FK_CAT_CTGR_PRD_CTGR_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`category_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_PRD_PRD_ID_CAT_PRD_ENTT_ENTT_ID` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `catalog_product_entity`
--
ALTER TABLE `catalog_product_entity`
  ADD CONSTRAINT `FK_CAT_PRD_ENTT_ATTR_SET_ID_EAV_ATTR_SET_ATTR_SET_ID` FOREIGN KEY (`attribute_set_id`) REFERENCES `eav_attribute_set` (`attribute_set_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_PRD_ENTT_ENTT_TYPE_ID_EAV_ENTT_TYPE_ENTT_TYPE_ID` FOREIGN KEY (`entity_type_id`) REFERENCES `eav_entity_type` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `catalog_product_entity_decimal`
--
ALTER TABLE `catalog_product_entity_decimal`
  ADD CONSTRAINT `FK_CATALOG_PRODUCT_ENTITY_DECIMAL_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_PRD_ENTT_DEC_ATTR_ID_EAV_ATTR_ATTR_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_PRD_ENTT_DEC_ENTT_ID_CAT_PRD_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `catalog_product_entity_text`
--
ALTER TABLE `catalog_product_entity_text`
  ADD CONSTRAINT `FK_CATALOG_PRODUCT_ENTITY_TEXT_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_PRD_ENTT_TEXT_ATTR_ID_EAV_ATTR_ATTR_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_PRD_ENTT_TEXT_ENTT_ID_CAT_PRD_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
