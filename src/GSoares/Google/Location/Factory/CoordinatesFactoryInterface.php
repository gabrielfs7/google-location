<?php
namespace GSoares\Google\Location\Factory;

/**
 * @package GSoares\Google\Location\Factory
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
interface CoordinatesFactoryInterface
{

    /**
     * @param $response
     * @return mixed
     */
    public function create($response);
}