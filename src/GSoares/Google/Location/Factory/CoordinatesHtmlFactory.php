<?php
namespace GSoares\Google\Location\Factory;

use GSoares\Google\Location\Address\Coordinates;

/**
 * @package GSoares\Google\Location\Factory
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
class CoordinatesHtmlFactory implements CoordinatesFactoryInterface
{

    /**
     * @param $response
     * @return mixed
     */
    public function create($response)
    {
        $coordinatesDto = new Coordinates();
        $coordinatesDto->latitude = $response[0];
        $coordinatesDto->longitude = $response[1];

        return $coordinatesDto;
    }
}