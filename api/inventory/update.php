<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/inventory.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Inventory($db);
    
    $data = json_decode(file_get_contents("php://input"));

    // Inventar verdier
    $item->id = $data->id;
    $item->uid = $data->uid;
    $item->name = $data->name;
    $item->location = $data->location;
    $item->status = $data->status;
    $item->weight = $data->weight;
    $item->size = $data->size;
    $item->content = $data->content;
    $item->image = $data->image;
    $item->comment = $data->comment;




    if($item->updateInventory()){
        echo json_encode("Inventory updated.");
    } else{
        echo json_encode("Inventory could not be updated");
    }

        