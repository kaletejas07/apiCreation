<?php

class GroupUserDbOperation
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

    // create a new record in the group user table, which is a new entry for each transaction of the group
    public function createGroupUser($groupId, $userId, $paymentCompleted, $paymentAmount, $sender, $receiver)
    {

        $createStmt = "create table if not exists group_user(
            ID int not null primary key auto_increment, paymentcompleted boolean not null, userid int not null, foreign key (userid) references user(ID), groupid varchar(30) not null, foreign key (groupid) references split_group(groupid), created_at datetime not null, updated_at datetime not null, paymentamount decimal(10,2) not null, sender int not null, foreign key (sender) references user(ID), receiver int not null, foreign key (receiver) references user(ID), transactionname varchar(30) not null, referencenumber varchar(50)  
            )";
        $stmt = $this->conn->prepare($createStmt);
        $result = $stmt->execute();
        if($result){
            $sqlstatement = "insert into group_user (groupid,userid,paymentcompleted,paymentamount,sender, receiver, created_at,updated_at) values (?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sqlstatement);
            $created_at = date("Y-m-d H:i:s");
            $updated_at	= date("Y-m-d H:i:s");
            $stmt->bind_param('ssssssss', $groupId, $userId, $paymentCompleted, $paymentAmount, $sender, $receiver, $created_at, $updated_at);
            
            $resultInsert = $stmt->execute();
            $stmt->close();
        }else{
            return false;
        }
        
        // $sqlstatement = "insert into group_user (groupid,userid,paymentcompleted,paymentamount,sender, receiver, created_at,updated_at) values (?,?,?,?,?,?,?,?)";
        // $stmt = $this->conn->prepare($sqlstatement);
		
		// // bind params will tell us what we put into 
		// $created_at = date("Y-m-d H:i:s");
        // $updated_at	= date("Y-m-d H:i:s");
		// $stmt->bind_param('ssssssss', $groupId, $userId, $paymentCompleted, $paymentAmount, $sender, $receiver, $created_at, $updated_at);
		
        // $result = $stmt->execute();
        // $stmt->close();

        if ($resultInsert) {
            return true;
        } else {
            return false;
        }
    }

    //get the records for a particular group id, all set of records/transactions belonging to a group
    public function getUsersForGroupOnId($groupId)
    {
        $stmt = "select * from group_user where groupid = '".$groupId."'";
		
		$result = $this->conn->query($stmt);
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		// print_r($result);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        // print_r($rows);
		return json_encode($rows);
    }


    // get all the group details which are created by a particular user
    public function getGroupsForUserOnId($userId)
    {
        $stmt = "select * from group_user where userid = '".$userId."'";
		
		$result = $this->conn->query($stmt);
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		// print_r($result);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        // print_r($rows);
		return json_encode($rows);
    }

    // get all record/transaction details where the user is the sender party in the transaction
    public function getSenderRecords($userId)
    {
        $stmt = "select * from group_user where sender = '".$userId."'";
		
		$result = $this->conn->query($stmt);
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		// print_r($result);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        // print_r($rows);
		return json_encode($rows);
    }

    // get all record/transaction details where the user is the receiver party in the transaction
    public function getReceiverRecords($userId)
    {
        $stmt = "select * from group_user where receiver = '".$userId."'";
		
		$result = $this->conn->query($stmt);
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		// print_r($result);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        // print_r($rows);
		return json_encode($rows);
    }

    // update the details of the sender party for a particular group and a transaction of that group
    public function updateSenderId($groupId, $transactionName,$senderId){

        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update group_user set sender = '".$senderId."' , updated_at = '".$updated_at."' where groupId = '".$groupId."' and transactionname = '".$transactionName."' ";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // update the details of the receiver party for a particular group and a transaction of that group
    public function updateReceiverId($groupId, $transactionName,$receiverId)
    {
        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update group_user set receiver = '".$receiverId."' , updated_at = '".$updated_at."' where groupId = '".$groupId."' and transactionname = '".$transactionName."' ";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // update the transaction name given the party details and group id of the transaction as there can be same transaction names in a group
    public function updateTransactionName($groupId, $transactionName, $sender, $receiver)
    {
        // date_default_timezone_set('');
        $updated_at	= date("Y-m-d H:i:s");
        $sqlstatement = "update group_user set transactionname = '".$transactionName."' , updated_at = '".$updated_at."' where groupId = '".$groupId."' and sender = '".$sender."' and receiver = '".$receiver."'";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //get all transaction records in a particular group given the transaction name
    public function getTransactionRecords($transactionName, $groupId)
    {
        $stmt = "select * from group_user where transactionname = '".$transactionName."' and groupId = '".$groupId."'";
		
		$result = $this->conn->query($stmt);
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		// print_r($result);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        // print_r($rows);
		return json_encode($rows);
    }

    //get all transaction records of a particular receiver for a particular group
    public function getReceiverRecordsForGroup($userId,$groupId)
    {
        $stmt = "select * from group_user where receiver = '".$userId."' and groupId = '".$groupId."'";
		
		$result = $this->conn->query($stmt);
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		// print_r($result);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        // print_r($rows);
		return json_encode($rows);
    }

    //get all transaction records of a particular sender for a particular group
    public function getSenderRecordsForGroup($userId,$groupId)
    {
        $stmt = "select * from group_user where sender = '".$userId."' and groupId = '".$groupId."'";
		
		$result = $this->conn->query($stmt);
		
		if(mysqli_num_rows($result) == 0) {
			return false; // query failed
		}
		// print_r($result);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        // print_r($rows);
		return json_encode($rows);
    }

}

?>