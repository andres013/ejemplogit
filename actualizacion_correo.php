<?php
//  admin 				$2y$10$gzjHm1TeNEE4jj9LXB2VmupI7EERdD1.gXXe3VFXOPAGmpGyNhBO2
//  prueba.temporal 	$2y$10$KRz12gUeU6./wzGdpfEKhuxHu6Aqt0OoZj6wxutvGSpEHlHTTpKxK

$cons_usuario = 'useraulavibero';
$cons_contra = '8qGnku%Q+g$me';
$cons_base_datos = 'aulavirtual_2020';
$cons_equipo = '172.16.15.253';
// 9654

$obj_conexion =    mysqli_connect($cons_equipo, $cons_usuario, $cons_contra, $cons_base_datos);
if(!$obj_conexion){
	echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
} else {
	echo "<h3>Conexion Exitosa PHP - MySQL</h3><hr><br>";
}

$usuariosnuevos_consulta= "SELECT id, idnumber FROM mdl_user WHERE email LIKE'%@iberoamericana.edu.co%' ORDER BY id ASC LIMIT 1";
$usuariosnuevos_resultado = $obj_conexion->query($usuariosnuevos_consulta);

while ($var_fila=$usuariosnuevos_resultado->fetch_array()) {
	$idusuario = $var_fila["id"];
	$idnumber = $var_fila["idnumber"];
	$email_mal = $var_fila["email"];
	echo $email_mal . " ";
	//exit();
	
	$correoibero='';
	$correoibero_consulta = "SELECT correo FROM mdl_user_correosibero WHERE idbanner='".$idnumber."'";
	$correoibero_resultado = $obj_conexion->query($correoibero_consulta );
	while ($clave_fila=$correoibero_resultado->fetch_array()) {
		$correoibero = $clave_fila["correo"];
	}
	echo $idusuario . " | Correo:" . $correoibero;
	//exit();
	if ($correoibero=='') {
		echo "No se pudo actualizar el registro. <br>";
	} else {
		$queryUpdate = "UPDATE mdl_user SET email='".$correoibero."' WHERE id=".$idusuario."";
		$resultUpdate = mysqli_query($obj_conexion, $queryUpdate);
		echo "<strong>El usuario ID ".$idusuario." con exito</strong>. <br>";
	}
}
?>