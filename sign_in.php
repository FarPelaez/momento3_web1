<?php
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'GET') {
        include_once('db_connection.php');
        $request = file_get_contents('php://input');
        $data = json_decode($request);
        $id = $data->id;
        $sql = "SELECT * FROM user WHERE identification={$id}";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            while($row= $result->fetch_assoc()){
                $user[] = $row;
            }
            echo json_encode(array('Res'=>array('Success'=>true, 'Data'=>$user, 'Error'=>array('Title'=>'', 'Message'=>''))));
        }
        else {
            echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid user', 'Message'=>'User does not exist, please Sign Up'))));
        }
    } else {
        echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Unable DB', 'Message'=>'Unable to connect to the DB, please try again'))));
    }
?>