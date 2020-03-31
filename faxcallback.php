<?php
    header("content-type: application/xml");
    echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<Response>                            
    <Receive action="/twilio/faxreceived.php"/>
</Response>