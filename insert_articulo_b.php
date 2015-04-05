<?

#Aqui comenzamos el insert de articulos a magento
if( $_GET["f"] == "d" ){

  $sql_articulo = 'SELECT *, subgrupos_sap.id_magento as categoria_actual, subgrupos_sap.subFirmName, categoria_sap.cat_name as supercategoria FROM articulo_sap 
                  INNER JOIN subgrupos_sap ON articulo_sap.sub_Firm_Code = subgrupos_sap.sub_FirmCode
                  INNER JOIN categoria_sap ON articulo_sap.cat_code = categoria_sap.cat_code
                  WHERE articulo_sap.art_estatus_insercion = 0';

  $ejecutar_consulta_articulos = mysql_query( $sql_articulo, $conexion );

  //print_r($articulos);

  while( $articulos = mysql_fetch_array( $ejecutar_consulta_articulos ) ){

    $descripcion = $articulos["art_texto"]; 
    $nombre_articulo = $articulos["art_nombre"];
    $nombre_subcategoria = $articulos["subFirmName"];
    $imagen = $articulos["art_imagen"];
    $fecha_creacion = date( "Y-m-d H:i:s" );
    $categoria = $articulos["categoria_actual"];
    $super_categoria = $articulos["supercategoria"];
    $super_categoria_id = $articulos["cat_code"];

    #Comenzamos la inyeción en la primera tabla que es producto y pedimos el id para seguir las inyecciones
    $sql_producto = 'INSERT INTO `catalog_product_entity` (`entity_type_id`, `attribute_set_id`, `type_id`, `sku`, `created_at`) VALUES
                  (4, 4, "simple", "'.$nombre_articulo.'", "'.$fecha_creacion.'") ';

    $consulta_producto = mysql_query( $sql_producto, $conexion );
    #Tomo el id del producto insertado y comienzo las inyecciones

    $producto_id = mysql_insert_id();

    $sql1 = 'INSERT INTO `cataloginventory_stock_item` (`product_id`, `stock_id`, `qty`, `is_in_stock`, 
      `enable_qty_increments`, `is_decimal_divided`) VALUES ( '.$producto_id.', 1, 10.0000, 1, 1, 1)';

	$consulta_1 = mysql_query( $sql1, $conexion );

    $sql2 = 'INSERT INTO `cataloginventory_stock_status` (`product_id`, `website_id`, `stock_id`, `qty`, `stock_status`) VALUES ('.$producto_id.', 1, 1, 10.0000, 1)';

    $consulta_2 = mysql_query( $sql2, $conexion );

    $sql3 = 'INSERT INTO `catalogsearch_fulltext` (`fulltext_id`, `product_id`, `store_id`, `data_index`) VALUES
    ('.$producto_id.', 7, "'.$nombre_articulo.'|SampleLogo|'.$descripcion.'|'.$descripcion.'|'.$descripcion.'|100000000|1")';

    $consulta_3 = mysql_query( $sql3, $conexion );

    $sql4 = 'INSERT INTO `catalog_category_product_index` (`category_id`, `product_id`, `position`, `is_parent`, `store_id`, `visibility`) VALUES (2, '.$producto_id.', 1, 1, 7, 4)';

    $consulta_4 = mysql_query( $sql4, $conexion );

    $sql5 = "INSERT INTO `catalog_product_entity_datetime` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
      (1305, 4, 93, 0, '.$producto_id.', '2014-11-29 00:00:00'),
      (1306, 4, 94, 0, '.$producto_id.', '2014-11-30 00:00:00'),
      (1307, 4, 77, 0, '.$producto_id.', '2014-11-29 00:00:00'),
      (1308, 4, 78, 0, '.$producto_id.', '2014-11-30 00:00:00'),
      (1309, 4, 104, 0, '.$producto_id.', NULL),
      (1310, 4, 105, 0, '.$producto_id.', NULL)";

      $consulta_5 = mysql_query( $sql5, $conexion );

      #Para sacar la categoría investigare el subgrupo

    $sql6 = "INSERT INTO `catalog_product_entity_decimal` (`entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
		(".$producto_id.", 80, 0, ".$categoria.", '11111111.0000'), 
		(".$producto_id.", 75, 0, ".$categoria.", '99999999.9999'),
		(".$producto_id.", 76, 0, ".$categoria.", '33333333.0000'),
		(".$producto_id.", 120, 0, ".$categoria.", '99999999.9999')";

	$consulta_6 = mysql_query( $sql6, $conexion );

	$sql7 = "INSERT INTO `catalog_product_entity_int` (`entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) 
			VALUES
			(".$producto_id.", 96, 0, ".$categoria.", 1),
			(".$producto_id.", 102, 0, ".$categoria.", 4),
			(".$producto_id.", 122, 0, ".$categoria.", 4),
			(".$producto_id.", 92, 0, ".$categoria.", null),
			(".$producto_id.", 134, 0, ".$categoria.", 4),
			(".$producto_id.", 100, 0, ".$categoria.", 0)";

	$consulta_7 = mysql_query( $sql7, $conexion );

	#Creamos variable de la imagen si hay imagen
	if( !empty( $imagen ) ){

		$letra_a = substr( $imagen, 0, 1 );
		$letra_b = substr( $imagen, 1, 1 );

		$variable_imagen = '/'.$letra_a.'/'.$letra_b.'/'.$imagen;
	}
	else{

		$variable_imagen = '';
	}

	$sql8 = "INSERT INTO `catalog_product_entity_media_gallery` (`attribute_id`, `entity_id`, `value`) VALUES
		(88, ".$producto_id.", '".$variable_imagen."')";

	$consulta_8 = mysql_query( $sql8, $conexion );

	$respuesta_media = mysql_insert_id();

	$sql9 = "INSERT INTO `catalog_product_entity_media_gallery_value` (`value_id`, `store_id`, `label`, `position`, 
		`disabled`) VALUES
		( ".$respuesta_media.", 0, '".$imagen."', 1, 0)";

	$consulta_9 = mysql_query( $sql9, $conexion );

	$sql10 = "INSERT INTO `catalog_product_entity_text` (`entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
		(4, 72, 0, ".$producto_id.", '".$descripcion."'),
		(4, 73, 0, ".$producto_id.", '".$descripcion."'),
		(4, 83, 0, ".$producto_id.", NULL),
		(4, 106, 0, ".$producto_id.", NULL)";

	$consulta_10 = mysql_query( $sql10, $conexion );

	$sql11 = "INSERT INTO `catalog_product_entity_varchar` (`entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) 
		VALUES
		(4, 71, 0, ".$producto_id.", '".$nombre_articulo."'),
		(4, 97, 0, ".$producto_id.", '".$nombre_articulo."'),
		(4, 117, 0, ".$producto_id.", 'MX'),
		(4, 118, 0, ".$producto_id.", '2'),
		(4, 119, 0, ".$producto_id.", '4'),
		(4, 82, 0, ".$producto_id.", NULL),
		(4, 84, 0, ".$producto_id.", NULL),
		(4, 85, 0, ".$producto_id.", '".$variable_imagen."'),
		(4, 86, 0, ".$producto_id.", '".$variable_imagen."'),
		(4, 87, 0, ".$producto_id.", '".$variable_imagen."'),
		(4, 103, 0, ".$producto_id.", NULL),
		(4, 107, 0, ".$producto_id.", NULL),
		(4, 109, 0, ".$producto_id.", 'container2'),
		(4, 123, 0, ".$producto_id.", NULL),
		(4, 112, 0, ".$producto_id.", '".$imagen."'),
		(4, 113, 0, ".$producto_id.", '".$imagen."'),
		(4, 114, 0, ".$producto_id.", '".$imagen."'),
		(4, 98, 7, ".$producto_id.", '".$nombre_articulo.".html'),
		(4, 98, 0, ".$producto_id.", '".$nombre_articulo.".html')";

	$consulta_11 = mysql_query( $sql11, $conexion );

	$sql12 = "INSERT INTO `catalog_product_index_eav` (`entity_id`, `attribute_id`, `store_id`, `value`) VALUES
		(".$producto_id.", ".$categoria.", 7, 4)";

	$consulta_12 = mysql_query( $sql12, $conexion );

	$sql13 = "INSERT INTO `catalog_product_index_price` (`entity_id`, `customer_group_id`, `website_id`, `tax_class_id`, `price`, `final_price`, `min_price`, `max_price`, `tier_price`, `group_price`) VALUES
		(".$producto_id.", 0, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
		(".$producto_id.", 1, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
		(".$producto_id.", 2, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL),
		(".$producto_id.", 3, 1, 4, '99999999.9999', '33333333.0000', '33333333.0000', '33333333.0000', NULL, NULL)";

	$consulta_13 = mysql_query( $sql13, $conexion );

	$sql14 = "INSERT INTO `catalog_product_website` (`product_id`, `website_id`) VALUES (".$producto_id.", 1)";
	$consulta_14 = mysql_query( $sql14, $conexion );

	$sql15 = "INSERT INTO `core_url_rewrite` (`store_id`, `id_path`, `request_path`, `target_path`, `is_system`, `options`, `description`, `category_id`, `product_id`) VALUES
		(7, 'product/".$producto_id."', '".$nombre_articulo.".html', 'catalog/product/view/id/".$producto_id."', 1, NULL, NULL, NULL, ".$producto_id."),
		(7, 'product/".$producto_id."/".$categoria."', 'productos/".$super_categoria."/ecologicos/".$nombre_articulo.".html', 'catalog/product/view/id/".$producto_id."/category/".$categoria."', 1, NULL, NULL, ".$categoria.", ".$producto_id."),
		(7, 'product/".$producto_id."/".$super_categoria_id."', 'productos/".$nombre_articulo.".html', 'catalog/product/view/id/".$producto_id."/category/".$super_categoria_id."', 1, NULL, NULL, ".$super_categoria_id.", ".$producto_id."),
		(7, 'product/".$producto_id."/".$categoria."', 'productos/".$super_categoria."/".$nombre_articulo.".html', 'catalog/product/view/id/".$producto_id."/category/".$categoria."', 1, NULL, NULL, ".$categoria.", ".$producto_id.")";
  }
}
?>