<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a group user into our database
if($_SERVER['REQUEST_METHOD']=='POST'){

    $data = json_decode(file_get_contents("php://input"));
	$groupId = $data->groupId;//$_POST['name'] ?? '-';
	$userId = $data->userId;//$_POST['email'] ?? '-';
	$paymentCompleted = $data->paymentCompleted;//$_POST['password'] ?? '-';
	$paymentAmount = $data->paymentAmount;//$_POST['phone'] ?? '-';
    $sender = $data->sender;
    $receiver = $data->receiver;

    //including the db operation file
    require_once '../../includes/GroupUserDbOperation.php';

    $db = new GroupUserDbOperation();
	
    //inserting values
    if($db->createGroupUser($groupId, $userId, $paymentCompleted, $paymentAmount, $sender, $receiver)){
		// echo "made it here!";
        $response['error']=false;
        $c =" Group User added successfully";
        $response['message']= "$c";
    }else{

        $response['error']=true;
        $response['message']='Could not add Group User';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);

?>