<?php
namespace GSoares\Google\Location;

use GSoares\Google\Location\Address\Coordinates;
use GSoares\Google\Location\Factory\CoordinatesFactoryInterface;
use GSoares\Google\Location\Factory\CoordinatesHtmlFactory;

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
        $this->locator = $locator ?: new HtmlLocator();
        $this->coordinatesFactory = $coordinatesFactory ?: new CoordinatesHtmlFactory();
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