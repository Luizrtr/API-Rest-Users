<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../tools/query.php';

    $database = new Database();
    $db = $database->getConnection();
    $item = new UseAuth($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->name = $data->name;
    $item->nameUser = $data->nameUser;
    $item->email = $data->email;
    $item->password = $data->password;
    $item->created = date('Y-m-d H:i:s');
    
    if($item->createUser()){
        return "Usuario Criado!";
    } else{
        return "Error ao criar o usuário!";
    }
?>