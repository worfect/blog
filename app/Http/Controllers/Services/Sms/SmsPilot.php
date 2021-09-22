<?php


namespace App\Http\Controllers\Services\Sms;


class SmsPilot implements SmsService
{
    const URL_API = "https://smspilot.ru/api.php";

    protected $api_token;
    protected $from = 'INFORM';

    public function __construct()
    {
        $this->api_token = env('SMSPILOT_KEY');
    }

    public function send($number, $text): string
    {
        $curl = curl_init(self::URL_API);
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $curl, CURLOPT_TIMEOUT, 30);
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query(array(
            "apikey" => $this->api_token,
            "to" => $number,
            "send" => $text,
            "from" => $this->from,
            "format" => 'json'
        )));
        if (!$result = curl_exec($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        return $result;
    }

    public function balance(): string
    {
        $curl = curl_init(self::URL_API);
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $curl, CURLOPT_TIMEOUT, 30);
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query(array(
            "apikey" => $this->api_token,
            "balance" => 'rur',
            "format" => 'json'
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
        if(array_key_exists('error', $response) ){
            return $response;
        }
        return true;
    }
}


