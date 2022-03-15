<?php
//  admin 				$2y$10$gzjHm1TeNEE4jj9LXB2VmupI7EERdD1.gXXe3VFXOPAGmpGyNhBO2
//  prueba.temporal 	$2y$10$KRz12gUeU6./wzGdpfEKhuxHu6Aqt0OoZj6wxutvGSpEHlHTTpKxK

$cons_usuario = 'useraulavibero';
$cons_contra = '8qGnku%Q+g$me';
$cons_base_datos = 'aulavirtual_2020';
$cons_equipo = '172.16.15.253';

$obj_conexion =    mysqli_connect($cons_equipo, $cons_usuario, $cons_contra, $cons_base_datos);
if(!$obj_conexion){
	echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
} else {
	echo "<h3>Conexion Exitosa PHP - MySQL</h3><hr><br>";
}

$usuariosnuevos_consulta= "SELECT id, username, password FROM mdl_user WHERE password='restored' ORDER BY id ASC LIMIT 20000";
$usuariosnuevos_resultado = $obj_conexion->query($usuariosnuevos_consulta);

while ($var_fila=$usuariosnuevos_resultado->fetch_array()) {
	$idusuario_nuevo = $var_fila["id"];
	$username_nuevo = $var_fila["username"];
	//echo $idusuario_nuevo . " | Username:" . $username_nuevo;
	//exit();
	
	$claveaulavieja_consulta = "SELECT id, username, password FROM mdl_user_claves_old WHERE username='".$username_nuevo."'";
	//echo $claveaulavieja_consulta  . "<br>"; 
	$claveaulavieja_resultado = $obj_conexion->query($claveaulavieja_consulta);
	while ($clave_fila=$claveaulavieja_resultado->fetch_array()) {
		$clave_vieja = $clave_fila["password"];
	}
	
	//echo $idusuario_nuevo . " | Username:" . $username_nuevo . " | Clave:" . $clave_vieja;
	//exit();
	
	$queryUpdate = "UPDATE mdl_user SET password='".$clave_vieja."' WHERE id=".$idusuario_nuevo."";
	//echo $queryUpdate;
	//exit();
	
	$resultUpdate = mysqli_query($obj_conexion, $queryUpdate); 
	if($resultUpdate){
		echo "<strong>Actualizado  ".$username_nuevo." con exito</strong>. <br>";
	} else {
		echo "No se pudo actualizar el registro. <br>";
    }

}
/*
$conexion = mysql_pconnect('172.16.15.253', 'useraulavibero', '8qGnku%Q+g$me');
if(! $conexion){
	echo "No se pudo conectar con la base de datos";
	exit;
}// make foo the current db
$db_selected = mysql_select_db("aulavirtual_2020", $conexion);
if (!$db_selected) {
	die ("Can\’t use foo : " . mysql_error());
}

$usuariosnuevos = mysql_query("SELECT id, username FROM mdl_user WHERE password='restored' ORDER BY id ASC LIMIT 1", $conexion);

while( $row = mysql_fetch_row($usuariosnuevos) ){
	$idusuario_nuevo = $row[0];
	$username_nuevo = $row[1];
	echo $idusuario_nuevo . " Username:" . $username_nuevo;
	
	exit();
	$datos_aulavieja = mysql_query("SELECT id, username, password FROM mdl_user_claves_old WHERE username='".$username_nuevo."'", $conexion);
	while( $row2 = mysql_fetch_row($datos_aulavieja) ){
		$clave_viaje = $row[0];
	}
	
	$update = mysql_query("UPDATE mdl_user SET password='".$clave_viaje."' WHERE id=".$idusuario_nuevo."", $conexion) or die ("Invalid query");
	echo $id . " | ";
}
*/
?>