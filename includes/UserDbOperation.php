<?php

class UserDbOperation
{
    private $conn;

    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/Config.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function getUserOnEmail($email)
    {
		$stmt = "select * from user where email = '".$email."'";
		
		$result = $this->conn->query($stmt);
		
		// i want to get the information on query
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
		return json_encode($rows);
    }

    public function getUserOnPhone($phone)
    {
		$stmt = "select * from user where phone = '".$phone."'";
		
		$result = $this->conn->query($stmt);
		
		// i want to get the information on query
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
		return json_encode($rows);
    }



	
	// todo : implement encryption function for password and check for duplicates (see dc9 program)
	// make sure that you are following security practices here,
    public function createUser($username, $email, $password, $phone, $language, $currency)
    {
        // print_r($username);
        // print_r($email);
        // print_r($password);
        // print_r($phone);
        // $username1 = $this->conn->real_escape_string($username);
        // $email1 = $this->conn->real_escape_string($email);
        // $phone1 = $this->conn->real_escape_string($phone);
        // $password1 = $this->conn->real_escape_string($password);
        // $language = "English";
		// $sqlstatement = "insert into user (name, phone, email, password, language, created_at) values (?,?,?,?,?,?)";
        // $stmt = $this->conn->prepare($sqlstatement);

        // $stmt = $this->conn->prepare("insert into user (name, phone, email, password, language, created_at) values (?,?,?,?,?,?)");
        // $stmt->bind_param('ssssss', $username1, $phone1, $email1, $password1, $language, $created_at);

		// bind params will tell us what we put into 
		// $created_at = date("Y-m-d H:i:s");	
		// $stmt->bind_param('ssssss', $username1, $phone1, $email1, $password1, $language, $created_at);
		
        // $username1=htmlspecialchars(strip_tags($username));
        // $email1=htmlspecialchars(strip_tags($email));
        // $phone1=htmlspecialchars(strip_tags($phone));
        // $password1=htmlspecialchars(strip_tags($password));

        // $result = $stmt->execute();
        // $stmt->close();
		
        //===============================
        // below code already present
        // $sqlstatement = "insert into user(name, email, password, phone, created_at) VALUES (?, ?, ?, ?, ?)";
        // $stmt = $this->conn->prepare($sqlstatement);
		
		// // bind params will tell us what we put into 
		// $timestamp = date("Y-m-d H:i:s");	
		// $stmt->bind_param('sssss', $username, $email, $password, $phone, $timestamp);
		
        // $result = $stmt->execute();
        // $stmt->close();

		// // echo $result;
        // // echo $username;
        // if ($result) {
        //     return true;
        // } else {
        //     return false;
        // }
        //===============================

        // echo "hello again ".$us.".";



        $createStmt = "create table if not exists user (ID int not null primary key auto_increment, name varchar(50) not null, phone varchar(10) not null, email varchar(50) not null, language varchar(10) not null, currency varchar(10) not null, password varchar(16) not null, created_at datetime not null, updated_at datetime not null 
            )";
        $stmt = $this->conn->prepare($createStmt);
        $result = $stmt->execute();
        if($result){
            $sqlstatement = "insert into user (name, phone, email, password, currency, language, created_at, updated_at) values (?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sqlstatement);
            $created_at = date("Y-m-d H:i:s");
            $updated_at	= date("Y-m-d H:i:s");
		    $stmt->bind_param('ssssssss', $username, $phone, $email, $password,  $currency, $language, $created_at, $updated_at);
		
            $resultInsert = $stmt->execute();
            $stmt->close();
        }else{
            return false;
        }
        
        // $sqlstatement = "insert into user (name, phone, email, password, currency, language, created_at, updated_at) values (?,?,?,?,?,?,?,?)";
        // $stmt = $this->conn->prepare($sqlstatement);
		
		// // bind params will tell us what we put into 
		// $created_at = date("Y-m-d H:i:s");
        // $updated_at	= date("Y-m-d H:i:s");
		// $stmt->bind_param('ssssssss', $username, $phone, $email, $password,  $currency, $language, $created_at, $updated_at);
		
        // $result = $stmt->execute();
        // $stmt->close();

		// echo $result;
        // echo $username;
        if ($resultInsert) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserName($username, $email){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update user set name = '".$username."' , updated_at = '".$updated_at."' where email = '".$email."' ";
        $stmt = $this->conn->prepare($sqlstatement);
		
		// bind params will tell us what we put into 
		// $created_at = date("Y-m-d H:i:s");
		// $stmt->bind_param('ssssssss', $username, $phone, $email, $password,  $currency, $language, $created_at, $updated_at);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserPhone($userPhone, $email){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update user set phone = '".$userPhone."' , updated_at = '".$updated_at."' where email = '".$email."' ";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserLanguage($userLanguage, $email){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update user set language = '".$userLanguage."' , updated_at = '".$updated_at."' where email = '".$email."' ";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserPassword($userPassword, $email){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update user set password = '".$userPassword."' , updated_at = '".$updated_at."' where email = '".$email."' ";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserCurrency($userCurrency, $email){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update user set currency = '".$userCurrency."' , updated_at = '".$updated_at."' where email = '".$email."' ";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}