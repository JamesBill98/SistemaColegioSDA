<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Usuario{


//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
	$sql="INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion) VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen','1')";
	//return ejecutarConsulta($sql);
	$idusuarionew=ejecutarConsulta_retornarID($sql);
	$num_elementos=0;
	$sw=true;
	while ($num_elementos < count($permisos)) {

	$sql_detalle="INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES('$idusuarionew','$permisos[$num_elementos]')";

	ejecutarConsulta($sql_detalle) or $sw=false;

	$num_elementos=$num_elementos+1;
	}
	return $sw;
}

//Función para actualizar la información del usuario en la base de datos.
public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$imagen,$permisos){
	$sql="UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',cargo='$cargo',login='$login',imagen='$imagen' 
	WHERE idusuario='$idusuario'";
	ejecutarConsulta($sql);

	 //eliminar permisos asignados
	$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
	ejecutarConsulta($sqldel);

	//Bucle para procesar y manejar la matriz de permisos.
	$num_elementos=0;
	$sw=true;
	while ($num_elementos < count($permisos)) {

	//Consulta SQL para insertar una nueva relación de permisos de usuario en la base de datos.
	$sql_detalle="INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES('$idusuario','$permisos[$num_elementos]')";

	ejecutarConsulta($sql_detalle) or $sw=false;

	$num_elementos=$num_elementos+1;
	}
	return $sw;
}

//Función para editar o actualizar la contraseña de un usuario en la base de datos.
public function editar_clave($idusuario,$clave){
	$sql="UPDATE usuario SET clave='$clave' WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}

//Función para recuperar y mostrar la contraseña de un usuario de la base de datos.
public function mostrar_clave($idusuario){
	$sql="SELECT idusuario, clave FROM usuario WHERE idusuario='$idusuario'";
	return ejecutarConsultaSimpleFila($sql);
}

//Función para desactivar una cuenta de usuario en la base de datos.
public function desactivar($idusuario){
	$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}

//Función para activar una cuenta de usuario en la base de datos.
public function activar($idusuario){
	$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idusuario){
	$sql="SELECT * FROM usuario WHERE idusuario='$idusuario'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM usuario";
	return ejecutarConsulta($sql);
}

//metodo para listar permmisos marcados de un usuario especifico
public function listarmarcados($idusuario){
	$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}

//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
		$sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuario WHERE login='$login' AND clave='$clave' AND condicion='1'"; 
		return ejecutarConsulta($sql);  
    }
}

?>
