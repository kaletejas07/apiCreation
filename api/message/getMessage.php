<?php
header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();


// remember to set the variable to GET on postman. 
if($_SERVER['REQUEST_METHOD']=='GET'){

    //including the db operation file
    require_once '../../includes/MessageDbOperation.php';

    $db = new MessageDbOperation();
	
    // $data = json_decode(file_get_contents("php://input"));
    $genericId = $_GET['genericId'];

    if($db->getMessageInGenericId($genericId)){
        $res = $db->getMessageInGenericId($genericId);
        $response['error']=false;
        $response['message']="Message Exists";
        $response['result']=json_decode($res);
        // echo "connect success! ";
    }else{
        $response['error']=true;
        $response['message']="No message exists";
        $response['result']=[];
        // echo 'No connect success';
    }

}else{
    $response['error']=true;
    $response['message']="You are not authorized";
    // echo 'You are not authorized';
}
echo json_encode($response);
