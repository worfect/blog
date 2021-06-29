<?php


namespace App\Http\Controllers\Services\Sms;


class SmsRu implements SmsService
{
    const URL_API = "https://sms.ru";

    protected $api_token;

    public function __construct()
    {
        $this->api_token = env('SMSRU_ID');
    }

    public function send($number, $text): string
    {
        $curl = curl_init(self::URL_API . '/sms/send');
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $curl, CURLOPT_TIMEOUT, 30);
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query(array(
            "api_id" => $this->api_token,
            "to" => $number,
            "msg" => $text,
            "json" => 1
        )));
        if (!$result = curl_exec($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        return $result;
    }

    public function balance(): string
    {
        $curl = curl_init(self::URL_API . '/my/balance');
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $curl, CURLOPT_TIMEOUT, 30);
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query(array(
            "api_id" => $this->api_token,
            "json" => 1
        )));
        if (!$result = curl_exec($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        return $result;
    }

    public function check($response)
    {
        $response = json_decode($response, true);
        if($response["status"] == "ERROR"){
            return $response;
        }
        return true;
    }


}
