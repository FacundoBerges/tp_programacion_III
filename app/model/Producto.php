<?php

require_once("./database/DataAccessObject.php");

class Producto
{
  public $id;
  public $nombre;
  public $tipo;


  public function crearProducto()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("INSERT INTO productos (nombre, tipo) VALUES (:nombre, :tipo)");

    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
    $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);

    $consulta->execute();


    return $dataAccessObject->getLastInsertedId();
  }

  public static function obtenerTodos()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, nombre, tipo FROM productos");
    $consulta->execute();


    return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
  }

  public static function obtenerProducto($producto)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, nombre, tipo FROM productos WHERE nombre = :nombre");

    $consulta->bindValue(':nombre', $producto, PDO::PARAM_STR);

    $consulta->execute();

    return $consulta->fetchObject('Producto');
  }

  public function modificarProducto()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE productos SET nombre = :nombre, tipo = :tipo WHERE id = :id");


    $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
    $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);

    $consulta->execute();
  }

  public static function borrarProducto($producto)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");

    $fecha = new DateTime(date("d-m-Y"));

    $consulta->bindValue(':id', $producto, PDO::PARAM_INT);
    $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

    $consulta->execute();
  }
}
