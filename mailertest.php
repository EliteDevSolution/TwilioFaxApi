<?php

   require  'PhpMailer/Exception.php';
   require  'PhpMailer/PHPMailer.php';
   require  'PhpMailer/SMTP.php';
    
   $basecontent = file_get_contents('http://clenched-ceramics.000webhostapp.com/twilio/uploads/faxtest.pdf');    
    
   $mail = new PhpMailer\PhpMailer(true);
    
   /* Open the try/catch block. */
   try {
      /* Set the mail sender. */

      $mail->setFrom('webmaster@new.meetstream.com', 'CMS707 Mail System');

      /* Add a recipient. */
      $mail->addAddress('solutiontan812@gmail.com', 'TanHome');

      $mail->isHTML(true);
      
      

      /* Set the subject. */
      $mail->Subject = 'Force';

      /* Set the mail message body. */
      $mail->Body = "<html>
                    <body>
                      <table class='height:100%'>
                        <tr>
                        <td valign='top' style='padding-top: 9px;-webkit-text-size-adjust: 100%;'>
                          <table align='left' border='0' cellpadding='0' cellspacing='0' style='max-width: 100%;min-width: 100%;border-collapse: collapse;-webkit-text-size-adjust: 100%;' width='100%' ><tbody><tr><td valign='top'  style='padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #757575;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;'>
                            <h2 style='display: block;margin: 0;padding: 0;color: #222222;font-family: Helvetica;font-size: 28px;font-style: normal;font-weight: bold;line-height: 150%;letter-spacing: normal;text-align: left;'><br>
                            Welcome to Fax recived!</h2>
                            <p><span style='font-size:15px'></span></p>
                            <br><br>
                            Your Fax Number is: <strong>+182189010</strong><br><br>
                            From Fax Number is: <strong>+23889</strong><br><br>
                            <a style='font-size:15px' href='https://clenched-ceramics.000webhostapp.com/twilio/uploads/faxtest.pdf' target='_blank'>Show  Fax Content</a><br><br></p><p>
                            <br></span></p></td>
                            </tr>
                            </tbody>
                          </table></td></tr></table></body></html>";

                    $mail->addStringAttachment($basecontent, 'faxcontent.pdf', $encoding = 'base64', $type = 'application/pdf');
                    

      /* Finally send the mail. */
      $mail->send();
      echo "ok";
   }
   catch (Exception $e)
   {
      /* PHPMailer exception. */
      echo $e->errorMessage();
   }
   catch (\Exception $e)
   {
      /* PHP exception (note the backslash to select the global namespace Exception class). */
      echo $e->getMessage();
   }
?>   