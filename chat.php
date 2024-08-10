<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        span {
            font-weight: bolder;
            text-align: center;
        }

        .float-link {
            float: right;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php echo $_SESSION["username"]; ?><span class="dashboard"> Chat room</span>

        <a href="http://localhost/chat/logout.php" class="float-link">Logout</a>
    </div>
    <?php
    include 'connect.php';
    $cid = $_GET['cid'];
    $host_id  =  $_SESSION['id'];
    $host_name = $_SESSION['username'];
    $host_img = $_SESSION['img'];
    $sql = "SELECT * FROM users WHERE id = '$cid'";
    $result0 = $conn->query($sql);
    if ($result0->num_rows > 0) {
        $row0 =  mysqli_fetch_object($result0);
        $user_img =  $row0->img;
        $user_name =  $row0->name;
        ?>
    
            <span>chat with</span> <a href="http://localhost/chat/chat.php"><?php echo $user_name ?></a><a class="float-link" href="http://localhost/chat/dashboard.php">Back</a>
    <?php
        
    } else {
        echo "0 results";
    }

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body>
        <div class="container mt-5">
            <div class="card" style="border-bottom: none; margin-bottom:-2px">
                <!-- <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">

                             <?php

                            // $query  =    "select * from users where id = '$cid'";
                            // $result =  mysqli_query($conn, $query);

                            // $row =  mysqli_fetch_object($result);
                            // $user_img =  $row->img;
                            // $user_name =  $row->name;
                            ?> -->

                            <!-- <img class="pats mt-2" src="<?= $user_img; ?>" width="30px" height="30px" style="margin-top:20px; border-radius:50%;">
                            <a href="#"><span class="pn ml-1"><?= $user_name ?>
                                </span></a>
                        </div> -->


                    <!-- </div> -->
                <!-- </div> --> 
                <div class="card" id="main-body">
                    <?php
                        $query  =  "SELECT * FROM chat_message 
                        WHERE (host_id = '$host_id' AND user_id = '$cid') 
                        OR (host_id = '$cid' AND user_id = '$host_id')";

                    $a =  1;
                    $result =  mysqli_query($conn, $query);

                    $rws =  mysqli_num_rows($result);

                    $query2  =  "select * from chat_message where host_id =  '$host_id' or '$cid'
                    AND user_id =  '$cid' or '$host_id'  ORDER BY id  desc limit 1";

                    // $a =  1;
                    $result2 =  mysqli_query($conn, $query2);



                    $row2 =  mysqli_fetch_object($result2);

                    while ($row =  mysqli_fetch_object($result)) {
                        //   $a++;
                        if ($row->host_id == $host_id) {
                    ?>

                            <div style="width: 98%; border: 2px dotted black; display: flex; align-items: center; padding: 10px; border-radius: 6px; margin: 5px; box-sizing: border-box;">
                                <img src="<?= $host_img; ?>" width="30px" height="30px" style="border-radius: 50%; margin-right: 10px;">
                                <h6 style="margin: 0;">
                                    <?php if ($row->type != "file") {
                                        echo $row->message;
                                    } ?>
                                </h6>
                            </div>
                        <?php

                        } else {
                        ?>

                            <div style="width: 96%; border: 2px dotted blue; display: flex; align-items: center; padding: 10px; margin-left: 15px; margin-top:5px; border-radius: 6px; justify-content: flex-end;">
                                <h6 style="margin: 0; margin-right: 10px;">
                                    <?php if ($row->type != "file") {
                                        echo $row->message;
                                    } ?>
                                </h6>
                                <img src="<?= $user_img; ?>" width="30px" height="30px" style="border-radius: 50%;">
                            </div>

                        <?php

                        }
                    }

                    if (mysqli_num_rows($result2) >  0) {


                        ?>


                        <input type="hidden" value="<?= $row2->id ?>" class="messageId">

                    <?php


                    } else {
                    ?>


                        <input type="hidden" value="0" class="messageId">

                    <?php



                    }
                    ?>



                    <div class='msg' style='display: contents;'>


                    </div>

                    <br>
                    <form action="" class="aa message-form">
                        <div id="demo" class="ar container collapse">
                            <div class="container">
                                <audio id="recorder" muted></audio>
                                <!-- <div>
                                    <audio class="pt-3" id="player" controls></audio><br>
                                    <button class="batn mt-3" id="start">Record</button>
                                    <button class="batn mb-3" id="stop">Send Message</button>
                                </div> -->
                            </div>
                        </div>
                        <i class="eyess fa fa-microphone" class="btn btn-info" data-toggle="collapse" data-target="#demo">
                        </i>
                        <input style="padding:1px 32px;" class="inpt" type="text" required name="msg" id="msg" placeholder="Enter your message here">
                        <input type="hidden" name="type" value="text">
                        <button name="submit" class="prbtn pb-1">Send Message</button>
                        <input type="hidden" name="host" id="host" value="<?= $host_id; ?>">
                        <input type="hidden" name="user" id="user" value="<?= $cid; ?>">
                    </form>
                </div>
            </div>
            <script>
                $(function() {


                    var inrval = setInterval(function() {
                        var user_id = $("#user").val();

                        var messageId = $(".messageId").val();
                        $.ajax({
                            url: "get-message.php",
                            type: "GET",

                            contentType: "application/json; charset=utf-8",
                            data: {
                                "user_id": user_id,
                                "messageId": messageId
                            },
                            dataType: "json",
                            success: function(response) {
                                console.log(response)

                                if (response.data != "0") {


                                    if (response.data != "") {


                                        $(".msg").append(response.data);
                                        console.log("data is" + response.data);
                                        $(".messageId").val(response.lastMessageId);
                                    }


                                } else {
                                    console.log("empty")
                                }

                            }
                        })


                    }, 4000);

                    $(".message-form").on("submit", function(e) {
                        var host_id = <?php echo json_encode($host_id); ?>;
                        e.preventDefault();
                        $.ajax({
                            url: "send-message.php",
                            type: "post",
                            data: $(this).serialize(),
                            success: function(res) {
                                $(".msg").append(res)

                                $("#msg").val("")

                                // $.ajax({
                                //     url: "buyer-get-message.php",
                                //     type: "get",
                                //     data: {
                                //         "message_last_Id": "true",
                                //         "dotor_id": seller_id
                                //     },
                                //     success: function(data) {

                                //         $(".messageId").val(data)
                                //         const theElement = document.getElementById('main-body');

                                //         const scrollToBottom = (node) => {
                                //             node.scrollTop = node.scrollHeight;
                                //         }
                                //         scrollToBottom(theElement);


                                //     }
                                // })



                            }
                        })
                    })
                })
            </script>
            <script>
                class VoiceRecorder {
                    constructor() {
                        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                            console.log("getUserMedia supported")
                        } else {
                            console.log("getUserMedia is not supported on your browser!")
                        }

                        this.mediaRecorder
                        this.stream
                        this.chunks = []
                        this.isRecording = false

                        this.recorderRef = document.querySelector("#recorder")
                        this.playerRef = document.querySelector("#player")
                        this.startRef = document.querySelector("#start")
                        this.stopRef = document.querySelector("#stop")

                        this.startRef.onclick = this.startRecording.bind(this)
                        this.stopRef.onclick = this.stopRecording.bind(this)

                        this.constraints = {
                            audio: true,
                            video: false
                        }

                    }

                    handleSuccess(stream) {
                        this.stream = stream
                        this.stream.oninactive = () => {
                            console.log("Stream ended!")
                        };
                        this.recorderRef.srcObject = this.stream
                        this.mediaRecorder = new MediaRecorder(this.stream)
                        console.log(this.mediaRecorder)
                        this.mediaRecorder.ondataavailable = this.onMediaRecorderDataAvailable.bind(this)
                        this.mediaRecorder.onstop = this.onMediaRecorderStop.bind(this)
                        this.recorderRef.play()
                        this.mediaRecorder.start()
                        console.log(this.mediaRecorder);
                        console.log(this.mediaRecorder);

                    }

                    handleError(error) {
                        console.log("navigator.getUserMedia error: ", error)
                    }

                    onMediaRecorderDataAvailable(e) {
                        this.chunks.push(e.data)
                    }

                    onMediaRecorderStop(e) {
                        const blob = new Blob(this.chunks, {
                            'type': 'audio/ogg; codecs=opus'
                        })
                        const audioURL = window.URL.createObjectURL(blob)
                        this.playerRef.src = audioURL
                        this.chunks = []
                        this.stream.getAudioTracks().forEach(track => track.stop())
                        this.stream = null
                    }

                    startRecording() {
                        if (this.isRecording) return
                        this.isRecording = true
                        this.startRef.innerHTML = 'Recording'
                        this.playerRef.src = ''
                        navigator.mediaDevices
                            .getUserMedia(this.constraints)
                            .then(this.handleSuccess.bind(this))
                            .catch(this.handleError.bind(this))
                    }

                    stopRecording() {
                        if (!this.isRecording) return
                        this.isRecording = false
                        this.startRef.innerHTML = 'Record'
                        this.recorderRef.pause()
                        this.mediaRecorder.stop()

                        this.mediaRecorder.ondataavailable = (event) => {
                            this.uploadAudioFromBlob('file', event.data);


                        }

                    }

                    uploadAudioFromBlob(assetID, blob) {

                        var reader = new FileReader();

                        // this is triggered once the blob is read and readAsDataURL returns
                        reader.onload = function(event) {
                            var formData = new FormData();
                            formData.append('type', assetID);
                            formData.append('seller_id', "<?php echo $seller_id; ?>");

                            formData.append('msg', event.target.result);
                            $.ajax({
                                type: 'Post',
                                url: 'http://localhost/tijaraflex/buyer-send-message.php',
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                cache: false,
                                success: function(json) {
                                    console.log('test')
                                    console.log(json);
                                    //$('.msg').append(json.data);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(' - ' + errorThrown + '\n\n' + jqXHR.responseText);
                                    // handle audio upload failure
                                }
                            });
                        }
                        reader.readAsDataURL(blob);
                    }


                }

                window.voiceRecorder = new VoiceRecorder()
            </script>
    </body>

    </html>
</body>

</html>