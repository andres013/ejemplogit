<?php
//  admin 				$2y$10$gzjHm1TeNEE4jj9LXB2VmupI7EERdD1.gXXe3VFXOPAGmpGyNhBO2
//  prueba.temporal 	$2y$10$KRz12gUeU6./wzGdpfEKhuxHu6Aqt0OoZj6wxutvGSpEHlHTTpKxK

$cons_usuario = 'root';
$cons_contra = '';
$cons_base_datos = 'iberov3';
$cons_equipo = 'localhost';

$obj_conexion =    mysqli_connect($cons_equipo, $cons_usuario, $cons_contra, $cons_base_datos);
if(!$obj_conexion){
	echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
} else {
	echo "<h3>Conexion Exitosa a base de datos</h3><hr><br>";
}

$usuariosnuevos_consulta= "SELECT id, username FROM mdl_user WHERE Pendiente='Si' ORDER BY id ASC LIMIT 10000";
$usuariosnuevos_resultado = $obj_conexion->query($usuariosnuevos_consulta);

while ($var_fila=$usuariosnuevos_resultado->fetch_array()) {
	$idusuario_nuevo = $var_fila["id"];
	$username_nuevo = $var_fila["username"];
	 //echo $idusuario_nuevo . " | Username:" . $username_nuevo;
	 //exit();
	
	$claveaulavieja_consulta = "SELECT id, username, password FROM mdl_user_aulavieja WHERE username='".$username_nuevo."'";
	//echo $claveaulavieja_consulta;

	$claveaulavieja_resultado = $obj_conexion->query($claveaulavieja_consulta);
	while ($clave_fila=$claveaulavieja_resultado->fetch_array()) {
		$clave_vieja = $clave_fila["password"];
	}
	
	$queryUpdate = "UPDATE mdl_user SET password='".$clave_vieja."' WHERE username='".$username_nuevo."'";
	//echo "<br>" . $queryUpdate ;
	$resultUpdate = mysqli_query($obj_conexion, $queryUpdate); 
	if($resultUpdate){
                echo "El username  ".$username_nuevo." se actualizó con la clave: ".$clave_vieja." <br>";
	} else {
                echo "No se pudo actualizar el registro. <br>";
        }


	
	$queryUpdate2 = "UPDATE mdl_user SET Pendiente='No' WHERE id='".$idusuario_nuevo."'";
	//echo "<br>" . $queryUpdate2; 
	$resultUpdate2 = mysqli_query($obj_conexion, $queryUpdate2);

}
?>
