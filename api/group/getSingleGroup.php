<?php
header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();


// remember to set the variable to GET on postman. 
if($_SERVER['REQUEST_METHOD']=='GET'){

    //including the db operation file
    require_once '../../includes/GroupDbOperation.php';

    $db = new GroupDbOperation();
	
    // $data = json_decode(file_get_contents("php://input"));
    $groupId = $_GET['groupId'];

    if($db->getGroupOnId($groupId)){
        $res = $db->getGroupOnId($groupId);
        $response['error']=false;
        $response['message']="Group Exists";
        $response['result']=json_decode($res);
        // echo "connect success! ";
    }else{
        $response['error']=true;
        $response['message']="No group exists";
        $response['result']=[];
        // echo 'No connect success';
    }

}else{
    $response['error']=true;
    $response['message']="You are not authorized";
    // echo 'You are not authorized';
}
echo json_encode($response);
