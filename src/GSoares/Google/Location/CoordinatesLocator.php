<?php
namespace GSoares\Google\Location;

use GSoares\Google\Location\Address\Coordinates;
use GSoares\Google\Location\Factory\CoordinatesApiFactory;
use GSoares\Google\Location\Factory\CoordinatesFactoryInterface;

/**
 * @package GSoares\Google\Location
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
class CoordinatesLocator extends AbstractLocatorBuilder
{

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var CoordinatesFactoryInterface
     */
    private $coordinatesFactory;

    /**
     * @param LocatorInterface $locator
     * @param CoordinatesFactoryInterface $coordinatesFactory
     */
    public function __construct(
        LocatorInterface $locator = null,
        CoordinatesFactoryInterface $coordinatesFactory = null
    ) {
        $this->locator = $locator ?: new ApiLocator();
        $this->coordinatesFactory = $coordinatesFactory ?: new CoordinatesApiFactory();
    }

    /**
     * @return Coordinates
     */
    public function locate()
    {
        $response = $this->locator
            ->locate($this->getCompleteAddress());

        return $this->coordinatesFactory
            ->create($response);
    }
}