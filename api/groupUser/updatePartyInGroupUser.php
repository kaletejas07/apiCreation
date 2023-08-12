<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
require_once '../../includes/GroupUserDbOperation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $data = json_decode(file_get_contents("php://input"));
	$transactionName = $data->transactionName;
    $groupId = $data->groupId;

    if(isset($data->senderId) && $data->senderId != null){
        $senderId = $data->senderId;
        $db = new GroupUserDbOperation();
        if($db->updateSenderId($groupId,$transactionName,$senderId)){
            $response['error']=false;
            $c = "Record updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update record';
        }
    }

    if(isset($data->receiverId) && $data->receiverId != null){
        $receiverId = $data->receiverId;
        $db = new GroupUserDbOperation();
        if($db->updateReceiverId($groupId,$transactionName,$receiverId)){
            $response['error']=false;
            $c = "Record updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update record';
        }
    }

    if(isset($data->transactionName) && $data->transactionName != null){
        $senderId = $data->transactionName;
        $db = new GroupUserDbOperation();
        if($db->updateTransactionName($groupId,$transactionName)){
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




