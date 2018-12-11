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

        $coordinates = null;

        preg_replace_callback(
            '/cacheResponse\(.*\],\"https/',
            function ($a) use (&$coordinates) {
                $a = $a[0];
                $a = str_replace('cacheResponse(', '', $a);
                $a = str_replace(',"https', '', $a);
                $a = substr($a, 1);
                $a = str_replace(['[', ']'], ['', ''], $a);
                $a = explode(',', $a);

                if (count($a) > 2) {
                    $coordinates = [
                        $a[2],
                        $a[1]
                    ];
                }
            },
            $response,
            1
        );

        if (!$coordinates) {
            try {
                preg_match('/(center\=)(.){0,100}(zoom)/', $response, $matches);
                $url_coordinates = str_replace(['center=', '&amp;zoom'], '', reset($matches));
                $coordinates = explode('%2C', $url_coordinates);
            } catch (\Exception $e) {
            }
        }

        if ($coordinates) {
            return $coordinates;
        }

        throw new InvalidResponseException('Invalid HTML Response');
    }

    /**
     * @param $url
     * @param $user_agent
     * @param int $retry
     * @return string
     */
    private function curl($url, $user_agent, $retry = 0)
    {
        if ($retry > 5) {
            return;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Range: bytes=1-1024']);

        $result = curl_exec($ch);

        curl_close($ch);

        if (preg_match('|Location: (https?://\S+)|', $result, $m)) {
            return $this->curl($m[1], $user_agent, $retry + 1);
        }

        return $result;
    }
}