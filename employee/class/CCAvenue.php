<?php

if (!defined('CCAvenueTestMode')) define('CCAvenueTestMode', false);

class CCAvenue
{
    protected const TEST_ENDPOINT = 'https://test.ccavenue.com';

    protected const PRODUCTION_ENDPOINT = 'https://secure.ccavenue.com';

    protected static function isTestMode()
    {
        return CCAvenueTestMode;
    }

    protected static function getMerchantID()
    {
        return self::isTestMode() ? CCAvenueTestMerchantID : CCAvenueMerchantID;
    }

    protected static function getAccessCode()
    {
        return self::isTestMode() ? CCAvenueTestAccessCode : CCAvenueAccessCode;
    }

    protected static function getWorkingKey()
    {
        return self::isTestMode() ? CCAvenueTestWorkingKey : CCAvenueWorkingKey;
    }

    protected static function getEndPoint()
    {
        return (self::isTestMode() ? self::TEST_ENDPOINT : self::PRODUCTION_ENDPOINT) . '/transaction/transaction.do?command=initiateTransaction';
    }

    protected static function encrypt($plainText, $key)
    {
        $key = self::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return bin2hex($openMode);
    }

    protected static function decrypt($encryptedText, $key)
    {
        $key = self::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = self::hextobin($encryptedText);
        return openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    }

    protected static function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }

    public static function redirect($data = [])
    {
        $data = array_merge([
            'tid' => strtotime('now'),
            'merchant_id' => self::getMerchantID(),
            'currency' => 'INR',
            'language' => 'EN',
        ], $data);

        $data = array_map(function ($key, $value) {
            return $key . '=' . $value;
        }, array_keys($data), $data);

        die('<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Redirecting to CC Avenue</title>
        </head>
        <body>
            <form action="' . self::getEndPoint() . '" method="post" name="redirect">
                <input type="hidden" name="encRequest" value="' . self::encrypt(implode('&', $data), self::getWorkingKey()) . '">
                <input type="hidden" name="access_code" value="' . self::getAccessCode() . '">
            </form>
            <script type="text/javascript">
                document.redirect.submit();
            </script>
        </body>
        </html>');
    }

    public static function response()
    {
        $response = [];
        if (isset($_POST['encResp']) && ($encResponse = $_POST['encResp'])) {
            $decryptValues = explode('&', self::decrypt($encResponse, self::getWorkingKey()));

            for ($i = 0; $i < sizeof($decryptValues); $i++) {
                list($key, $value) = explode('=', $decryptValues[$i]);
                $response[$key] = $value;
            }
        }

        $success = (bool) ($response['order_status'] === 'Success');
        return (object) compact('success', 'response');
    }
}
