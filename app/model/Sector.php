<?php

require_once("./database/DataAccessObject.php");

class Sector
{
  public $id;
  public $nombre;


  public static function obtenerTodos()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, nombre FROM sectores");
    $consulta->execute();


    return $consulta->fetchAll(PDO::FETCH_CLASS, 'Sector');
  }

  public static function obtenerTipoPorId($sector)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("SELECT id, nombre FROM sectores WHERE id = :id");

    $consulta->bindValue(':id', $sector, PDO::PARAM_INT);

    $consulta->execute();

    return $consulta->fetchObject('Sector');
  }

  public static function obtenerTipoPorNombre($sector)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("SELECT id, nombre FROM sectores WHERE nombre = :nombre");

    $consulta->bindValue(':nombre', $sector, PDO::PARAM_STR);

    $consulta->execute();

    return $consulta->fetchObject('Sector');
  }

  public static function tipoSectorValido($nombreSector)
  {
    $listaSectores = TipoProducto::obtenerTodos();

    foreach ($listaSectores as $sector) {
      if (strtolower($sector->nombre) == strtolower($nombreSector)) {
        return true;
      }
    }

    return false;
  }
}
