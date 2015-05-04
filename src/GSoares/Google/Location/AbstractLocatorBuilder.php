<?php
namespace GSoares\Google\Location;

/**
 * @package GSoares\Google\Location
 * @author Gabriel Felipe Soares <gabrielfs7@gmail.com>
 */
abstract class AbstractLocatorBuilder
{

    /**
     * @var float
     */
    protected $postcode;

    /**
     * @var float
     */
    protected $number;

    /**
     * @var float
     */
    protected $street;

    /**
     * @var float
     */
    protected $district;

    /**
     * @var float
     */
    protected $city;

    /**
     * @var float
     */
    protected $state;

    /**
     * @var float
     */
    protected $country;

    /**
     * @param $postcode
     * @return $this
     */
    public function setPostcode($postcode)
    {
        $postcode = preg_replace('/[^0-9]/', '', $postcode);

        if (strlen($postcode) > 0) {
            $postcode = substr($postcode, 0, 5) . '-' . substr($postcode, 5, 3);
        }

        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @param $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @param $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @param $district
     * @return $this
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @param $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompleteAddress()
    {
        $address = '';

        if ($this->street) {
            $address .= $this->street;
        }

        if ($this->number) {
            $address .= $this->getComma($address) . $this->number;
        }

        if ($this->city) {
            $address .= $this->getComma($address) . $this->city;
        }

        if ($this->state) {
            $address .= $this->getComma($address) . $this->state;
        }

        if ($this->postcode) {
            $address .= $this->getComma($address) . $this->postcode;
        }

        if ($this->country) {
            $address .= $this->getComma($address) . $this->country;
        }

        return trim($address);
    }

    /**
     * @param $address
     * @return string
     */
    private function getComma($address)
    {
        return strlen($address) > 0 ? ', ' : '';
    }
}