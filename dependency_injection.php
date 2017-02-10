<?php
//Without dependency injection
class GoogleMaps
{
    public function getCoordinatesFromAddress($address) {
        return $address;
    }
}
class OpenStreetMap
{
    public function getCoordinatesFromAddress($address) {
        return $address;
    }
}
class StoreService
{
    public function getStoreCoordinates() {
        $geolocationService = new GoogleMaps();

        return $geolocationService->getCoordinatesFromAddress("ggggggggggg");
    }
}
$s = new StoreService;
echo $s->getStoreCoordinates();



//With dependency injection
interface GeolocationService {
    public function getCoordinatesFromAddress($address);
}
class GoogleMaps1 implements GeolocationService
{
    public function getCoordinatesFromAddress($address) {
        return $address."coordinates";
    }
}
class OpenStreetMap1 implements GeolocationService
{
    public function getCoordinatesFromAddress($address) {
        return $address."coordinates";
    }
}
class StoreService1 {
    private $geolocationService;

    public function __construct( $geolocationService) {
        $this->geolocationService = new $geolocationService;
    }

    public function getStoreCoordinates($value) {
        return $this->geolocationService->getCoordinatesFromAddress($value);
    }
}
$a = new StoreService1("GoogleMaps1");
echo $a->getStoreCoordinates("address");
