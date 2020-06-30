<?php
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'POST') {
        include_once('db_connection.php');
        
        $request = file_get_contents('php://input');
        $data = json_decode($request);
        $user_id = "";
        $title = "";
        $type = "";
        $address = "";
        $rooms = "";
        $price = "";
        $area = "";
        
        if(isset($data->user_id) && isset($data->title) && isset($data->type) && isset($data->address) && isset($data->rooms) && isset($data->price) && isset($data->area)){
            $user_id = $data->user_id;
            $title = $data->title;
            $type = $data->type;
            $address = $data->address;
            $rooms = $data->rooms;
            $price = $data->price;
            $area = $data->area;

            if ($user_id ==  "" || $title == "" || $type == "" || $address == "" || $rooms == "" || $price == "" || $area == "" ){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Empty Fields', 'Message'=>'Fields cannot be empty, please try again'))));
            }
            elseif (!ctype_digit($rooms) || !ctype_digit($price) || !ctype_digit($area)){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid format', 'Message'=>'Fields Rooms, Price and Area only allows numeric characters, please try again'))));
            } 
            else {
                $sql = "INSERT INTO property (user_id, title, type, address, rooms, price, area) VALUES ('{$user_id}', '{$title}', '{$type}', '{$address}', '{$rooms}', '{$price}', '{$area}')";
                $result = $conn->query($sql);

                echo json_encode(array('Res'=>array('Success'=>true, 'Data'=>array('UserId'=>$user_id, 'Title'=>$title, 'Type'=>$type, 'Address'=>$address, 'Rooms'=>$rooms, 'Price'=>$price, 'Area'=>$area), 'Error'=>array('Title'=>'', 'Message'=>''))));
            }
        } 
        else {
            echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Bad request', 'Message'=>'Bad request, try again'))));
        }
    }
?>