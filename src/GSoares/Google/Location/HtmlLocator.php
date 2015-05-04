<?php
namespace GSoares\Google\Location;

use GSoares\Google\Location\Error\InvalidResponseException;

/**
 * @package GSoares\Google\Location
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
class HtmlLocator implements LocatorInterface
{

    const SITE_URL = 'https://www.google.com.br/maps/search/';

    /**
     * @param $address
     * @return mixed
     * @throws InvalidResponseException
     */
    public function locate($address)
    {
        $response = $this->curl(self::SITE_URL . urlencode($address), 'Mozilla 5.0');


        preg_replace_callback(
            '/cacheResponse\(.*\],\"https/',
            function ($a) {
                $a = $a[0];
                $a = str_replace('cacheResponse(', '', $a);
                $a = str_replace(',"https', '', $a);
                $a = substr($a, 1);
                var_dump([[3536.331829127588,-48.60443915,-27.5832369],[0,0,0],[1024,768],13.10000038146973]);
            },
            $response
        );

        //var_dump(strstr($response, 'cacheResponse('));

        //echo htmlentities($response);

        exit(); //FIXME
        $url = self::SITE_URL . urlencode($address);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        var_dump($response); exit();
        //FIXME

        $response = json_decode($response);

//        $url = self::SITE_URL . urlencode($address);
//        $url = htmlspecialchars($url);
//
//        echo $url;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $return = curl_exec($ch);
//        curl_close($ch);
//
//        echo $return; //FIXME
//
//        exit();
//
//        $response = json_decode(curl_exec($ch), true);
//        if ($response['status'] != 'OK') {
//            echo 'An error has occured: ' . print_r($response);
//        } else {
//            $geometry = $response['results'][0]['geometry'];
//            $longitude = $geometry['location']['lat'];
//            $latitude = $geometry['location']['lng'];
//        }
//
//        exit();
        //FIXME
        //FIXME
        //FIXME
        $response = file_get_contents(self::SITE_URL . urlencode($address));

        echo htmlentities($response);

        var_dump(strstr($response, 'APP_INITIALIZATION_STATE'));

//        preg_replace_callback(
//            '/.APP_INITIALIZATION_STATE./',
//            function ($aa) {
//                var_dump($aa);
//            },
//            $response
//        );

        exit(); //FIXME

        if ($jsonDecoded = json_decode($response)) {
            return $jsonDecoded;
        }

        throw new InvalidResponseException(
            "Invalid Json [" . json_last_error() .
            "] " . json_last_error_msg() .
            ": " . var_export($response, true)
        );
    }

    private function curl($url, $user_agent, $retry = 0)
    {
        if ($retry > 5){
            print "Maximum 5 retries are done, skipping!\n";
            return "in loop!";
        }

        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt ($ch, CURLOPT_HEADER, TRUE);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt ($ch, CURLOPT_REFERER, 'http://www.google.com/');
        curl_setopt ($ch, CURLOPT_COOKIEFILE,"./cookie.txt");
        curl_setopt ($ch, CURLOPT_COOKIEJAR,"./cookie.txt");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        // handling the follow redirect
        if (preg_match("|Location: (https?://\S+)|", $result, $m)) {
            print "Manually doing follow redirect!\n$m[1]\n";
            return $this->curl($m[1], $user_agent, $retry + 1);
        }

        // add another condition here if the location is like Location: /home/products/index.php

        return $result;
    }
}