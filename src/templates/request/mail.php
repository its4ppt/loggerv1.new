<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// this is a test email to self 
$to = "shubhambohara09@gmail.com, shubham@giftcardsindia.in";
$subject = "test email to veryfie the contents";

$message = $message = "hello world";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


mail($to,$subject,$message,$headers);
echo "mail might be sent";
?> 

