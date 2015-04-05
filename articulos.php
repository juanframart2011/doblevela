<? 
#Conexión a la base de datos de sap sql server
$datos = "DOBLEVELA"; 
$user = "sa";
$psr = "B1Admin";

#Conexión a la base de datos de doblevela mysql
$servidor = 'localhost';
$usuario = 'root';
$contra = '';

#Conexión a doblevela mysql
$conexion = mysql_connect( $servidor, $usuario, $contra );
mysql_select_db( '_f1901-01', $conexion );
/*
#Conexión y consultas a sqp sql server
$con = odbc_connect( $datos, $user, $psr );

if ( !$con ){

  exit("error de conexion");
} */

if( $_GET["f"] == "a" ){
  

  #Este apartado es para sacar datos del sap y meterlos a magento

  #Consulta la cual reviamos la fecha de ultimo producto guardado
  $consulta_db = 'SELECT art_fecha_guardado FROM articulo_sap order by art_id desc limit 1 ';

  $ejecutar_consulta_db = mysql_query( $consulta_db, $conexion );

  $arreglo_fecha = mysql_fetch_array( $ejecutar_consulta_db );

  #Si hay una fecha entonces busco desde esa fecha en la tabla de articulos
  if( !empty( $arreglo_fecha ) ){

    $sql = "SELECT 
      ItemCode as codigo, 
      ItemName as nombre, 
      ItmsGrpCod as grupo, 
      FirmCode as subcategoria, 
      CreateDate as creacion, 
      UpdateDate as modificacion,  
      CAST(U_Familia AS VARCHAR) as categoria,
      CAST(U_DatosImpresion AS VARCHAR) as impresion,
      CAST(UserText AS VARCHAR) as descripcion, 
      CAST(UserText AS VARCHAR) as texto, 
      CAST(PicturName AS VARCHAR) as imagen
      FROM OITM TI  WHERE CreateDate > '".$arreglo_fecha[0]."'  AND TI.SellItem = 'Y' AND TI.InvntItem = 'Y' AND ((TI.validFor = 'N' AND TI.FrozenFor='N') OR (TI.validFor = 'Y' AND (TI.validFrom IS NULL OR TI.validFrom <= GETDATE()) AND (TI.validTo IS NULL OR TI.validTo >= GETDATE())) OR (TI.frozenFor = 'Y' AND (((TI.frozenFrom<GETDATE() OR TI.frozenFrom IS NULL) AND TI.frozenTo < GETDATE()) OR (TI.frozenFrom > GETDATE() AND (TI.frozenTo > GETDATE() OR TI.frozenTo IS NULL))))) order by CreateDate desc";
  }
  else{

    $sql = "SELECT 
      ItemCode as codigo, 
      ItemName as nombre, 
      ItmsGrpCod as grupo, 
      FirmCode as subcategoria, 
      CreateDate as creacion, 
      UpdateDate as modificacion,  
      CAST(U_Familia AS VARCHAR) as categoria,
      CAST(VatGourpSa AS VARCHAR) as impresion,
      CAST(UserText AS VARCHAR) as descripcion, 
      CAST(UserText AS VARCHAR) as texto, 
      CAST(PicturName AS VARCHAR) as imagen
      FROM OITM TI	WHERE TI.SellItem = 'Y' AND TI.InvntItem = 'Y' AND ((TI.validFor = 'N' AND TI.FrozenFor='N') OR (TI.validFor = 'Y' AND (TI.validFrom IS NULL OR TI.validFrom <= GETDATE()) AND (TI.validTo IS NULL OR TI.validTo >= GETDATE())) OR (TI.frozenFor = 'Y' AND (((TI.frozenFrom<GETDATE() OR TI.frozenFrom IS NULL) AND TI.frozenTo < GETDATE()) OR (TI.frozenFrom > GETDATE() AND (TI.frozenTo > GETDATE() OR TI.frozenTo IS NULL))))) order by CreateDate desc";
  }


  $result = odbc_exec( $con, $sql )or die( exit( "Error en odbc_exec" ) );

  if( odbc_num_rows( $result ) ) { 

  	while( $arreglo = @odbc_fetch_array( $result ) ) { 
     		
        $codigo = $arreglo["codigo"];
        $nombre = $arreglo["nombre"];
        $grupo = $arreglo["grupo"];
        $subcategoria = $arreglo["subcategoria"];
        $creacion = $arreglo["creacion"];
        $modificacion = $arreglo["modificacion"];
        $categoria = $arreglo["categoria"];
        @$impresion = $arreglo["impresion"];
        $descripcion = $arreglo["descripcion"];
        $texto = $arreglo["texto"];
        $imagen = $arreglo["imagen"];

     		$fecha_creacion = date( "Y-m-d H:i:s" );

        $sql = 'INSERT INTO `articulo_sap`( `cat_code`, `art_grupo`, `art_nombre`, `art_codigo`, `sub_firm_code`, 
              `art_fecha_creado`, `art_fecha_modificado`, `art_impresion`, `art_descripcion`, `art_texto`, `art_imagen`, 
              `art_fecha_guardado`) VALUES ( 
              "'.$categoria.'", "'.$grupo.'", "'.$nombre.'", "'.$codigo.'", "'.$subcategoria.'", "'.$creacion.'", 
              "'.$modificacion.'", "'.@$impresion.'", "'.$descripcion.'", "'.$texto.'", "'.$imagen.'", "'.$fecha_creacion.'" )';

  		  $ejecutar_consulta = mysql_query( $sql, $conexion );

     		if( $ejecutar_consulta ){

     			echo 'Se guardo => '.$nombre.'<br>';
     		}
     		else{

     			echo 'No se guardo => '.$nombre.'<br>';
     		}
     	} 
  }
  else{

    echo'Ya est actualizada la tabla de productos.<br>';
  }
}


