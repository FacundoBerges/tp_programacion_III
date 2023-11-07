<?php

require_once("./interface/IApiUsable.php");
require_once("./model/Producto.php");
require_once("./model/TipoProducto.php");

class ProductoController implements IApiUsable
{
  public function getOne($request, $response, $args)
  {
    $producto = new Producto();
    $producto->id = $args["id"];

    $productoRetorno = Producto::obtenerProducto($producto->id);

    if ($productoRetorno) {
      $tipoProducto = TipoProducto::obtenerTipoPorId($productoRetorno->tipo);
      $sector = Sector::obtenerTipoPorId($productoRetorno->sector);

      $productoRetorno->tipo = $tipoProducto->tipo;
      $productoRetorno->sector = $sector->nombre;

      $payload = json_encode($productoRetorno);
    } else {
      $payload = json_encode(['error' => 'No se encontro el producto.']);
    }


    $response->getBody()->write($payload);


    return $response->withHeader('Content-Type', 'application/json');
  }

  public function getAll($request, $response, $args)
  {
    $listaProductos = Producto::obtenerTodos();

    foreach ($listaProductos as $producto) {
      $tipoProducto = TipoProducto::obtenerTipoPorId($producto->tipo);
      $sector = Sector::obtenerTipoPorId($producto->sector);

      $producto->tipo = $tipoProducto->tipo;
      $producto->sector = $sector->nombre;
    }

    if (count($listaProductos)) {
      $payload = json_encode(['listaProductos' => $listaProductos]);
    } else {
      $payload = json_encode(['listaProductos' => $listaProductos, 'mensaje' => 'No hay productos que mostrar.']);
    }


    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
  }

  public function save($request, $response, $args)
  {
    $params = $request->getParsedBody();

    $producto = new Producto();
    $producto->nombre = $params["nombre"];
    $producto->precio = $params["precio"];
    $producto->tipo = $params["tipo"];
    $producto->sector = $params["sector"];

    var_dump($params);

    if (is_null($producto->nombre) || is_null($producto->precio) || is_null($producto->tipo) || is_null($producto->sector)) {
      $payload = json_encode(['error' => 'Faltan datos.']);
    } else {
      if (!TipoProducto::tipoProductoValido($producto->tipo)) {
        $payload = json_encode(['error' => 'Tipo de producto invalido.']);
      } else if (!is_numeric($producto->precio)) {
        $payload = json_encode(['error' => 'Precio invalido.']);
      } else {
        if (!is_numeric($producto->tipo)) {
          $tipoToLower = strtolower($producto->tipo);
          $tipoProducto = TipoProducto::obtenerTipoPorNombre($tipoToLower);
          $producto->tipo = $tipoProducto->id;
        }
        if (!is_numeric($producto->sector)) {
          $tipoToLower = strtolower($producto->sector);
          $sector = Sector::obtenerTipoPorNombre($tipoToLower);
          $producto->sector = $sector->id;
        }

        $id = $producto->crearProducto();

        $payload = json_encode(['mensaje' => 'Producto creado con exito!', 'id' => $id]);
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
