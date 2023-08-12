<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
if($_SERVER['REQUEST_METHOD']=='POST'){
	
	// we have to explicity define all our variables.
	// this works!

    $request = json_decode(file_get_contents("php://input"));
    $groupid = $request->groupId;
    $name = $request->name;
    $splittype = $request->splitType;
    $paymentdeadline = date_format(date_create($request->paymentDeadline),'Y-m-d H:i:s');
    // $paymentdeadline = date("d-m-Y", strtotime($request->paymentDeadline));
    // $paymentdeadline = datetime.strptime(request.json['paymentDeadline'],'%Y-%m-%d %H:%M:%S').strftime('%Y-%m-%d %H:%M:%S');
    $grouppaymentdone = $request->groupPaymentDone;
    $displayname = $request->displayName;
    $currency = isset($request->currency)?$request->currency:"USD";
    // $created_at = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    // $updated_at = created_at

    //including the db operation file
    require_once '../../includes/GroupDbOperation.php';

    $db = new GroupDbOperation();
	
    if($db->createGroup($groupid, $name, $splittype, $paymentdeadline, $grouppaymentdone, $displayname,$currency)){
		// echo "made it here!";
        $response['error']=false;
        $c = $groupid." Group added successfully";
        $response['message']= "$c";
    }else{

        $response['error']=true;
        $response['message']='Could not add Group';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);
