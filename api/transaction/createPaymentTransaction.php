<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
if($_SERVER['REQUEST_METHOD']=='POST'){
	
    $request = json_decode(file_get_contents("php://input"));
    $groupuserid = $request->groupUserId;
    $transactionname = $request->transactionName;
    $processedby = $request->processedBy;
    $amount = $request->amount;
    $transactiondate = date_format(date_create($request->transactionDate),'Y-m-d H:i:s');
    $referencenumber = $request->referenceNumber;

    //including the db operation file
    require_once '../../includes/TransactionDbOperation.php';

    $db = new TransactionDbOperation();
	
    if($db->createTransaction($groupuserid,$transactionname,$processedby,$amount,$transactiondate,$referencenumber)){
		// echo "made it here!";
        $response['error']=false;
        $c = "Payment Transaction added successfully";
        $response['message']= "$c";
    }else{

        $response['error']=true;
        $response['message']='Could not add Payment Transaction';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);
