# google-location

Retrieve location data from Google using PHP

```php
<?php
$coordinates = (new \GSoares\Google\Location\CoordinatesLocator())
    ->setStreet('Marechal Rondon')
    ->setNumber('998')
    ->setDistrict('Barreiros')
    ->setCity('Sao Jose')
    ->setState('Santa Catarina')
    ->setPostcode('88117030')
    ->setCountry('Brasil')
    ->locate();
    
//OR using single parameters...

$coordinates = (new \GSoares\Google\Location\CoordinatesLocator())
    ->setPostcode('88117030')
    ->locate();
    
/* 
RETURNS:

object(GSoares\Google\Location\Address\Coordinates)#6 (2) {
  ["latitude"]=>
  string(11) "-27.5818202"
  ["longitude"]=>
  string(11) "-48.6039563"
}
*/
?>
```


Requirements
----------

* PHP 5.4+

Install (composer)
----------

* https://packagist.org/packages/gabrielfs7/google-location
