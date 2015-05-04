<?php
namespace GSoares\Google\Location;

use GSoares\Google\Location\Error\InvalidResponseException;

/**
 * @package GSoares\Google\Location
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
interface LocatorInterface
{

    /**
     * @param $address
     * @return string
     * @throws InvalidResponseException
     */
    public function locate($address);
}