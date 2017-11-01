<?php
require_once( '../../../wp-load.php' );
global $wpdb;
	if( !wp_verify_nonce( $_POST['_wpnonce'], 'get-csv-file' ) ) exit;
	$file_name = 'zal_xml.xml';
	$file_src    = $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/wp-reservation-place/xml/'.$file_name;
	
	$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
	$options = get_option('options-reservation-place-'.$_POST['zalid']);
	$name_zal = $options['name'];
	$cols = $options['cols'];
	$rows = $options['rows'];
	$cnt_tarif = count($options['tariffs']);
	
	$place = get_option('list-reservation-place-'.$_POST['zalid']);
	
	if($rows&&$cols){
		$xml .= "<places>\n";
		for($r=0;$r<=$rows;$r++){
				$xml .= "\t<ROW>\n";
				for($c=1;$c<=$cols;$c++){
					$xml .= "\t\t<COL>\n";
					$xml .= "\t\t\t<place r='$r' c='$c'>\n";					
						
						if($place['price'][$r.'-'.$c]) $xml .= "\t\t\t\t<price>".$place['price'][$r.'-'.$c]."</price>\n";						
						if($place['name'][$r.'-'.$c]) $xml .= "\t\t\t\t<name>".$place['name'][$r.'-'.$c]."</name>\n";

					$xml .= "\t\t\t</place>\n";
					$xml .= "\t\t</COL>\n";
				}
				$xml .= "\t</ROW>\n";
		}
		$xml .= "</places>";
	}

	$f = fopen($file_src, 'w');	
	if(!$f)exit;
	fwrite($f, $xml);
	fclose($f);
	
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="'.$file_name.'"');
	header('Content-Type: text/xml; charset=utf-8');
	//while(@ob_get_clean());
	readfile($file_src);
	exit;
?>