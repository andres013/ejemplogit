<?php
// Conectando, seleccionando la base de datos
if(!($link = mysql_connect("localhost", "root", ""))) {
    die("Error: No se pudo conectar");
	exit();
}

if(!mysql_select_db("carmen", $link)) {
    die("Error: No existe la base de datos");
	exit();
}
/*
// Estudiantes para generar faltantes
$consulta_estudiantes = 'SELECT e.id, e.codBanner FROM estudiantes AS e WHERE estado="" ORDER BY e.id ASC LIMIT 5000';
$resultado_estudiantes = mysql_query($consulta_estudiantes, $link); 
//echo $consulta_estudiantes . "<br />"; 
//exit();

if(!$resultado_estudiantes) {
	die("Error: no se pudo realizar la consulta de estudiantes");
	exit();
}

// Periodo más bado por estudiante
while($estudiante = mysql_fetch_assoc($resultado_estudiantes)) {
	$id=$estudiante['id'];
	$codEstudiante=$estudiante['codBanner'];
	// Materias vistas por estudiante
	$consulta_periodos = 'SELECT p.periodoinicio FROM estudiantesperiodos AS p WHERE p.Banner="'.$codEstudiante.'" ORDER BY p.periodoinicio ASC LIMIT 1;';
	$resultado_periodos = mysql_query($consulta_periodos, $link);
	//echo $consulta_periodos . "<br />";
	//exit();
	
	while($fila = mysql_fetch_assoc($resultado_periodos)) {
		$periodo= $fila['periodoinicio'];
		$insert = 'UPDATE estudiantes SET periodo="'.$periodo.'", estado="Ok" where codBanner="'.$codEstudiante.'";';
		echo $insert. "<br />";
		//exit();	
		$resultado = mysql_query($insert, $link); 
		// validacion periodo inicial - periodo en movimiento
	}
}

*/


// Estudiantes para generar faltantes
$consulta_estudiantes = 'SELECT e.id, e.codBanner, e.periodo FROM estudiantes AS e WHERE estado="" ORDER BY e.id ASC LIMIT 10000';
$resultado_estudiantes = mysql_query($consulta_estudiantes, $link); 
//echo $consulta_estudiantes . "<br />"; 
//exit();

if(!$resultado_estudiantes) {
	die("Error: no se pudo realizar la consulta de estudiantes");
	exit();
}

while($estudiante = mysql_fetch_assoc($resultado_estudiantes)) {
	$id=$estudiante['id'];
	$codEstudiante=$estudiante['codBanner'];
	$periodoinicio=$estudiante['periodo'];
	// Materias vistas por estudiante
	$consulta_periodos = 'SELECT distinct periodomovimiento FROM estudiantesperiodos WHERE Banner="'.$codEstudiante.'";';
	//echo $consulta_periodos . "<br />";
	//exit();
	$resultado_periodos = mysql_query($consulta_periodos, $link);
	
	if(!$resultado_periodos) {
		die("Error: no se pudo realizar la consulta periodos vistos");
		exit();
	}
	
	while($fila = mysql_fetch_assoc($resultado_periodos)) {
		$periodoenmovimiento= $fila['periodomovimiento'];
		// validacion periodo inicial - periodo en movimiento
		if ($periodoinicio == $periodoenmovimiento) {
			$update_estudianteperiodo = 'UPDATE estudiantes SET estado="OK" WHERE id='.$id.';';
			//echo $update_estudianteperiodo . "<br />";
			$resultado_update_estudianteperiodo = mysql_query($update_estudianteperiodo, $link); 
		} else if ($periodoinicio > $periodoenmovimiento) {
			$insert_periodo = 'INSERT INTO resultado (id, codBanner, periodoinicio, periodosdiferentes, observacion) VALUES (NULL, '.$codEstudiante.', "'.$periodoinicio.'", "'.$periodoenmovimiento.'", "Periodo inicial es mayor al periodo en movimiento");';
			//echo $insert_periodo . "<br />";
			//exit();
			$resultado_periodo = mysql_query($insert_periodo, $link); 
			$update_estudianteperiodo = 'UPDATE estudiantes SET estado="OK" WHERE id='.$id.';';
			//echo $update_estudianteperiodo . "<br />";
			$resultado_update_estudianteperiodo = mysql_query($update_estudianteperiodo, $link); 
		} else {
			$insert_periodo = 'INSERT INTO resultado (id, codBanner, periodoinicio, periodosdiferentes, observacion) VALUES (NULL, '.$codEstudiante.', "'.$periodoinicio.'", "'.$periodoenmovimiento.'", "");';
			echo $insert_periodo . "<br />";
			$resultado_periodo = mysql_query($insert_periodo, $link); 
			$update_estudianteperiodo = 'UPDATE estudiantes SET estado="OK" WHERE id='.$id.';';
			//echo $update_estudianteperiodo . "<br />";
			$resultado_update_estudianteperiodo = mysql_query($update_estudianteperiodo, $link); 

		}
		echo "analizado el ID: " . $id . "<br />";
		$periodoenmovimiento='';
		
	}
}


?>