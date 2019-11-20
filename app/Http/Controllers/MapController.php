<?php

namespace App\Http\Controllers;

use GMaps;

class MapController extends Controller
{
    public function index()
    {
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        GMaps::initialize($config);

        $marker = array();
        $marker['position'] = '10.7572225, 106.6622208';
        $marker['infowindow_content'] = '1 - Hello World!';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
        GMaps::add_marker($marker);
        $map = GMaps::create_map();
        return view('map')->with('map', $map);
    }
}
