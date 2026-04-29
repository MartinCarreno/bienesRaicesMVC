<?php

function conectarDB(): mysqli {
    $db = new mysqli('localhost:3306', 'root', 'admin', 'bienesraices_crud');

    if(!$db) {
        echo "Error, no se pudo conectar";
        exit;
    }

    return $db;
}