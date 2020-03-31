<?php
///https://new.meetstream.com/twilio/
$from_address="webmaster@".$_SERVER['localhost'];
$from_name="webmaster";
$headers = "MIME-Version: 1.0\r\n"
  ."Content-Type: text/plain; charset=utf-8\r\n"
  ."Content-Transfer-Encoding: 8bit\r\n"
  ."From: =?UTF-8?B?". base64_encode($from_name) ."?= <$from_address>\r\n"
  ."X-Mailer: PHP/". phpversion();
$subject="Web Mail Testing";
$body="This is test Message";
$to="solutiontan812@gmail.com";
mail($to, $subject, $body, $headers, "-fwebmaster@{$_SERVER['SERVER_NAME']}");
echo "The Mail is  SuccessFully Sent to :".$to;
?>