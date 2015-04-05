#######se crea el item y se optiene el id

//tabla

cataloginventory_stock_item

//insert

//En este se inserta
el id del producto stock_id que en todos es 1, qty que es la cantidad del producto
min_qty es el minimo que debe de haber del producto,
use_config_min_qty por default es 1, is_qty_decimal por default es 0, backorders por default es 0,

hasta is_in_stock los anteriores sin insertar información tiene un predeterminado
is_in_stock 0 si no esta en existencia y 1 si esta en existencia
low_stock_date esta es la modificacion de la fecha de stock

hasta stock_status_changed_auto los anteriores por default, este campo( stock_status_changed_auto ) se modifica cuando se acaba el stock,
entre 0 y 1


INSERT INTO `cataloginventory_stock_item` (`item_id`, `product_id`, `stock_id`, `qty`, `min_qty`, `use_config_min_qty`, 
`is_qty_decimal`, `backorders`, `use_config_backorders`, `min_sale_qty`, `use_config_min_sale_qty`, `max_sale_qty`, 
`use_config_max_sale_qty`, `is_in_stock`, `low_stock_date`, `notify_stock_qty`, `use_config_notify_stock_qty`, 
`manage_stock`, `use_config_manage_stock`, `stock_status_changed_auto`, `use_config_qty_increments`, `qty_increments`, 
`use_config_enable_qty_inc`, `enable_qty_increments`, `is_decimal_divided`) VALUES
(59, 59, 1, '0.0000', '0.0000', 1, 0, 0, 1, '1.0000', 1, '0.0000', 1, 0, '2014-12-01 11:06:35', NULL, 1, 0, 1, 1, 1, 
'0.0000', 1, 0, 0);


#######se crea el status del producto

//tabla

cataloginventory_stock_status

//insert

//En este se inserta el producto, el tipo de sitio de magento que todos son 1, stock id que todos son 1
stock_id igual todos son 1, qty es la cantidad del producto, y stock_status 0 si esta agotado y 1 si esta en existencia
INSERT INTO `cataloginventory_stock_status` (`product_id`, `website_id`, `stock_id`, `qty`, `stock_status`) VALUES
(59, 1, 1, '0.0000', 0);

#######esta es para la busqueda rapida

//tabla
catalogsearch_fulltext

#esta sirve como busqueda, el primer campo es autoincrementativo,
el segundo el id del producto,
el 3 "store_id" es por 7 por ser el numero de la tienda y el ultimo "data_index" se conforma de lo siguiente

nombre del prodcuto|color|Ninguno|nombre del producto|descripcion larga|descripcion corta|precio|existecia

existencia es 1 o 0

si no tiene color es "SampleLogo"

//insert
INSERT INTO `catalogsearch_fulltext` (`fulltext_id`, `product_id`, `store_id`, `data_index`) VALUES
(18891, 59, 7, 'productonuevosku|Shipping|productonuevo|productonuevo dsc|productonuevo dsc corta|100000000|0');

#######esta no c pa q se utiliza pero se inserta

//tabla

catalog_category_product_index

id de la categoria
producto, position que por default es 1, is_parent colocar 1, store_id es 7 y visibility es 4

//insert
INSERT INTO `catalog_category_product_index` (`category_id`, `product_id`, `position`, `is_parent`, `store_id`, `visibility`)
 VALUES
(2, 59, 0, 0, 7, 4)


#######me parece que es la fecha de creacion y ultima modificacion

//tabla

catalog_product_entity
entity_id es igual al id del producto
entity_type_id todos son 4
attribute_set_id entre 1 y 5 (no tengo idea)
type_id todos son "simple"
sku es el nombre del producto
created_at fecha de creacion


//insert
INSERT INTO `catalog_product_entity` (`entity_id`, `entity_type_id`, `attribute_set_id`, `type_id`, `sku`, `has_options`, `required_options`, `created_at`, `updated_at`) VALUES
(59, 4, 4, 'simple', 'productonuevosku', 0, 0, '2014-12-01 11:06:34', '2014-12-01 11:06:34');


#######son datos de Set Product as New from Date  y  Set Product as New to Date pero creo q no es necesario usar estos datos

//tabla

catalog_product_entity_datetime

value_id es autoincrementable
entity_type_id siempre es 4
attribute_id
store_id = 0
entity_id es igual al id del producto
value vacio esta bien

//insert
INSERT INTO `catalog_product_entity_datetime` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(1305, 4, 93, 0, 59, '2014-11-29 00:00:00'),
(1306, 4, 94, 0, 59, '2014-11-30 00:00:00'),
(1307, 4, 77, 0, 59, '2014-11-29 00:00:00'),
(1308, 4, 78, 0, 59, '2014-11-30 00:00:00'),
(1309, 4, 104, 0, 59, NULL),
(1310, 4, 105, 0, 59, NULL);

