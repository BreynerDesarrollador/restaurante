<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class convertixmlController extends Controller
{
    function array_to_xml(array $arr, \SimpleXMLElement $xml)
    {

        foreach ($arr as $k => $v) {
            is_array($v)
                ? $this->array_to_xml($v, $xml->addChild($k))
                : $xml->addChild($k, $v);
        }
        $con=count($xml->children());
        $xml->addChild('con',$con);
        return $xml;
    }
}
