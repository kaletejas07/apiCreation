<?php

class TransactionDbOperation
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

	
    public function createTransaction($groupuserid,$transactionname,$processedby,$amount,$transactiondate,$referencenumber)
    {

        $sql = "create table if not exists transaction(
            id int not null primary key auto_increment, transactiondate datetime, processedby varchar(30) not null, amount decimal(10,2) not null, groupuserid int not null, foreign key (groupuserid) references group_user(ID), transactionname varchar(30) not null, created_at datetime not null, updated_at datetime not null, referencenumber varchar(50) not null
            )";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute();

        if($result){
            $insert = "insert into transaction (groupuserid,transactionname,processedby,amount,transactiondate,referencenumber,created_at,updated_at) values (?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($insert);
            $created_at = date("Y-m-d H:i:s");
            $updated_at	= date("Y-m-d H:i:s");
		    $stmt->bind_param('ssssssss', $groupuserid, $transactionname, $processedby, $amount, $transactiondate, $referencenumber, $created_at, $updated_at);
            $result1 = $stmt->execute();
            $stmt->close();
        }
        
        if ($result1) {
            return true;
        } else {
            return false;
        }

        /*
        $sqlstatement = "insert into transaction (groupuserid,transactionname,processedby,amount,transactiondate,referencenumber,created_at,updated_at) values (?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sqlstatement);
		
		// bind params will tell us what we put into 
		$created_at = date("Y-m-d H:i:s");
        $updated_at	= date("Y-m-d H:i:s");
		$stmt->bind_param('ssssssss', $groupuserid, $transactionname, $processedby, $amount, $transactiondate, $referencenumber, $created_at, $updated_at);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }*/
    }

    public function getPaymentTransactionOnName($transactionname, $groupuserid)
    {
        // print_r($transactionname);
        // print_r($groupuserid);
		$stmt = "select * from transaction where groupuserid = '".$groupuserid."' and transactionname = '".$transactionname."' ";
		
		$result = $this->conn->query($stmt);
		
		// i want to get the information on query
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

    public function getPaymentTransactionOnReferenceNumber($referenceNumber)
    {
		$stmt = "select * from transaction where referencenumber = '".$referenceNumber."'";
		
		$result = $this->conn->query($stmt);
		
		// i want to get the information on query
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


    public function getGroupOnId($groupId)
    {
		$stmt = "select * from split_group where groupid = '".$groupId."'";
		
		$result = $this->conn->query($stmt);
		
		// i want to get the information on query
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

    public function updatePaymentDeadline($paymentdeadline, $groupId){

        $updated_at	= date("Y-m-d H:i:s");

        $sqlstatement = "update split_group set paymentdeadline = '".$paymentdeadline."' , updated_at = '".$updated_at."' where groupid = '".$groupId."'";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {    
            return false;
        }
    }

    public function updateGroupPaymentDone($groupPaymentDone, $groupId){

        $updated_at	= date("Y-m-d H:i:s");

        $sqlstatement = "update split_group set grouppaymentdone = '".$groupPaymentDone."' , updated_at = '".$updated_at."' where groupid = '".$groupId."'";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {    
            return false;
        }
    }

    public function updateGroupDisplayName($displayname, $groupId){

        $updated_at	= date("Y-m-d H:i:s");

        $sqlstatement = "update split_group set displayname = '".$displayname."' , updated_at = '".$updated_at."' where groupid = '".$groupId."'";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {    
            return false;
        }
    }

    public function updateGroupCurrency($currency, $groupId){

        $updated_at	= date("Y-m-d H:i:s");

        $sqlstatement = "update split_group set currency = '".$currency."' , updated_at = '".$updated_at."' where groupid = '".$groupId."'";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {    
            return false;
        }
    }

    public function updateGroupSplitType($splitType, $groupId){

        $updated_at	= date("Y-m-d H:i:s");

        $sqlstatement = "update split_group set splittype = '".$splitType."' , updated_at = '".$updated_at."' where groupid = '".$groupId."'";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {    
            return false;
        }
    }

    public function updateGroupIsDeleted($isDeleted, $groupId){

        $updated_at	= date("Y-m-d H:i:s");

        $sqlstatement = "update split_group set isdeleted = '".$isDeleted."' , updated_at = '".$updated_at."' where groupid = '".$groupId."'";
        $stmt = $this->conn->prepare($sqlstatement);
		
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {    
            return false;
        }
    }



    // public function updatePaymentDeadline($paymentDeadline, $groupId){

    //     $updated_at	= date("Y-m-d H:i:s");
    //     $sqlstatement = "update split_group set paymentdeadline = '".$paymentDeadline."' , updated_at = '".$updated_at."' where groupid = '".$groupId."' ";
    //     $stmt = $this->conn->prepare($sqlstatement);
		
    //     $result = $stmt->execute();
    //     $stmt->close();

    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

}