<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
require_once '../../includes/GroupUserDbOperation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $data = json_decode(file_get_contents("php://input"));
    $groupId = $data->groupId;
    $senderId = $data->senderId;
    $receiverId = $data->receiverId;

    if(isset($data->transactionName) && $data->transactionName != null){
        $transactionName = $data->transactionName;
        $db = new GroupUserDbOperation();
        if($db->updateTransactionName($groupId,$transactionName, $senderId, $receiverId)){
            $response['error']=false;
            $c = "Record updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update record';
        }
    }

    }
    
	echo json_encode($response);
	
	// $Password = $_REQUEST['password'] ?? '';
	// $Phone = $data->phone;//$_POST['phone'] ?? '-';
    // $currency = $data->currency??'USD';
    // $language = $data->language??'English';




