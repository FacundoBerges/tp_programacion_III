<?php

require_once("./database/DataAccessObject.php");

class TipoUsuario
{
  public $id;
  public $tipo;


  public static function obtenerTodos()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id_tipo_usuario AS id, nombre_tipo_usuario AS tipo FROM tipos_usuarios");
    $consulta->execute();


    return $consulta->fetchAll(PDO::FETCH_CLASS, 'TipoUsuario');
  }

  public static function obtenerTipoPorId($tipoUsuario)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("SELECT id_tipo_usuario AS id, nombre_tipo_usuario AS tipo FROM tipos_usuarios WHERE id_tipo_usuario = :id");

    $consulta->bindValue(':id', $tipoUsuario, PDO::PARAM_INT);

    $consulta->execute();

    return $consulta->fetchObject('TipoUsuario');
  }

  public static function obtenerTipoPorNombre($tipoUsuario)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("SELECT id_tipo_usuario AS id, nombre_tipo_usuario AS tipo FROM tipos_usuarios WHERE nombre_tipo_usuario = :tipo");

    $consulta->bindValue(':tipo', $tipoUsuario, PDO::PARAM_STR);

    $consulta->execute();

    return $consulta->fetchObject('TipoUsuario');
  }

  public static function tipoUsuarioValido($nombreTipoUsuario)
  {
    $nombreTipo = strtolower($nombreTipoUsuario);
    $listaTipos = TipoUsuario::obtenerTodos();

    foreach ($listaTipos as $tipo) {
      if (strtolower($tipo->tipo) == $nombreTipo) {
        return true;
      }
    }

    return false;
  }
}
