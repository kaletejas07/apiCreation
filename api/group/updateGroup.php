<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
require_once '../../includes/GroupDbOperation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $data = json_decode(file_get_contents("php://input"));
	$groupId = $data->groupId;

    if(isset($data->paymentDeadline) && $data->paymentDeadline != null){
        $paymentdeadline = date_format(date_create($data->paymentDeadline),'Y-m-d H:i:s');
        $db = new GroupDbOperation();
        if($db->updatePaymentDeadline($paymentdeadline, $groupId)){
            $response['error']=false;
            $c = "Group updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update group';
        }
    }

    if(isset($data->groupPaymentDone) && $data->groupPaymentDone != null){
        $groupPaymentDone = $data->groupPaymentDone;
        $db = new GroupDbOperation();
        if($db->updateGroupPaymentDone($groupPaymentDone, $groupId)){
            $response['error']=false;
            $c = "Group updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update group';
        }
    }

    if(isset($data->displayName) && $data->displayName != null){
        $displayName = $data->displayName;
        $db = new GroupDbOperation();
        if($db->updateGroupDisplayName($displayName, $groupId)){
            $response['error']=false;
            $c = "Group updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update group';
        }
    }
    if(isset($data->currency) && $data->currency != null){
        $currency = $data->currency;
        $db = new GroupDbOperation();
        if($db->updateGroupCurrency($currency, $groupId)){
            $response['error']=false;
            $c ="Group updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update group';
        }
    }
    if(isset($data->splitType) && $data->splitType != null){
        $splittype = $data->splitType;
        $db = new GroupDbOperation();
        if($db->updateGroupSplitType($splittype, $groupId)){
            $response['error']=false;
            $c ="Group updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update group';
        }
    }
    if(isset($data->isDeleted) && $data->isDeleted != null){
        $isDeleted = $data->isDeleted;
        $db = new GroupDbOperation();
        if($db->updateGroupIsDeleted($isDeleted, $groupId)){
            $response['error']=false;
            $c ="Group updated successfully";
            $response['message']= "$c";
        }else{
    
            $response['error']=true;
            $response['message']='Could not update group';
        }
    }
	echo json_encode($response);
	
	// $Password = $_REQUEST['password'] ?? '';
	// $Phone = $data->phone;//$_POST['phone'] ?? '-';
    // $currency = $data->currency??'USD';
    // $language = $data->language??'English';

}

