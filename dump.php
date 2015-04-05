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

#Consulta la cual reviamos la fecha de ultimo producto guardado
$consulta_db = 'SELECT cat_fecha_creacion FROM articulo_sap order by cat_id desc limit 1 ';

$ejecutar_consulta_db = mysql_query( $consulta_db, $conexion );

$arreglo_fecha = mysql_fetch_array( $ejecutar_consulta_db );

#SELECT cat_fecha_creacion, cat_id FROM categoria_sap where cat_fecha_creacion >  '2014-11-29 18:42:27' order by cat_id desc limit 1

if( !empty( $arreglo_fecha ) ){

	echo 'aqui tambiena';
	//$sql = "SELECT TOP(1) ItemCode, ItemName, ItmsGrpCod, CreateDate, UpdateDate FROM OITM where CreateDate > '".$arreglo_fecha[0]."' order by CreateDate desc ";
	//$sql = "SELECT TOP(1) ItemCode, ItemName, ItmsGrpCod, FirmCode, CreateDate, UpdateDate,  U_Familia, U_DatosImpresion, U_DescripcionAmplia, UserText, PicturName FROM OITM TI	WHERE CreateDate > '".$arreglo_fecha[0]."'  AND TI.SellItem = 'Y' AND TI.InvntItem = 'Y' AND ((TI.validFor = 'N' AND TI.FrozenFor='N') OR (TI.validFor = 'Y' AND (TI.validFrom IS NULL OR TI.validFrom <= GETDATE()) AND (TI.validTo IS NULL OR TI.validTo >= GETDATE())) OR (TI.frozenFor = 'Y' AND (((TI.frozenFrom<GETDATE() OR TI.frozenFrom IS NULL) AND TI.frozenTo < GETDATE()) OR (TI.frozenFrom > GETDATE() AND (TI.frozenTo > GETDATE() OR TI.frozenTo IS NULL))))) order by CreateDate desc";
}
else{

	//echo'Consultasss por primera vez';
	//$sql = "SELECT TOP(1) CAST(U_Familia AS VARCHAR)  FROM OITM";
    $sql = "SELECT 
    ItemCode, 
    ItemName, 
    ItmsGrpCod, 
    FirmCode, 
    CreateDate, 
    UpdateDate,  
    CAST(U_Familia AS VARCHAR),
    CAST(U_DatosImpresion AS VARCHAR),
    CAST(U_DescripcionAmplia AS VARCHAR), 
    CAST(UserText AS VARCHAR), 
    CAST(PicturName AS VARCHAR)
    FROM OITM TI	WHERE CreateDate > '".$arreglo_fecha[0]."'  AND TI.SellItem = 'Y' AND TI.InvntItem = 'Y' AND ((TI.validFor = 'N' AND TI.FrozenFor='N') OR (TI.validFor = 'Y' AND (TI.validFrom IS NULL OR TI.validFrom <= GETDATE()) AND (TI.validTo IS NULL OR TI.validTo >= GETDATE())) OR (TI.frozenFor = 'Y' AND (((TI.frozenFrom<GETDATE() OR TI.frozenFrom IS NULL) AND TI.frozenTo < GETDATE()) OR (TI.frozenFrom > GETDATE() AND (TI.frozenTo > GETDATE() OR TI.frozenTo IS NULL))))) order by CreateDate desc";
}

echo '<br>'.$sql;
flush();
$result = odbc_exec( $con, $sql )or die( exit( "Error en odbc_exec" ) );
flush();

if( odbc_num_rows( $result ) ) { 

	while( $arreglo = @odbc_fetch_array( $result ) ) { 
   		
   		$fecha_creacion = date( "Y-m-d H:i:s" );

   		//$sql = 'INSERT INTO `articulo_sap`( `cat_nombre`, `cat_item_code`, `cat_ItmsGrpCod`, `art_subgrupo`, `cat_CreateDate`, `cat_UpdateDate`, `art_descripcion`, `art_imagen`, `cat_fecha_creacion`) VALUES ( "'.$arreglo["ItemName"].'", "'.$arreglo["ItemCode"].'", "'.$arreglo["ItmsGrpCod"].'", "'.$arreglo["FirmCode"].'", "'.$arreglo["CreateDate"].'", "'.$arreglo["UpdateDate"].'", "'.$arreglo["UserText"].'",  "'.$arreglo["PicturName"].'","'.$fecha_creacion.'" )';

		$ejecutar_consulta = mysql_query( $sql, $conexion );
   		
   		if( $ejecutar_consulta ){

   			echo 'Se guardo => '.$arreglo["ItemName"].'<br>';
   		}
   		else{

   			echo 'No se guardo => '.$arreglo["VARCHAR"].'<br>';
   		}
   		flush();
   	} 
}
?>