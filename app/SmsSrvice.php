<?php

namespace App;


class SmsSrvice 
{
    public static function sendMessage($to,$message){
        echo "<p > TO:".$to."<br>MESSAGE:".$message."</p></hr>";
        // $args = http_build_query(array(
        //     'token' => env('SPARROW_TOKEN'),
        //     'from'  => env('SPARROW_FROM'),
        //     'to'    => $to,
        //     'text'  => $message));
    
        // $url = "http://api.sparrowsms.com/v2/sms/";
    
        // # Make the call using API.
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        // // Response
        // $response = curl_exec($ch);
        // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);
    }

    public static function generateSMS($data){
        $txt="";
        $txt.=$data['name'].'\n';
        foreach ($data['results'] as $value) {
            $txt.=$value['subjectname']."-".$value['mark'].'\n';
        }
       return $txt;
    }
}
