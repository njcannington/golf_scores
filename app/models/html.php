<?php
namespace App\Models;

/**
 * main class for collecting HTML
 */
class HTML
{
    public static function curlThis($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    break;
                default:
                    throw new \Exception("Unexpected HTTP code: {$http_code}");
            }
        }
        curl_close($ch);

        return $html;
    }
}
