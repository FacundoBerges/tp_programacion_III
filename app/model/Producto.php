<?php

require_once("./database/DataAccessObject.php");
require_once("./model/TipoProducto.php");
require_once("./model/Sector.php");

class Producto
{
  public $id;
  public $nombre;
  public $precio;
  public $tipo;
  public $sector;


  public function crearProducto()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("INSERT INTO productos (nombre, precio, id_tipo_producto, id_sector, disponible) VALUES (:nombre, :precio, :tipo, :sector, :disponible)");

    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
    $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
    $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
    $consulta->bindValue(':sector', $this->sector, PDO::PARAM_INT);
    $consulta->bindValue(':disponible', true, PDO::PARAM_BOOL);

    $consulta->execute();


    return $dataAccessObject->getLastInsertedId();
  }

  public static function obtenerTodos()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, nombre, precio, id_tipo_producto AS tipo, id_sector AS sector FROM productos");
    $consulta->execute();


    return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
  }

  public static function obtenerProducto($producto)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, nombre, precio, id_tipo_producto AS tipo, id_sector AS sector FROM productos WHERE id = :id");

    $consulta->bindValue(':id', $producto, PDO::PARAM_INT);

    $consulta->execute();

    return $consulta->fetchObject('Producto');
  }

  public function modificarProducto()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE productos SET nombre = :nombre, precio = :precio, id_tipo_producto = :tipo, id_sector = :sector WHERE id = :id");

    $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
    $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
    $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
    $consulta->bindValue(':sector', $this->sector, PDO::PARAM_INT);

    $consulta->execute();
  }

  public static function borrarProducto($producto)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE productos SET disponible = :disponible WHERE id = :id");


    $consulta->bindValue(':id', $producto, PDO::PARAM_INT);
    $consulta->bindValue(':disponible', false, PDO::PARAM_BOOL);

    $consulta->execute();
  }
}
