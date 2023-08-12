<?php

header("Content-Type: application/json; charset=UTF-8");
//creating response array
$response = array();

// this is how we can create a user into our database
if($_SERVER['REQUEST_METHOD']=='POST'){
	
	// we have to explicity define all our variables.
	// this works!

    $data = json_decode(file_get_contents("php://input"));
	$userName = $data->name;//$_POST['name'] ?? '-';
	$Email = $data->email;//$_POST['email'] ?? '-';
	$Password = $data->password;//$_POST['password'] ?? '-';
	$Phone = $data->phone;//$_POST['phone'] ?? '-';
    $currency = $data->currency??'USD';
    $language = $data->language??'English';

    //including the db operation file
    require_once '../../includes/UserDbOperation.php';

    $db = new UserDbOperation();
	
    //inserting values
    // $userName=mysql_real_escape_string($_post['Location']);
    if($db->createUser($userName, $Email, $Password, $Phone, $language, $currency)){
		// echo "made it here!";
        $response['error']=false;
        $c = $userName." User added successfully";
        $response['message']= "$c";
    }else{

        $response['error']=true;
        $response['message']='Could not add User';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);
