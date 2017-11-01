<?php

function aQRCode($data, $ecc = 'M', $type = 'J', $size = '8', $version = null) 
{
    $params = array(
        'd' => $data,
        'e' => $ecc,
        't' => $type,
        's' => $size,
        'v' => $version,    
    );    
    
    $cache_id   = md5(serialize($params));
    $cache_file = $cache_id.($type=='J'?'.jpeg':'.png');
    
    if (is_writable(dirname(__FILE__).'/cache') && !is_readable(dirname(__FILE__).'/cache/'.$cache_file) ) {
        
        $qrcode_data_string   = urlencode($data);
        $qrcode_error_correct = $ecc;
        $qrcode_module_size   = $size;
        $qrcode_version       = $version;
        $qrcode_image_type    = $type;
        
        ob_start();
        require_once 'php/qr_img.php';
        $out = ob_get_contents();
        ob_end_clean();

        $cache = fopen(dirname(__FILE__).'/cache/'.$cache_file, 'w+');
        fwrite($cache, $out);
        fclose($cache);

    } elseif (!is_writable(dirname(__FILE__).'/cache')) {
        return '';
    }
    
	//return get_option('siteurl').'/wp-content/plugins/wp-reservation-place/a-qr-code/cache/'.$cache_file;
	return $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/wp-reservation-place/a-qr-code/cache/'.$cache_file;
}