#######esta tiene el dato de with y precio especial creo q tampoco la ocupamos

//tabla

catalog_product_entity_decimal

el value_id es autoincrementable
entity_type_id todos son 4
attribute_id
store_id es 0
entity_id el producto
value el precio
//insert
INSERT INTO `catalog_product_entity_decimal` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(706, 4, 80, 0, 59, '11111111.0000'),Weight 
(707, 4, 75, 0, 59, '99999999.9999'),no tengo idea
(708, 4, 76, 0, 59, '33333333.0000'),Special Price 
(709, 4, 120, 0, 59, '99999999.9999'); no tengo idea

#######ni idea

//tabla

catalog_product_entity_int

value_id es autoincrementable
entity_type_id todos es igual a 4
attribute_id
store_id es igual a 0
entity_id es el id del producto

//insert
INSERT INTO `catalog_product_entity_int` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) 
VALUES
(502, 4, 96, 0, 59, 1),
(503, 4, 102, 0, 59, 4),
(504, 4, 122, 0, 59, 4),
(504, 4, 92, 0, 59, null),
(504, 4, 134, 0, 59, 4),
(505, 4, 100, 0, 59, 0);

#######ruta de la imagen, crea una url amigable rara, toma las dos letras primeras, te agrego insert paara q veas 
como lo hace

//tabla

catalog_product_entity_media_gallery

value_id es autoincrementativo
attribute_id todos son 88
entity_id es el id del producto
value se conforma así: primeraletra de la imagen/segunda letra de la imagen/imagen.png

//insert
INSERT INTO `catalog_product_entity_media_gallery` (`value_id`, `attribute_id`, `entity_id`, `value`) VALUES
(230, 88, 58, '/p/a/paul.jpg'),
(231, 88, 59, '/i/n/invitacion-de-boda-audrey.jpg');

#######aqui esta el comentario de la imagen su posicion enq aparece y estatus

//tabla

catalog_product_entity_media_gallery_value

value_id es el mismo de la tabla de arriba
store_id es 0
label es el nombre del producto
position por default
disabled es igual a 0

//insert
INSERT INTO `catalog_product_entity_media_gallery_value` (`value_id`, `store_id`, `label`, `position`, `disabled`) VALUES
(231, 0, 'imagen de producto', 1, 0);


#######comentarios cortos del producto

//tabla

catalog_product_entity_text

//insert

entity_id el id del producto es lo unico que cambia.

INSERT INTO `catalog_product_entity_text` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(576, 4, 72, 0, 59, 'productonuevo dsc'),
(577, 4, 73, 0, 59, 'productonuevo dsc corta'),
(578, 4, 83, 0, 59, NULL),
(579, 4, 106, 0, 59, NULL);


#######no se pa q madres sea pero tiene datos de la imgen 

//tabla

catalog_product_entity_varchar

//insert

insertar todos tal cual solo cambiando el ultimo parametro y el id del producto

INSERT INTO `catalog_product_entity_varchar` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) 
VALUES
(2594, 4, 71, 0, 59, 'productonuevo'),
(2595, 4, 97, 0, 59, 'productonuevosku'),
(2596, 4, 117, 0, 59, 'MX'),
(2597, 4, 118, 0, 59, '2'),
(2598, 4, 119, 0, 59, '4'),
(2599, 4, 82, 0, 59, NULL),
(2600, 4, 84, 0, 59, NULL),
(2601, 4, 85, 0, 59, '/i/n/invitacion-de-boda-audrey.jpg'),
(2602, 4, 86, 0, 59, '/i/n/invitacion-de-boda-audrey.jpg'),
(2603, 4, 87, 0, 59, '/i/n/invitacion-de-boda-audrey.jpg'),
(2604, 4, 103, 0, 59, NULL),
(2605, 4, 107, 0, 59, NULL),
(2606, 4, 109, 0, 59, 'container2'),
(2607, 4, 123, 0, 59, NULL),
(2608, 4, 112, 0, 59, 'imagen de producto'),
(2609, 4, 113, 0, 59, 'imagen de producto'),
(2610, 4, 114, 0, 59, 'imagen de producto'),
(2611, 4, 98, 7, 59, 'productonuevosku.html'),
(2612, 4, 98, 0, 59, 'productonuevosku.html');

#######no c pa q sea

//tabla

catalog_product_index_eav

entity_id id del producto
attribute_id subgrupo
store_id todos son 7
value = 4

//insert
INSERT INTO `catalog_product_index_eav` (`entity_id`, `attribute_id`, `store_id`, `value`) VALUES
(59, 122, 7, 4),


#######estos son los precios pero no c por q lo repite tanto, el precio q yo agregue es el 333333 el 99999 no c

//tabla

catalog_product_index_price

se repite 4veces el precio solamente, cambia el id del producto

