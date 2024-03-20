<?php
function conectarDB(): mysqli{ //:va a retornar una conexion de mysqli
    //host, username, password, dbname
    $db = new mysqli(
        $_ENV['DB_HOST'], 
        $_ENV['DB_USER'], 
        $_ENV['DB_PASS'], 
        $_ENV['DB_NAME']
    );
    $db->set_charset('utf8');
    
    if(!$db){
        echo("Error no se pudo conectar");
        exit; //hace que las siguientes lineas no se ejecuten
    }
    /*codigo para crear un usuario*/
    // $email = "admin@correo.com";
    // $password = "123456";
    // $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    // // var_dump($passwordHash);
    // //query para crear el usuario
    // $query = " INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash'); ";
    // // echo $query;

    // mysqli_query($db, $query);
    /*Termina creación de usuario */
    return $db;
}   