<?php

class GroupDbOperation
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

	
	// todo : implement encryption function for password and check for duplicates (see dc9 program)
	// make sure that you are following security practices here,
    public function createGroup($groupid, $name, $splittype, $paymentdeadline, $grouppaymentdone, $displayname,$currency)
    {



        $createStmt = "create table if not exists split_group (
            groupid varchar(30) not null primary key, name varchar(50) not null, splittype enum('-1','0','1') not null, paymentdeadline datetime not null, grouppaymentdone boolean not null, displayname varchar(50) not null, currency varchar(10) not null, created_at datetime not null, updated_at datetime not null, isdeleted boolean not null  
            )";
        $stmt = $this->conn->prepare($createStmt);
        $result = $stmt->execute();
        if($result){
            $sqlstatement = "insert into split_group (groupid,name,splittype,paymentdeadline,grouppaymentdone,displayname,currency,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sqlstatement);
            $created_at = date("Y-m-d H:i:s");
            $updated_at	= date("Y-m-d H:i:s");
		    $stmt->bind_param('sssssssss', $groupid, $name, $splittype, $paymentdeadline,  $grouppaymentdone, $displayname, $currency, $created_at, $updated_at);
		
            $resultInsert = $stmt->execute();
            $stmt->close();
        }else{
            return false;
        }

        // $sqlstatement = "insert into split_group (groupid,name,splittype,paymentdeadline,grouppaymentdone,displayname,currency,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)";
        // $stmt = $this->conn->prepare($sqlstatement);
		// // bind params will tell us what we put into 
		// $created_at = date("Y-m-d H:i:s");
        // $updated_at	= date("Y-m-d H:i:s");
		// $stmt->bind_param('sssssssss', $groupid, $name, $splittype, $paymentdeadline,  $grouppaymentdone, $displayname, $currency, $created_at, $updated_at);
        // $result = $stmt->execute();
        // $stmt->close();

        if ($resultInsert) {
            return true;
        } else {
            return false;
        }
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