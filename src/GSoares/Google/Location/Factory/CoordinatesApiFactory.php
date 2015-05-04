<?php
namespace GSoares\Google\Location\Factory;

use GSoares\Google\Location\Address\Coordinates;

/**
 * @package GSoares\Google\Location\Factory
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
class CoordinatesApiFactory implements CoordinatesFactoryInterface
{

    /**
     * @param $response
     * @return mixed
     */
    public function create($response)
    {
        if (count($response->results) == 0) {
            return;
        }

        $coordinatesDto = new Coordinates();
        $coordinatesDto->latitude = $response->results[0]->geometry->location->lat;
        $coordinatesDto->longitude = $response->results[0]->geometry->location->lng;

        return $coordinatesDto;
    }
}