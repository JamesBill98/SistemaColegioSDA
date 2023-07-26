<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Alumnos{


	//implementamos nuestro constructor
public function __construct(){

} 
//metodo insertar regiustro
public function insertar($image,$name,$lastname,$email,$address,$phone,$c1_fullname,$c1_address,$c1_phone,$c1_note,$user_id,$team_id){
	$sql="INSERT INTO alumn (image,name,lastname,email,address,phone,c1_fullname,c1_address,c1_phone,c1_note,is_active,user_id)
	VALUES ('$image','$name','$lastname','$email','$address','$phone','$c1_fullname','$c1_address','$c1_phone','$c1_note','1','$user_id')";
	
    // Ejecuta la consulta SQL para obtener el ID del nuevo alumno y lo almacena en la variable $idalumno_new
	$idalumno_new=ejecutarConsulta_retornarID($sql);
	$sw=true;
	// Consulta SQL para asociar al nuevo alumno ($idalumno_new) con un equipo ($team_id) en la tabla alumn_team.
	$sql_detalle="INSERT INTO alumn_team (alumn_id, team_id) VALUES('$idalumno_new','$team_id')";

	ejecutarConsulta($sql_detalle) or $sw=false; 

	return $sw;

}

/**
 * Edita un registro de alumno en la base de datos con la información proporcionada.
 * @param int $id            ID del alumno que se desea editar.
 * @param string $image      Ruta o nombre del archivo de imagen del alumno.
 * @param string $name       Nombre del alumno.
 * @param string $lastname   Apellido del alumno.
 * @param string $email      Correo electrónico del alumno.
 * @param string $address    Dirección del alumno.
 * @param string $phone      Número de teléfono del alumno.
 * @param string $c1_fullname   Nombre completo del contacto 1 del alumno.
 * @param string $c1_address    Dirección del contacto 1 del alumno.
 * @param string $c1_phone      Número de teléfono del contacto 1 del alumno.
 * @param string $c1_note       Nota o descripción del contacto 1 del alumno.
 * @param int $user_id       ID del usuario relacionado con el alumno.
 */

public function editar($id,$image,$name,$lastname,$email,$address,$phone,$c1_fullname,$c1_address,$c1_phone,$c1_note,$user_id){
	$sql="UPDATE alumn SET image='$image',name='$name', lastname='$lastname',email='$email',address='$address',phone='$phone' ,c1_fullname='$c1_fullname', c1_address='$c1_address', c1_phone='$c1_phone',c1_note='$c1_note',user_id='$user_id'
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}
// Consulta SQL para actualizar la columna "condicion" a '0' (desactivado) para el alumno con el ID proporcionado.
public function desactivar($id){
	$sql="UPDATE alumn SET condicion='0' WHERE id='$id'";
	return ejecutarConsulta($sql);
}
public function activar($id){
	$sql="UPDATE alumn SET condicion='1' WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id){
// Ejecutar la consulta SQL y retornar el resultado.
	$sql="SELECT * FROM alumn WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar($user_id, $team_id){
	$sql="SELECT a.id,a.image,a.name,a.lastname,a.email,a.address,a.phone,a.c1_fullname,a.c1_address,a.c1_phone,a.c1_note, a.is_active, a.user_id FROM alumn a INNER JOIN alumn_team alt ON a.id=alt.alumn_id WHERE a.is_active=1 AND a.user_id='$user_id' AND alt.team_id='$team_id' ORDER BY a.id DESC ";
	return ejecutarConsulta($sql);
}

//Verifica si un alumno está asociado a un equipo específico.
public function verficar_alumno($user_id, $team_id){
	$sql="SELECT * FROM alumn a INNER JOIN alumn_team alt ON a.id=alt.alumn_id WHERE a.is_active=1 AND a.user_id='$user_id' AND alt.team_id='$team_id' ORDER BY a.id DESC ";
	return ejecutarConsultaSimpleFila($sql);
}
//Lista las calificaciones o resultados de un alumno específico en un equipo determinado.
public function listar_calif($user_id, $team_id){
	$sql="SELECT a.id AS idalumn,a.image,a.name,a.lastname,a.email,a.address,a.phone,a.c1_fullname,a.c1_address,a.c1_phone,a.c1_note, a.is_active, a.user_id FROM alumn a INNER JOIN alumn_team alt ON a.id=alt.alumn_id WHERE a.is_active=1 AND a.user_id='$user_id' AND alt.team_id='$team_id' ORDER BY a.id DESC ";
	return ejecutarConsulta($sql); 
}
//listar registros activos

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos unir con el ultimo registro de la tabla detalle_ingreso)

}
?>
