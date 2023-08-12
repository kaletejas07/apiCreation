<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
if($_SERVER['REQUEST_METHOD']=='POST'){
	
	// we have to explicity define all our variables.
	// this works!

    $data = json_decode(file_get_contents("php://input"));
	$genericId = $data->genericId;//$_POST['name'] ?? '-';
	$messageType = $data->messageType;//$_POST['email'] ?? '-';
	$messageTemplate = $data->messageTemplate;//$_POST['password'] ?? '-';
	// $Phone = $data->phone;//$_POST['phone'] ?? '-';
    // $currency = $data->currency??'USD';
    // $language = $data->language??'English';
    // echo $data;
    // echo $data;
    // echo $data;
    //including the db operation file
    require_once '../../includes/MessageDbOperation.php';

    $db = new MessageDbOperation();
	
    if($db->createMessage($genericId, $messageTemplate, $messageType)){
		// echo "made it here!";
        $response['error']=false;
        $c = "Message added successfully";
        $response['message']= "$c";
    }else{

        $response['error']=true;
        $response['message']='Could not add message';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);
