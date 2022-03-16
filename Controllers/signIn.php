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
    
    $item->login = $data->login;
    $item->password = $data->password;

    $key = '';
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];


    $item->SignIn();
    if($item->name != null){
        $payload = [
            'exp' => (new DateTime("now"))->getTimestamp(),
            'uid' => 1,
            'email' => $item->email,
        ];
        
        $header = json_encode($header);
        $payload = json_encode($payload);
        $header = base64_encode($header);
        $payload = base64_encode($payload);
        $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
        $sign = base64_encode($sign);
        //Token
        $token = $header . '.' . $payload . '.' . $sign;

        $emp_arr = array(
            "id" =>  $item->id,
            "name" => $item->name,
            "nameUser" => $item->nameUser,
            "email" => $item->email,
            "created" => $item->created,
            "token" => $token
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    } else{
        http_response_code(401);
        return "Usuário/senha incorreto!";
    }
?>