#Sacar los stock
if( $_GET["f"] == "stock" ){
  #primero tomamos todos los articulos que no han sido inserta

  

  //echo $arreglo_articulo["art_codigo"];
  $sql = ' SELECT ItemCode, OnHand, IsCommited from OITW ';

  $result = odbc_exec( $con, $sql )or die( exit( "Error en odbc_exec" ) );

  $arreglo = @odbc_fetch_array( $result );

  print_r($arreglo);

  if( odbc_num_rows( $result ) ) { 

    $arreglo = @odbc_fetch_array( $result );



    while( $arreglo = @odbc_fetch_array( $result ) ) { 

        $sql_articulos = ' UPDATE `articulo_sap` SET `art_stock`="'.$arreglo["OnHand"].'",`art_comit`="'.$arreglo["IsCommited"].'" WHERE art_codigo = "'.$arreglo["ItemCode"].'" ';

        $ejecutar_consulta = mysql_query( $sql_articulos, $conexion );
        //echo 'Articulo => codigo: '.$arreglo["ItemCode"].' OnHand: '.$arreglo["OnHand"].' IsComited: '.$arreglo["IsCommited"].'<br>';
    }
  }
}



if( $_GET["f"] == "inyeccion" ){

  $client = new SoapClient('http://localhost:82/doblevela_git/api/v2_soap/?wsdl');

  // If some stuff requires api authentification,
  // then get a session token
  $session = $client->login('doblevela_soap', 'doblevela');
/*
  $sql_articulo = 'SELECT *, subgrupos_sap.id_magento as categoria_actual, subgrupos_sap.subFirmName, 
                  categoria_sap.cat_name as supercategoria FROM articulo_sap 
                  INNER JOIN subgrupos_sap ON articulo_sap.sub_Firm_Code = subgrupos_sap.sub_FirmCode
                  INNER JOIN categoria_sap ON articulo_sap.cat_code = categoria_sap.cat_code
                  WHERE articulo_sap.art_estatus_insercion = 0 limit 5';*/

  $sql_articulo = 'SELECT * FROM articulo_sap WHERE art_estatus_insercion = 0';

  $ejecutar_consulta = mysql_query( $sql_articulo );

  function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
  }

  while( $arreglo = mysql_fetch_array( $ejecutar_consulta ) ){

    $art_id = $arreglo["art_id"];
    $articulo = quitar_tildes( $arreglo["art_nombre"] );
    $descripcion = quitar_tildes( $arreglo["art_descripcion"] );
    $texto_corto = quitar_tildes( $arreglo["art_texto"] );

    $numero_letras = strlen( $articulo );

    $url = substr( $articulo, 0, 4 ).'-'.date( "D" ).( date( "s" ) * $numero_letras );

    $precio = 100;
    $sku = $url;

    // get attribute set
    $attributeSets = $client->catalogProductAttributeSetList($session);
    $attributeSet = current($attributeSets);

    $result = $client->catalogProductCreate($session, 'simple', 9, $sku, array(
        'categories' => array(2),
        'websites' => array(1),
        'category_ids' => 103,
        'name' => $articulo,
        'description' => $descripcion,
        'short_description' => $texto_corto,
        'weight' => '14',
        'status' => '1',
        'url_key' => $url,
        'url_path' => $url,
        'visibility' => '4',
        'price' => $precio,
        'tax_class_id' => 1,
        'meta_title' => 'Producto title',
        'meta_keyword' => 'Producto keyword',
        'meta_description' => 'Meta-descripcion'
    ));

    if( !empty( $result ) ){

      $sql_update = ' UPDATE `articulo_sap` SET `id_magento`='.$result.', `art_estatus_insercion`=1 WHERE `art_id` = '.$art_id.' ';
      $update = mysql_query( $sql_update );
      echo 'Articulo => '.$articulo.' Guardado con éxito<br>';
    }
    else{

      echo 'Articulo => '.$articulo.' No se Guardado con éxito<br>';
    }
  }
}


