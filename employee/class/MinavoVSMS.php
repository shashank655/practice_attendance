<?php

class MinavoVSMS
{
    protected const AUTH_KEY = MinavoVSMSAuthKey;

    protected const SENDER_ID = MinavoVSMSSenderId;

    protected const MTYPE = 'N';

    protected const BASE_URL = 'https://vsms.minavo.in/';

    protected static function request(string $path, array $params)
    {
        $url = self::BASE_URL . $path . '?' . http_build_query(array_merge([
            'auth_key' => self::AUTH_KEY,
            'sid' => self::SENDER_ID,
            'mtype' => self::MTYPE,
        ], $params));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept:application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result);
    }

    public static function singlesms($mobilenumber, string $message)
    {
        return self::request('api/singlesms.php', compact('mobilenumber', 'message'));
    }

    public static function bulksms(array $mobilenumbers, string $message)
    {
        $mobilenumber = implode(',', $mobilenumbers);
        return self::request('api/bulksms.php', compact('mobilenumber', 'message'));
    }

    public static function multimsgmultino(array $data)
    {
        $mno_msg = implode('~', array_map(function ($mobilenumber, $message) {
            return '91' . $mobilenumber . '^' . $message;
        }, array_keys($data), $data));

        return self::request('api/multimsgmultino.php', compact('mno_msg'));
    }
}
