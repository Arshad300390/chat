<?php
session_start();
include("connect.php");
if(isset($_POST['msg'])){
	$msg  = $_POST['msg'];
	$type = $_POST['type'];
	$user_id =$_POST['user'];

	//$buyer_id = base64_decode(base64_decode($_POST['buyer_id']));
	//$seller_id;
	$host_id  =  $_SESSION['id'];   
	$sender= 'host';

    
    $query = "INSERT into chat_message set user_id = $user_id ,

	 host_id =  $host_id , message =  '$msg' , sender ='$sender' ,
	type ='$type'";
	 
	 $result =  mysqli_query($conn,$query);
	
	
}

?>
