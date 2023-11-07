<?php

require_once("./database/DataAccessObject.php");

class Mesa
{
  public $id;
  public $idPedido;


  public function crearMesa()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("INSERT INTO mesas (id_pedido) VALUES (:idPedido)");

    $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_STR);

    $consulta->execute();


    return $dataAccessObject->getLastInsertedId();
  }

  public static function obtenerTodos()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, id_pedido FROM mesas");
    $consulta->execute();


    return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
  }

  public static function obtenerMesa($mesa)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, id_pedido FROM mesas WHERE id_pedido = :idPedido");

    $consulta->bindValue(':idPedido', $mesa, PDO::PARAM_STR);

    $consulta->execute();

    return $consulta->fetchObject('Mesa');
  }

  public function modificarMesa()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE mesas SET id_pedido = :idPedido WHERE id = :id");


    $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
    $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_STR);

    $consulta->execute();
  }

  public static function borrarMesa($mesa)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE mesas SET fechaBaja = :fechaBaja WHERE id = :id");

    $fecha = new DateTime(date("d-m-Y"));

    $consulta->bindValue(':id', $mesa, PDO::PARAM_INT);
    $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

    $consulta->execute();
  }
}
