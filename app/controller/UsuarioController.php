<?php

require_once("./interface/IApiUsable.php");
require_once("./model/Usuario.php");

class UsuarioController implements IApiUsable
{
  public function getOne($request, $response, $args)
  {
    $usuario = new Usuario();
    $usuario->id = $args["id"];

    $usuarioRetorno = Usuario::obtenerUsuario($usuario->id);

    if ($usuarioRetorno) {
      $tipoUsuario = TipoUsuario::obtenerTipoPorId($usuarioRetorno->tipo);
      $usuarioRetorno->tipo = $tipoUsuario->tipo;

      $payload = json_encode($usuarioRetorno);
    } else {
      $payload = json_encode(['error' => 'No se encontro el usuario.']);
    }


    $response->getBody()->write($payload);


    return $response->withHeader('Content-Type', 'application/json');
  }

  public function getAll($request, $response, $args)
  {
    $listaUsuarios = Usuario::obtenerTodos();

    foreach ($listaUsuarios as $usuario) {
      $tipoUsuario = TipoUsuario::obtenerTipoPorId($usuario->tipo);
      $usuario->tipo = $tipoUsuario->tipo;
    }

    if (count($listaUsuarios)) {
      $payload = json_encode(['listaUsuarios' => $listaUsuarios]);
    } else {
      $payload = json_encode(['listaUsuarios' => $listaUsuarios, 'mensaje' => 'No hay usuarios que mostrar.']);
    }


    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
  }

  public function save($request, $response, $args)
  {
    $params = $request->getParsedBody();

    $usuario = new Usuario();
    $usuario->usuario = $params["usuario"];
    $usuario->clave = $params["clave"];
    $usuario->tipo = $params["tipo"];


    if (is_null($usuario->usuario) || is_null($usuario->clave) || is_null($usuario->tipo)) {
      $payload = json_encode(['error' => 'Faltan datos.']);
    } else {
      if (!TipoUsuario::tipoUsuarioValido($usuario->tipo)) {
        $payload = json_encode(['error' => 'Tipo de usuario invalido.']);
      } else {
        if (!is_numeric($usuario->tipo)) {
          $tipoToLower = strtolower($usuario->tipo);
          $tipoUsuario = TipoUsuario::obtenerTipoPorNombre($tipoToLower);
          $usuario->tipo = $tipoUsuario->id;
        }

        $id = $usuario->crearUsuario();

        $payload = json_encode(['mensaje' => 'Usuario creado con exito!', 'id' => $id]);
      }
    }


    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
  }

  public function delete($request, $response, $args)
  {
  }

  public function update($request, $response, $args)
  {
  }
}
