<?php

function conectarDB() : mysqli {
  $db = mysqli_connect('127.0.0.1', 'root', 'root', 'BienesRaicesJuan');

  if(!$db) {
    echo "Error, no se pudo establecer la conexion";
    exit;
  }

  return $db;
}
