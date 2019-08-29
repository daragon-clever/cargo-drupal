<?php
namespace Drupal\storelocator\Controller;


use Drupal\Core\Controller\ControllerBase;

class ShopController extends ControllerBase
{
    public function getShops($lat,$lng,$radius)
    {
        $center_lat = $lat;
        $center_lng = $lng;

        $dom = new \DOMDocument();
        $dom->load('sites/cestdeuxeuros/files/locations/locations.xml');

        $list_elements = $dom->getElementsByTagName('marker');

        header('Content-Type: text/xml');
        echo ('<markers>');

        foreach($list_elements as $marker){
            $distance = $this->haversineGreatCircleDistance($center_lat, $center_lng, $marker->getAttribute('lat'), $marker->getAttribute('lng'));
            $marker->setAttribute("distance", $distance);

            if(doubleval($distance)<=doubleval($radius)) echo $marker->ownerDocument->saveXML($marker);
        }

        echo ('</markers>');
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthMeanRadius = 6371)
    {
        $deltaLatitude = deg2rad($latitudeTo - $latitudeFrom);
        $deltaLongitude = deg2rad($longitudeTo - $longitudeFrom);
        $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
            cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) *
            sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthMeanRadius * $c;
    }
}