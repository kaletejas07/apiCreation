<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
require_once '../../includes/MessageDbOperation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $data = json_decode(file_get_contents("php://input"));
	$genericId = $data->genericId;

    if(isset($data->messageTemplate) && $data->messageTemplate != null){
        $messageTemplate = $data->messageTemplate;
        $db = new MessageDbOperation();
        if($db->updateMessage($genericId, $messageTemplate)){
            $response['error']=false;
            $c = "Message updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update message';
        }
    }
    
	echo json_encode($response);
	
	// $Password = $_REQUEST['password'] ?? '';
	// $Phone = $data->phone;//$_POST['phone'] ?? '-';
    // $currency = $data->currency??'USD';
    // $language = $data->language??'English';

}


