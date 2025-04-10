<?php
//conexion a base de datos
include('inc/conexion.PHP');


//recibo datos por post

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
$rol = $_POST['rol'];
$boton = $_POST['boton'];


//Estructura de decisión.

if($boton==0){
  //modificamos mensaje y volvemos al formulario.
  header("Location: bdd.php");
}else{
  //Damos la baja

  $baja = "delete from usuario where usuario='$usuario'";
  $resultado_baja = mysqli_query($conexion,$baja);

  header("location:bdd.php");
  //cierro el formulario y recargo la pagina anterior.
  //echo "<script languaje='javascript' type='text/javascript'>window.opener.document.location.reload();self.close()</sript>";
  //echo "<script languaje='javascript' type='text/javascript'>window.close();</sript>";
}

?>
