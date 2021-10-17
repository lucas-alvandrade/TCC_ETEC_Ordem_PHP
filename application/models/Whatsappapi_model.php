<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Whatsappapi_model extends CI_Model {

    private $id = 1761; //Please change it with your ID
    
    private $key = "a02d8cd8385e214b9444652594b115bd08ee5aa2";

    public function send($send_to, $message_body) {

        $data = array('to' => $send_to, 'msg' => $message_body);

        $url = "https://onyxberry.com/services/wapi/Client/sendMessage";
        $url = $url . '/' . $this->id . '/' . $this->key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        return $response;
    }

}
