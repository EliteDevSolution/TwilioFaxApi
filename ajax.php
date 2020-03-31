<?php
    header('Content-Type: text/html; charset=utf-8');
    header("Access-Control-Allow-Origin: *");

    require 'SendProcessing.php';
    $m_fax = new SendProcessing();
    $toNum = null;
    $body = null;
    $file_name = null;
    $mediaUrl = null;
    $dir = './uploads/';
    $old = umask(0);

    if( !is_dir($dir) ) {
        mkdir($dir, 0755, true);
    }
    umask($old);

    if (isset($_FILES) && !empty($_FILES)) {
        if(isset($_FILES['fileName']) && !empty($_FILES['fileName'])) {
            $file = $_FILES['fileName'];
            $file_name = $file['name'];
            $path = $file['tmp_name'];
            $mediaUrl = 'https://'.$_SERVER['HTTP_HOST']."/twilio/uploads/".$file_name;
            $uploadpath = $dir;
            $uploadpath = $uploadpath . basename($file_name);
            if (move_uploaded_file($path, $uploadpath)) {

            } else {
                echo "There was an error uploading the file, please try again!";
            }
        }
    }
    else
    {
        $mediaUrl = $mediaUrl.'test.tmp';
    }
    $toNum = $_POST['toNum'];
    $body = $_POST['body'];
    $email = $_POST['email'];
    $flag = $m_fax->sendFax($toNum, $email, $file_name, $mediaUrl);
    if($flag) echo "ok";
?>