//insert
INSERT INTO `catalog_product_index_price` (`entity_id`, `customer_group_id`, `website_id`, `tax_class_id`, `price`, `final_price`, `min_price`, `max_price`, `tier_price`, `group_price`) VALUES
(59, 0, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
(59, 1, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
(59, 2, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
(59, 3, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL);


#######tambien son precios pero no creo q sean necesarios ya q son los unicos q aparecen en la bd

//tabla

catalog_product_index_price_tmp

esto es temporal asi que no guardarlo

//insert
INSERT INTO `catalog_product_index_price_tmp` (`entity_id`, `customer_group_id`, `website_id`, `tax_class_id`, `price`, `final_price`, `min_price`, `max_price`, `tier_price`, `group_price`) VALUES
(59, 0, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
(59, 1, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
(59, 2, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
(59, 3, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL);

#######no c q pex pero solo se agrega el id y el  1 adjunto las demas para q veas

//tabla

catalog_product_website

product_id el id del prducto
y website siempre sera 1

//insert
INSERT INTO `catalog_product_website` (`product_id`, `website_id`) VALUES
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1);

#######no tengo idea,agun pedo de url amigable te pono otras para q compares

//tabla

core_url_rewrite

//insert
INSERT INTO `core_url_rewrite` (`url_rewrite_id`, `store_id`, `id_path`, `request_path`, `target_path`, `is_system`, `options`, `description`, `category_id`, `product_id`) VALUES
(20232, 7, 'category/3', 'productos.html', 'catalog/category/view/id/3', 1, NULL, NULL, 3, NULL),
(20233, 7, 'category/15', 'productos/boligrafo.html', 'catalog/category/view/id/15', 1, NULL, NULL, 15, NULL),
(25086, 7, 'product/59', 'productonuevosku.html', 'catalog/product/view/id/59', 1, NULL, NULL, NULL, 59);

#######esta pinche tabla esta rara,pero creo q es solo como un log

//tabla

index_event

//insert
INSERT INTO `index_event` (`event_id`, `type`, `entity`, `entity_pk`, `created_at`, `old_data`, `new_data`) VALUES
(377, 'save', 'cataloginventory_stock_item', 59, '2014-12-01 11:06:35', NULL, 'a:5:{s:35:"cataloginventory_stock_match_result";b:1;s:34:"catalog_product_price_match_result";b:0;s:24:"catalog_url_match_result";b:0;s:37:"catalog_category_product_match_result";b:0;s:35:"catalogsearch_fulltext_match_result";b:0;}'),
(378, 'save', 'catalog_product', 59, '2014-12-01 11:06:36', NULL, 'a:5:{s:35:"cataloginventory_stock_match_result";b:1;s:34:"catalog_product_price_match_result";b:1;s:24:"catalog_url_match_result";b:1;s:37:"catalog_category_product_match_result";b:1;s:35:"catalogsearch_fulltext_match_result";b:1;}'),
(379, 'catalog_reindex_price', 'catalog_product', 59, '2014-12-01 11:06:36', NULL, 'a:5:{s:35:"cataloginventory_stock_match_result";b:0;s:34:"catalog_product_price_match_result";b:1;s:24:"catalog_url_match_result";b:0;s:37:"catalog_category_product_match_result";b:0;s:35:"catalogsearch_fulltext_match_result";b:0;}');


#######no c q pedo, pero no hay nada q ver, solo son cambios de sistema me imagino pero t la adjunto

//tabla

index_process

//insert
INSERT INTO `index_process` (`process_id`, `indexer_code`, `status`, `started_at`, `ended_at`, `mode`) VALUES
(1, 'catalog_product_attribute', 'pending', '2014-12-01 11:06:35', '2014-12-01 11:06:35', 'real_time'),
(2, 'catalog_product_price', 'pending', '2014-12-01 11:06:36', '2014-12-01 11:06:36', 'real_time'),
(3, 'catalog_url', 'require_reindex', '2014-12-01 11:06:36', '2014-12-01 11:06:36', 'real_time'),
(4, 'catalog_product_flat', 'pending', '2014-07-14 13:45:51', '2014-07-14 13:45:59', 'real_time'),
(5, 'catalog_category_flat', 'pending', '2014-07-14 13:45:59', '2014-07-14 13:46:00', 'real_time'),
(6, 'catalog_category_product', 'require_reindex', '2014-12-01 11:06:36', '2014-12-01 11:06:36', 'real_time'),
(7, 'catalogsearch_fulltext', 'require_reindex', '2014-12-01 11:06:36', '2014-12-01 11:06:36', 'real_time'),
(8, 'cataloginventory_stock', 'require_reindex', '2014-12-01 11:06:35', '2014-12-01 11:06:35', 'real_time'),
(9, 'tag_summary', 'pending', '2014-12-01 11:06:36', '2014-12-01 11:06:36', 'real_time');
