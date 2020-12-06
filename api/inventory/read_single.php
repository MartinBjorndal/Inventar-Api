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

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleInventory();

    if($item->name != null){
        // create array
        $emp_arr = array(
            "id"         => $item->id,
            "uid"        => $item->uid,
            "name"       => $item->name,
            "created" => $item->created,
            "location" => $item->location,
            "status"     => $item->status,
            "weight"       => $item->weight,
            "size"  => $item->size,
            "content"    => $item->content,
            "image"      => $item->image,
            "comment"  => $item->comment
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Inventory not found.");
    }
?>