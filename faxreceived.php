<?php

    header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    

    require  'PhpMailer/Exception.php';
    require  'PhpMailer/PHPMailer.php';
    require  'PhpMailer/SMTP.php';


    $file_content = file_get_contents('faxhook.txt', true);
    $to_email = explode("|||", $file_content)[0];
    $mediaUrl = explode("|||", $file_content)[1];
    $filename = explode("|||", $file_content)[2];
    $fromNum = $_POST['From'];
    $toNum = $_POST['To'];
    $r_mediaUrl = $_POST['MediaUrl'];
    $attach_file = './uploads/'. $filename;


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
                            <a style='font-size:15px' href='$r_mediaUrl' target='_blank'>Show  Fax Content</a><br><br></p><p>
                            <br></span></p></td>
                            </tr>
                            </tbody>
                          </table></td></tr></table></body></html>";


    
    $emailObj = new PhpMailer\PhpMailer(true);
    
    //$emailObj->From = "admin1@combrinck.co.za";
    $emailObj->SetFrom("webmaster@new.meetstream.com", "FAX System");
    $emailObj->addAddress($to_email, ""); //to_mail, to_name
    $emailObj->isHTML(true);
    $emailObj->Subject = "Fax Reciveced";
    $emailObj->Body = $body;
    $basecontent = file_get_contents($r_mediaUrl);    
    //$emailObj->addAttachment($attach_file);
    $emailObj->addStringAttachment($basecontent, $filename, $encoding = 'base64', $type = 'application/pdf');
    
    if($emailObj->send())
    {
        $txt = "Hook data: \n";
        $txt .= "AccountSid: ".$_POST['AccountSid']."\n";
        $txt .= "FaxId: ".$_POST['FaxSid']."\n";
        $txt .= "mediaUrl: ".$r_mediaUrl."\n";
        $txt .= "From: ".$_POST['From']."\n";
        $txt .= "To: ".$_POST['To']."\n";
        $txt .= "toEmail: ".$to."\n";
        $txt .= "Date & Time: ".date("Y-m-d H:i:s")."\n";
        $txt .= "Msg Status: Sent"."\n";
        //https://new.meetstream.com/twilio/faxcallback.php
        $myfile = fopen("faxhistory.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
        echo 'okay';
    }
    else
    {
        echo $emailObj->print_debugger();
    }
    exit;
?>