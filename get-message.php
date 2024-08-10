<?php
session_start();
include("connect.php");

if (isset($_GET['user_id'])) {
    $user_id     =  $_GET['user_id'];
    $messageId  =  $_GET['messageId'];
    $host_id  =  $_SESSION['id'];
    $host_name = $_SESSION['username'];
    $host_img = $_SESSION['img'];
    if ($messageId   == null) {
        $messageId    = 0;
    }

    $query0  =    "select * from users where id = '$user_id'";
                            $result0 =  mysqli_query($conn, $query0);

                            $row0 =  mysqli_fetch_object($result0);
                            $user_img =  $row0->img;

    $lastmesaageId   =   "";
    $data   =  "";
    $query1 = "SELECT * 
    FROM chat_message 
    WHERE 
    (
        (user_id = '$user_id' or user_id = '$host_id') 
        AND
        (host_id = '$host_id' or host_id = '$user_id')
    )
    AND id > '$messageId'
    ORDER BY id DESC";

    $a =  1;
    $result1 =  mysqli_query($conn, $query1);

    $rws =  mysqli_num_rows($result1);
    if ($rws >  0) {

        $query2  =  "select * from chat_message where user_id =  '$user_id' or '$host_id'
AND host_id =  '$host_id' or '$user_id'   ORDER BY id  desc limit 1";
        $result2 =  mysqli_query($conn, $query2);
        $row2 =  mysqli_fetch_object($result2);

        $lastmesaageId  =  $row2->id;
        while ($row =  mysqli_fetch_object($result1)) {

            $msg =  $row->message;

            if ($row->host_id == $host_id) {
                $data .= '
    <div style="width: 98%; border: 2px dotted black; display: flex; align-items: center; padding: 10px; border-radius: 6px; margin: 5px; box-sizing: border-box;">
        <img src="' . $host_img . '" width="30px" height="30px" style="border-radius: 50%; margin-right: 10px;">
        <h6 style="margin: 0;">
            ' . ($row->type != "file" ? $row->message : '') . '
        </h6>
    </div>
';
            } else {
                $data .= '
    <div style="width: 96%; border: 2px dotted blue; display: flex; align-items: center; padding: 10px; margin-left: 15px; margin-top:5px; border-radius: 6px; justify-content: flex-end;">
        <h6 style="margin: 0; margin-right: 10px;">
            ' . ($row->type != "file" ? $row->message : '') . '
        </h6>
        <img src="' . $user_img . '" width="30px" height="30px" style="border-radius: 50%;">
    </div>
';
            }
        }


        $response = array(
            "lastMessageId" => $lastmesaageId,
            "data" => $data
        );
        echo json_encode($response);
    } else {
        //echo json_encode(array("lastMessageId" => 0, "data" => "0"));
    }
}
