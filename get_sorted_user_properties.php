<?php
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'GET') {
        include_once('db_connection.php');
        $request = file_get_contents('php://input');
        $data = json_decode($request);
        $user_id = $data->user_id;

        if (isset($data->user_id)){
            $user_id = $data->user_id;
            if ($user_id == "") {
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Empty Field', 'Message'=>'Field UserID cannot be empty, please try again'))));
            }
            else {
                $sql = "SELECT * FROM property WHERE user_id={$user_id} ORDER BY price ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0){
                    while($row= $result->fetch_assoc()){
                        $property[] = $row;
                    }
                    echo json_encode(array('Res'=>array('Success'=>true, 'Data'=>$property, 'Error'=>array('Title'=>'', 'Message'=>''))));
                }
                else {
                    echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'No registers', 'Message'=>'There is no properties registered with that UserId, please try again'))));
                }
            } 
        }
    } 
    else {
        echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Unable DB', 'Message'=>'Unable to connect to the DB, please try again'))));
    }
?>