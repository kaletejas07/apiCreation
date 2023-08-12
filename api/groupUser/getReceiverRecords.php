<?php
header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();


// remember to set the variable to GET on postman. 
if($_SERVER['REQUEST_METHOD']=='GET'){

    //including the db operation file
    require_once '../../includes/GroupUserDbOperation.php';

    $db = new GroupUserDbOperation();
	
    // $data = json_decode(file_get_contents("php://input"));
    $userId = $_GET['userId'];

    if($db->getReceiverRecords($userId)){
        $res = $db->getReceiverRecords($userId);
        $response['error']=false;
        $response['message']="User's record(s) Exist(s)";
        $response['result']=json_decode($res);
        // echo "connect success! ";
    }else{
        $response['error']=true;
        $response['message']="No user's record(s) exist(s)";
        $response['result']=[];
        // echo 'No connect success';
    }

}else{
    $response['error']=true;
    $response['message']="You are not authorized";
    // echo 'You are not authorized';
}
echo json_encode($response);
