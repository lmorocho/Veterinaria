<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['ID_Rol'] != 4) {
  header("Location: login_cliente.php");
  exit;
}
