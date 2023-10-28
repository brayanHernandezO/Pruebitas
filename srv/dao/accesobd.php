<?php

namespace srv\dao;

require_once
 "srv/const/ROL_CLIENTE.php";
require_once
 "srv/const/ROL_ADMINISTRADOR.php";
require_once "srv/dao/bdCrea.php";
require_once
 "srv/dao/usuarioBuscaCue.php";
require_once
 "srv/dao/usuarioAgrega.php";
require_once
 "srv/dao/rolConsulta.php";
require_once
 "srv/dao/rolAgrega.php";
require_once "srv/txt/"
 . "txtAdministraElSistema.php";
require_once
 "srv/txt/txtRealizaCompras.php";


use \PDO;
use srv\modelo\Rol;
use srv\modelo\Usuario;

class AccesoBd
{

 private static ?PDO $con = null;

 static function getCon(): \PDO
 {
  if (self::$con === null) {
   self::$con = self::conecta();
   self::prepara(self::$con);
  }
  return self::$con;
 }

 private static
 function conecta(): \PDO
 {
  return new PDO(
   // cadena de conexión
   "sqlite:srvaut.db",
   // usuario
   null,
   // contraseña
   null,
   [PDO::ATTR_ERRMODE =>
   PDO::ERRMODE_EXCEPTION]
  );
 }

 private static
 function prepara(PDO $con)
 {
  bdCrea($con);
  $roles = rolConsulta();
  if (sizeof($roles) === 0) {

   $admin = new Rol();
   $admin->id = ROL_ADMINISTRADOR;
   $admin->descripcion =
    txtAdministraElSistema();
   rolAgrega($admin);

   $cliente = new Rol();
   $cliente->id = ROL_CLIENTE;
   $cliente->descripcion =
    txtRealizaCompras();
   rolAgrega($cliente);

   $usuario =
    usuarioBuscaCue("pepito");
   if (!$usuario) {
    $usuario = new Usuario();
    $usuario->cue = "pepito";
    $usuario->match = "cuentos";
    $usuario->roles = [$cliente];
    usuarioAgrega($usuario);
   }

   $usuario =
    usuarioBuscaCue("susana");
   if (!$usuario) {
    $usuario = new Usuario();
    $usuario->cue = "susana";
    $usuario->match = "alegria";
    $usuario->roles = [$admin];
    usuarioAgrega($usuario);
   }

   $usuario =
    usuarioBuscaCue("bebe");
   if (!$usuario) {
    $usuario = new Usuario();
    $usuario->cue = "bebe";
    $usuario->match = "saurio";
    $usuario->roles =
     [$admin, $cliente];
    usuarioAgrega($usuario);
   }
  }
 }
}