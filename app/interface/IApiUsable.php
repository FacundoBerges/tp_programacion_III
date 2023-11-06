<?php

interface IApiUsable
{
  public function getOne($request, $response, $args);
  public function getAll($request, $response, $args);
  public function save($request, $response, $args);
  public function delete($request, $response, $args);
  public function update($request, $response, $args);
}
