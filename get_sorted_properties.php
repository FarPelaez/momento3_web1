<?php
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'GET') {
        include_once('db_connection.php');

        $sql = "SELECT * FROM property ORDER BY price ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            while($row= $result->fetch_assoc()){
                $property[] = $row;
            }
            echo json_encode(array('Res'=>array('Success'=>true, 'Data'=>$property, 'Error'=>array('Title'=>'', 'Message'=>''))));
        }
    } 
    else {
        echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Unable DB', 'Message'=>'Unable to connect to the DB, please try again'))));
    }
?>