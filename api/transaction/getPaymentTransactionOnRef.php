<?php
header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();


// remember to set the variable to GET on postman. 
if($_SERVER['REQUEST_METHOD']=='GET'){

    //including the db operation file
    require_once '../../includes/TransactionDbOperation.php';

    $db = new TransactionDbOperation();
	
    if(isset($_GET['referenceNumber']) && $_GET['referenceNumber']!=null){
        $referenceNumber = $_GET['referenceNumber'];

        if($db->getPaymentTransactionOnReferenceNumber($referenceNumber)){
            $res = $db->getPaymentTransactionOnReferenceNumber($referenceNumber);
            $response['error']=false;
            $response['message']="Payment Transaction Exists";
            $response['result']=json_decode($res);
            // echo "connect success! ";
        }else{
            $response['error']=true;
            $response['message']="No Payment Transaction exists";
            $response['result']=[];
            // echo 'No connect success';
        }
    }

}else{
    $response['error']=true;
    $response['message']="You are not authorized";
    // echo 'You are not authorized';
}
echo json_encode($response);
