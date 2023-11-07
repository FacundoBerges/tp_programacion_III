<?php

require_once("./database/DataAccessObject.php");

class TipoProducto
{
  public $id;
  public $tipo;


  public static function obtenerTodos()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id_tipo AS id, nombre_tipo AS tipo FROM tipos_productos");
    $consulta->execute();


    return $consulta->fetchAll(PDO::FETCH_CLASS, 'TipoProducto');
  }

  public static function obtenerTipoPorId($tipoProducto)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("SELECT id_tipo AS id, nombre_tipo AS tipo FROM tipos_productos WHERE id_tipo = :id");

    $consulta->bindValue(':id', $tipoProducto, PDO::PARAM_INT);

    $consulta->execute();

    return $consulta->fetchObject('TipoProducto');
  }

  public static function obtenerTipoPorNombre($tipoProducto)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("SELECT id_tipo AS id, nombre_tipo AS tipo FROM tipos_productos WHERE nombre_tipo = :tipo");

    $consulta->bindValue(':tipo', $tipoProducto, PDO::PARAM_STR);

    $consulta->execute();

    return $consulta->fetchObject('TipoProducto');
  }

  public static function tipoProductoValido($nombreTipoProducto)
  {
    $nombreTipo = strtolower($nombreTipoProducto);
    $listaTipos = TipoProducto::obtenerTodos();

    foreach ($listaTipos as $tipo) {
      if (strtolower($tipo->tipo) == $nombreTipo) {
        return true;
      }
    }

    return false;
  }
}
