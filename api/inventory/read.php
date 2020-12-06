<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../class/inventory.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Inventory($db);

    $stmt = $items->getInventory();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount);

    if($itemCount > 0){
        
        $inventory = array();
        $inventory["body"] = array();
        $inventory["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id"         => $invId,
                "uid"        => $invUid,
                "name"       => $invName,
                "created" => $invCreated,
                "location" => $invLocation,
                "status"     => $invStatus,
                "weight"       => $invWeight,
                "size"  => $invSize,
                "content"    => $invContent,
                "image"      => $invImage,
                "comment"  => $invComment
            );

            array_push($inventory["body"], $e);
        }
        echo json_encode($inventory);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>