<?php
    header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");

    $file_content = file_get_contents('faxhook.txt', true);
    $email = explode("|||", $file_content)[0];
    $mediaUrl = explode("|||", $file_content)[1];
    $filename = explode("|||", $file_content)[2];
    $fromNum = $_POST['From'];
    $toNum = $_POST['To'];
    $m_mediaUrl = $_POST['MediaUrl'];
    $from = "webmaster@".$_SERVER['localhost'];
    $dir = './uploads/'. $filename;
    $pdfLocation = $dir; // file location
	$pdfName     = $filename; // pdf file name recipient will get
	$filetype    = "application/pdf"; // type
	// fetch pdf
	$file = fopen($pdfLocation, 'rb');
	$data = fread($file, filesize($pdfLocation));
	fclose($file);
	$to = $email; //User Email Address

	$body = "<html>
                    <body>
                      <table class='height:100%'>
                        <tr>
                        <td valign='top' style='padding-top: 9px;-webkit-text-size-adjust: 100%;'>
                          <table align='left' border='0' cellpadding='0' cellspacing='0' style='max-width: 100%;min-width: 100%;border-collapse: collapse;-webkit-text-size-adjust: 100%;' width='100%' ><tbody><tr><td valign='top'  style='padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #757575;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;'>
                            <h2 style='display: block;margin: 0;padding: 0;color: #222222;font-family: Helvetica;font-size: 28px;font-style: normal;font-weight: bold;line-height: 150%;letter-spacing: normal;text-align: left;'><br>
                            Welcome to Fax recived!</h2>
                            <p><span style='font-size:15px'></span></p>
                            <br><br>
                            Your Fax Number is: <strong>$toNum</strong><br><br>
                            From Fax Number is: <strong>$fromNum</strong><br><br>
                            <a style='font-size:15px' href='$m_mediaUrl' target='_blank'>Show  Fax Content</a><br><br></p><p>
                            <br></span></p></td>
                            </tr>
                            </tbody>
                          </table></td></tr></table></body></html>";


	$pdf = chunk_split(base64_encode($data));
	$eol = PHP_EOL;
	$semi_rand     = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
	$headers       = "From: Fax System <$from>$eol" .
	  "MIME-Version: 1.0$eol" .
	  "Content-Type: multipart/mixed;$eol" .
      "X-Mailer: PHP/". phpversion().";$eol".
	  " boundary=\"$mime_boundary\"";
	// add html message body
	  $message = "--$mime_boundary$eol" .
	  "Content-Type: text/html; charset=\"iso-8859-1\"$eol" .
	  "Content-Transfer-Encoding: 7bit$eol$eol" .
	  $body . $eol;  

	$message .= "--$mime_boundary$eol" .
	  "Content-Type: $filetype;$eol" .
	  " name=\"$pdfName\"$eol" .
	  "Content-Disposition: attachment;$eol" .
	  " filename=\"$pdfName\"$eol" .
	  "Content-Transfer-Encoding: base64$eol$eol" .
	  $pdf . $eol .
	  "--$mime_boundary--";  
    
    //Msg Send Processing

      $subject = "Fax Receviced";
      
      //$message = "Test Msg";
      //$headers = "From: Fax System <" . $fromEmail. ">\r\n";
      //$headers .= "MIME-Version: 1.0\r\n";
      //$headers .= "Content-Type:  multipart/mixed;\r\n";
    $res = mail($to, $subject, $message, $headers, "-fwebmaster@{$_SERVER['SERVER_NAME']}");
    // $txt = "Hook data: \n";
    // $txt .= "AccountSid: ".$_POST['AccountSid']."\n";
    // $txt .= "FaxId: ".$_POST['FaxSid']."\n";
    // $txt .= "From: ".$_POST['From']."\n";
    // $txt .= "To: ".$_POST['To']."\n";
    // $txt .= "toEmail: ".$to."\n";
    // $txt .= "Date & Time: ".date("Y-m-d H:i:s")."\n";
    // $txt .= "Msg Status: ".$res."\n";
    // //https://new.meetstream.com/twilio/faxcallback.php
    // $myfile = fopen("faxhistory.txt", "w") or die("Unable to open file!");
    // fwrite($myfile, $txt);
    // fclose($myfile);
    echo '';
?>
