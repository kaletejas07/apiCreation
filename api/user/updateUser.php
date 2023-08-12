<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
require_once '../../includes/UserDbOperation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $data = json_decode(file_get_contents("php://input"));
	$Email = $data->email;

    if(isset($data->name) && $data->name != null){
        $userName = $data->name;
        $db = new UserDbOperation();
        if($db->updateUserName($userName, $Email)){
            $response['error']=false;
            $c = "User updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not add User';
        }
    }

    if(isset($data->phone) && $data->phone != null){
        $userPhone = $data->phone;
        $db = new UserDbOperation();
        if($db->updateUserPhone($userPhone, $Email)){
            $response['error']=false;
            $c = "User updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not add User';
        }
    }

    if(isset($data->currency) && $data->currency != null){
        $userCurrency = $data->currency;
        $db = new UserDbOperation();
        if($db->updateUserCurrency($userCurrency, $Email)){
            $response['error']=false;
            $c = "User updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not add User';
        }
    }
    if(isset($data->language) && $data->language != null){
        $userLanguage = $data->language;
        $db = new UserDbOperation();
        if($db->updateUserLanguage($userLanguage, $Email)){
            $response['error']=false;
            $c ="User updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not add User';
        }
    }
    if(isset($data->password) && $data->password != null){
        $userPassword = $data->password;
        $db = new UserDbOperation();
        if($db->updateUserPassword($userPassword, $Email)){
            $response['error']=false;
            $c ="User updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not add User';
        }
    }
    
	echo json_encode($response);
	
	// $Password = $_REQUEST['password'] ?? '';
	// $Phone = $data->phone;//$_POST['phone'] ?? '-';
    // $currency = $data->currency??'USD';
    // $language = $data->language??'English';

}


