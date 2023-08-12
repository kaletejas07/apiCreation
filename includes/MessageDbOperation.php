<?php

class MessageDbOperation
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


    public function createMessage($genericId, $messageTemplate, $messageType)
    {
        $createStmt = "create table if not exists message(messageid int not null primary key auto_increment, genericid varchar(50) not null, template varchar(32765) not null, messagetype varchar(20) not null,
        created_at datetime not null, updated_at datetime not null )";
        $stmt = $this->conn->prepare($createStmt);
        $result = $stmt->execute();
        if($result){
            $sqlstatement = "insert into message (genericid, template, messagetype, created_at, updated_at) values (?,?,?,?,?)";
            $stmt = $this->conn->prepare($sqlstatement);
            $created_at = date("Y-m-d H:i:s");
            $updated_at	= date("Y-m-d H:i:s");
		    $stmt->bind_param('sssss', $genericId, $messageTemplate, $messageType, $created_at, $updated_at);
		
            $resultInsert = $stmt->execute();
            $stmt->close();
        }else{
            return false;
        }
        if ($resultInsert) {
            return true;
        } else {
            return false;
        }
    }

    public function getMessageInGenericId($genericId)
    {
		$stmt = "select * from message where genericId = '".$genericId."'";
		
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

    public function updateMessage($genericId, $messageTemplate){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update message set template = '".$messageTemplate."' , updated_at = '".$updated_at."' where genericid = '".$genericId."'";
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

    public function updateMessageType($genericId, $messageType){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update message set messagetype = '".$messageType."' , updated_at = '".$updated_at."' where genericid = '".$genericId."'";
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


}