<?php
header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();


// remember to set the variable to GET on postman. 
if($_SERVER['REQUEST_METHOD']=='GET'){

    //including the db operation file
    require_once '../../includes/UserDbOperation.php';

    $db = new UserDbOperation();
	
    // $data = json_decode(file_get_contents("php://input"));
    $email = $_GET['email'];

    if($db->getUserOnEmail($email)){
        $res = $db->getUserOnEmail($email);
        $response['error']=false;
        $response['message']="User Exists";
        $response['result']=json_decode($res);
        // echo "connect success! ";
    }else{
        $response['error']=true;
        $response['message']="No user exists";
        $response['result']=[];
        // echo 'No connect success';
    }

}else{
    $response['error']=true;
    $response['message']="You are not authorized";
    // echo 'You are not authorized';
}
echo json_encode($response);
