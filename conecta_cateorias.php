<? 
flush();
#Conexión a la base de datos de sap sql server
$datos = "DOBLEVELA"; 
$user = "sa";
$psr = "B1Admin";

#Conexión a la base de datos de doblevela mysql
$servidor = 'localhost';
$usuario = 'root';
$contra = 'doblevela';

#Conexión a doblevela mysql
$conexion = mysql_connect( $servidor, $usuario, $contra );
mysql_select_db( 'doblevela', $conexion );

flush();

#Conexión y consultas a sqp sql server
$con = odbc_connect( $datos, $user, $psr );

if ( !$con ){

	exit("error de conexion");
}	

#Consulta para categorías
$sql_categorias = 'SELECT Code, Name FROM [@BLUE_FAMILIAS] ';

$result_categoria = odbc_exec( $con, $sql_categorias )or die( exit( "Error en odbc_exec" ) );

while( $arreglo = @odbc_fetch_array( $result_categoria ) ) { 
	
	$fecha_creacion = date( "Y-m-d H:i:s" );

	$sql = 'INSERT INTO `categoria_sap`( `cat_code`, `cat_name`, `cat_fecha_creacion`) VALUES ( "'.$arreglo["Code"].'", "'.$arreglo["Name"].'", "'.$fecha_creacion.'" )';

	$ejecutar_consulat = mysql_query( $sql, $conexion );
	
	if( $ejecutar_consulat ){

		echo 'Se guardo => '.$arreglo["Name"].'<br>';
	}
	else{

		echo 'No se guardo => '.$arreglo["Name"].'<br>';
	}
}

#Consulta para subcategorías
$sql_categorias = ' SELECT FirmCode, FirmName FROM OMRC ';

$result_categoria = odbc_exec( $con, $sql_categorias )or die( exit( "Error en odbc_exec" ) );

$sub = 1;
echo '<br>';

while( $arreglo = @odbc_fetch_array( $result_categoria ) ) { 
	
	if( $arreglo["FirmName"] != "." && $arreglo["FirmName"] != "LIBRE" && !empty( $arreglo["FirmName"] ) ){

		$nombre_subgrupo = explode( " ", $arreglo["FirmName"] );

		$sub_g = explode( "B", @$nombre_subgrupo[0] );

		$fecha_creacion = date( "Y-m-d H:i:s" );
	
		$sql = 'INSERT INTO `subgrupos_sap`( `cat_code`, `sub_code`, `sub_nombre`, `sub_FirmCode`, `subFirmName`, `sub_fecha_creacion`) VALUES (
			"'.@$sub_g[0].'", "'.@$sub_g[0].'", "B'.@$sub_g[1].'", "'.$arreglo["FirmCode"].'", "'.$nombre_subgrupo[1].'", "'.$fecha_creacion.'" )';

		$ejecutar_consulat = mysql_query( $sql, $conexion );
		
		if( $ejecutar_consulat ){

			echo 'Se guardo => '.$arreglo["FirmName"].'<br>';
		}
		else{

			echo 'No se guardo => '.$arreglo["FirmName"].'<br>';
		}

	}
}


#Consulta para guardar productos
?>