#Insertamos las imagen
if( $_GET["f"] == "imagen" ){

  $client = new SoapClient('http://localhost:82/doblevela_git/api/v2_soap/?wsdl');

  // If some stuff requires api authentification,
  // then get a session token
  $session = $client->login('doblevela_soap', 'doblevela');

  $sql_articulo = 'SELECT * FROM articulo_sap WHERE art_estatus_insercion = 0';

  $ejecutar_consulta = mysql_query( $sql_articulo );

  while( $arreglo = mysql_fetch_array( $ejecutar_consulta ) ){

    $productId = 97;

    $im = file_get_contents('C:/Users/KTBO54/Downloads/Banco_Imagenes/Otros/cagar.jpg');
    $imdata = base64_encode($im);
    //echo $imdata;

    $file = array(
      'content' => $imdata,
      'mime' => 'image/jpeg'
    );

    $result = $client->catalogProductAttributeMediaCreate(
      $session,
      $productId,
      array('file' => $file, 'label' => 'Label', 'position' => '100', 'types' => array('thumbnail'), 'exclude' => 0)
    );

    var_dump($result);
  }
}

if( $_GET["f"] == "p_imagen" ){

  $hola = 'Hola mundo';

  $pos = strrpos( $hola, " ");

  if ($pos !== false) { // nota: tres signos de igual
    
    echo 'se encontro';
  }
}
?>
Articulo => MULTI CORTADOR CUT-M2 Guardado con Ã©xito
Articulo => TEST Guardado con Ã©xito
Articulo => USB PEGAMENTO 4GB Guardado con Ã©xito
Articulo => BASCULA MICARDIS N-5325 TRANSPARENTE Guardado con Ã©xito
Articulo => BATERIA PORTATIL ILINOIS TEC0059 BLANCO Guardado con Ã©xito
Articulo => TAPA DE PLASTICO ANDREO TPN2000 AZUL Guardado con Ã©xito

Fatal error: Uncaught SoapFault exception: [1] The value of attribute "SKU" 
must be unique in /Applications/XAMPP/xamppfiles/htdocs/doblevela/articulos.php:199 
Stack trace: #0 /Applications/XAMPP/xamppfiles/htdocs/doblevela/articulos.php(199): 
SoapClient->__call('catalogProductC...', Array) #1 /Applications/XAMPP/xamppfiles/htdocs/doblevela/articulos.php(199): 
SoapClient->catalogProductCreate('b2fdba3bb9fcb8c...', 'simple', 15, 'TAPA', Array) #2 {main} 
thrown in /Applications/XAMPP/xamppfiles/htdocs/doblevela/articulos.php on line 199