<?php

require_once("./database/DataAccessObject.php");
require_once("./model/TipoUsuario.php");

class Usuario
{
  public $id;
  public $usuario;
  public $clave;
  public $tipo;


  public function crearUsuario()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();
    $consulta = $dataAccessObject->getStatement("INSERT INTO usuarios (usuario, clave, id_tipo, habilitado) VALUES (:usuario, :clave, :tipo, :habilitado)");

    $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);

    $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
    $consulta->bindValue(':clave', $claveHash, PDO::PARAM_STR);
    $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
    $consulta->bindValue(':habilitado', true, PDO::PARAM_BOOL);

    $consulta->execute();


    return $dataAccessObject->getLastInsertedId();
  }

  public static function obtenerTodos()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, usuario, clave, id_tipo AS tipo FROM usuarios");
    $consulta->execute();


    return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
  }

  public static function obtenerUsuario($usuario)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("SELECT id, usuario, clave, id_tipo AS tipo FROM usuarios WHERE id = :id");

    $consulta->bindValue(':id', $usuario, PDO::PARAM_INT);

    $consulta->execute();

    return $consulta->fetchObject('Usuario');
  }

  public function modificarUsuario()
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE usuarios SET usuario = :usuario, clave = :clave, id_tipo = :tipo WHERE id = :id");

    $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);

    $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
    $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
    $consulta->bindValue(':clave', $claveHash, PDO::PARAM_STR);
    $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);

    $consulta->execute();
  }

  public static function borrarUsuario($usuario)
  {
    $dataAccessObject = DataAccessObject::getAccessObject();

    $consulta = $dataAccessObject->getStatement("UPDATE usuarios SET habilitado = :habilitado, fecha_baja = :fechaBaja WHERE id = :id");

    $fecha = new DateTime(date("Y-m-d"));

    $consulta->bindValue(':id', $usuario, PDO::PARAM_INT);
    $consulta->bindValue(':habilitado', false, PDO::PARAM_BOOL);
    $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

    $consulta->execute();
  }
}
