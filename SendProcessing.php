<?php
/**
 * Created by PhpStorm.
 * User: DRAGON
 * Date: 5/23/2019
 * Time: 3:26 AM
 */
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
class SendProcessing
{
    const sid = 'ACef1302576bce06a09acde229f5b5c6ee';
    const token = 'fc3e6789f74548604562bbbc9639db0e';
    const fromNum = '+15147001980';
    const toNumber = '+15147004449';
    //+61488844010
//    const fromNum = '+18474293544';

    
    private $client = null;

    function __construct()
    {
        $this->client = new Client(self::sid, self::token);
    }

   public function sendFax($toNum, $email, $filename, $mediaUrl)
   {
        /////////////////////Show Fax List///////////////////////
        
        // $faxes = $this->client->fax->v1->faxes
        //                          ->read(array(), 20);

        // foreach ($faxes as $record) {
        //     var_dump($record);
        // }
        // exit;

        /////////////////////Send Fax Process////////////////////
        $result = false;
        $body = "$email|||$mediaUrl|||$filename";
        if($mediaUrl)
        {
            $faxObj = $this->client->fax->v1->faxes
                       ->create($toNum, $mediaUrl, ['from' => self::fromNum, 'body'=>'$body']);
            if($faxObj->sid != "")
            {
                $txt = "$email|||$mediaUrl|||$filename";
                $myfile = fopen("faxhook.txt", "w") or die("Unable to open file!");
                fwrite($myfile, $txt);
                fclose($myfile);
                $result = true;
            } 
        }
        return $result;
   }

    public function MessageCreat($toNum, $body, $mediaUrl)
    {
        if($mediaUrl)
        {
            $message=$this->client->messages->create(
                $toNum,
                array(
                    'from'=>self::fromNum,
                    'body'=>$body,
                    'mediaUrl'=>$mediaUrl));
        }
        else{
            $message=$this->client->messages->create(
                $toNum,
                array(
                    'from'=>self::fromNum,
                    'body'=>$body));
        }
        return $message->sid;
    }

    public  function MessageRead($to=self::fromNum,$limit=50)
    {
        $messages = $this->client->messages->read(array('to'=>$to,'status'=>'received'), $limit);
        return $messages;
    }

    public function MessageDelte($sid)
    {
        $this->client->messages($sid)->delete();
    }

    public function MediaIdRead($sid)
    {
        $media = $this->client->messages($sid)->media->read(array(), 1);
        if($media) {
            foreach ($media as $record) {
                return $record->sid;
            }
        }
        return false;
    }

    public function MediaRead($sid)
    {
        $mediaId = $this->MediaIdRead($sid);
        if($mediaId) {
            $media = $this->client->messages($sid)->media($mediaId)->fetch();
            return $media;
        }
        return null;
    }

    function makeRequest($url, $callDetails = false)
    {
        // Set handle
        $ch = curl_init($url);

        // Set options
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute curl handle add results to data return array.
        $result = curl_exec($ch);
        $returnGroup = ['curlResult' => $result,];

        // If details of curl execution are asked for add them to return group.
        if ($callDetails) {
            $returnGroup['info'] = curl_getinfo($ch);
            $returnGroup['errno'] = curl_errno($ch);
            $returnGroup['error'] = curl_error($ch);
        }

        // Close cURL and return response.
        curl_close($ch);
        return $returnGroup;
    }

}