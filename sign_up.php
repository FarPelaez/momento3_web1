<?php

    $myArray = array('!','@',"#",'$','%','&','?','¿','¡');
    function passValidation($var,$specialCharacters){
        $count = 0;
        for ($x = 0; $x < strlen($var); $x++){
            for ($y = 0; $y < count($specialCharacters); $y++){
                if ($var[$x] == $specialCharacters[$y]){
                    $count = $count + 1;
                }
            }
        }
        return $count;
    }

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'POST') {
        include_once('db_connection.php');
        
        $request = file_get_contents('php://input');
        $data = json_decode($request);
        $name = "";
        $lastname = "";
        $email = "";
        $type_id = "";
        $identification = "";
        $user_password = "";

        if (isset($data->name) && isset($data->lastname) && isset($data->email) && isset($data->type_id) && isset($data->identification) && isset($data->user_password)){
            $name = $data->name;
            $lastname= $data->lastname;
            $email = $data->email;
            $type_id = $data->type_id;
            $identification = $data->identification;
            $user_password = $data->user_password;

            if ($name ==  "" || $lastname == "" || $email == "" || $type_id == "" || $identification == "" || $user_password == "" ){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Empty Fields', 'Message'=>'Fields cannot be empty, please try again'))));
            } 
            elseif (strlen($name) > 40){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid length', 'Message'=>'Field Name cannot be more than 40 characters length, please try again'))));
            }
            elseif (!ctype_alpha($name)){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid format', 'Message'=>'Field Name only allows Alphabethic characters, please try again'))));
            }
            elseif (strlen($lastname) > 40){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid length', 'Message'=>'Field Lastname cannot be more than 40 characters length, please try again'))));
            }
            elseif (!ctype_alpha($lastname)){ 
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid format', 'Message'=>'Field Lastname only allows Alphabethic characters, please try again'))));
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid format', 'Message'=>'Email format invalid, please try again'))));
            }
            elseif ($type_id !== "PS" && $type_id !== "ps" && $type_id !== "CC" && $type_id !== "cc"){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid field', 'Message'=>'Field TypeID must be a CC(Cedula) or a PS(Pasaporte), please try again'))));
            }
            elseif ($type_id == "PS" && strlen($identification) > 10){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid length', 'Message'=>'Field Id cannot be more than 10 characters length, please try again'))));
            }
            elseif ($type_id == "CC" && !ctype_digit($identification)){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid format', 'Message'=>'Field Id only allows Numeric characters, please try again'))));
            }
            elseif (strlen($user_password) <= 8  || strlen($user_password) >= 16){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid length', 'Message'=>'Field Password must be between 6 and 16 characters length, please try again'))));
            }
            elseif (passValidation($user_password,$myArray) < 2){
                echo json_encode(array('Res'=>array('Success'=>false, 'Data'=> '', 'Error'=>array('Title'=>'Invalid password', 'Message'=>'Field Password must have at least two special characters (¡@#$%&?¡¿), please try again'))));
            }
            else {
                $sql = "INSERT INTO user (name, lastname, email, type_id, identification, password) VALUES ('{$name}', '{$lastname}', '{$email}', '{$type_id}', '{$identification}', '{$user_password}')";
                $result = $conn->query($sql);

                echo json_encode(array('Res'=>array('Success'=>true, 'Data'=>array('Name'=>$name, 'Lastname'=>$lastname, 'Email'=>$email, 'TypeId'=>$type_id, 'Identification'=>$identification, 'Password'=>$user_password), 'Error'=>array('Title'=>'', 'Message'=>''))));  
            }
        }
    }
?>