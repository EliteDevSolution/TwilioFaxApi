<?php
    
    require  'PhpMailer/Exception.php';
    require  'PhpMailer/PHPMailer.php';
    require  'PhpMailer/SMTP.php';
    
    $emailObj = new PhpMailer\PhpMailer(true);
    $emailObj->isSMTP();                                            
    $emailObj->Host       = 'cp13.domains.co.za';                   
    $emailObj->SMTPAuth   = true;                                   
    $emailObj->Username   = 'admin1@combrinck.co.za';               
    $emailObj->Password   = 'aTest1234@01';                         
    $emailObj->SMTPSecure = 'ssl';                                  
    $emailObj->Port       = 465;                                    
    $emailObj->From = "admin1@combrinck.co.za";
    $emailObj->addAddress("fstar@eclipso.ch", "");//to_mail, to_name
    $emailObj->isHTML(true);
    $emailObj->Subject = "Fax Reciveced.";
    $emailObj->Body = "<html><body><h1>This is test mail</h1></body></html>";
    $filename = "faxtest.pdf";
    $attach = './uploads/'. $filename;
    $emailObj->addAttachment($attach);
    exit;
    if($emailObj->send())
    {
        echo 'okay';
    }
    else
    {
        echo $emailObj->print_debugger();
    }
    exit;

  
?>