<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Map_model extends CI_Model {

	function __construct() {
		parent::__construct();
        $this->load->library('googlemaps');
	}
    public function iniMap($products) {
		$config = array();
        
        $config['center']='42.350148, -71.107600';
        
        $config['zoom'] = 16;

        
        
        $this->googlemaps->initialize($config);
        
        
        foreach ($products as $product) {
            $marker = array();
            $marker['position'] = ''.$product['lat'].','.$product['lng'];
            $marker['infowindow_content'] = $product['desc'].'</br>Status:'.$product['status'].'</br>'.$product['coment'];
            $marker['animation'] = 'DROP';
            $this->googlemaps->add_marker($marker);
        }
        
        $Map = $this->googlemaps->create_map();
        

		return $Map;
	}
    
    public function iniMapC($products) {
		$config = array();
        
        $config['center']='42.350148, -71.107600';
        
        $config['zoom'] = 16;

        $config['onclick'] = 'createMarker_map({ map: map, position:event.latLng });
        alert(\'You just clicked at: \' + event.latLng.lat() + \', \' + event.latLng.lng());';
        
        
        $this->googlemaps->initialize($config);
        
        
        foreach ($products as $product) {
            $marker = array();
            $marker['position'] = ''.$product['lat'].','.$product['lng'];
            $marker['infowindow_content'] = $product['desc'].'</br>Status:'.$product['status'].'</br>'.$product['coment'];
            $marker['animation'] = 'DROP';
            $this->googlemaps->add_marker($marker);
        }
        
        $Map = $this->googlemaps->create_map();
        

		return $Map;
	}
    
    
    public function CommentParser($products,$reports) {
        $productss = array();
        foreach ($products as $product) {
            $CTable ='';
            foreach ($reports as $report){
                if($product['name'] === $report['name'] ){
                    $comment = $report['desc'];
                    $CTable.= $comment.'</br>';
                }
            }
            $product['coment'] .= $CTable;
            $productss[] = $product;
        }
        return $productss;
    }

	

}