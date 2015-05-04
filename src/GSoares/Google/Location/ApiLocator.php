<?php
namespace GSoares\Google\Location;

use GSoares\Google\Location\Error\InvalidResponseException;

/**
 * @package GSoares\Google\Location
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
class ApiLocator implements LocatorInterface
{

    const API_URL = 'http://maps.googleapis.com/maps/api/geocode/json';

    /**
     * @param $address
     * @return mixed
     * @throws InvalidResponseException
     */
    public function locate($address)
    {
        $response = file_get_contents(self::API_URL . '?sensor=true&address=' . urlencode($address));

        if ($jsonDecoded = json_decode($response)) {
            return $jsonDecoded;
        }

        throw new InvalidResponseException(
            "Invalid Json [" . json_last_error() .
            "] " . json_last_error_msg() .
            ": " . var_export($response, true)
        );
    }
}