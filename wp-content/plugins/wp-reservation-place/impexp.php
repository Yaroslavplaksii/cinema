<?php
require_once( '../../../wp-load.php' );
global $wpdb;
	if( !wp_verify_nonce( $_POST['_wpnonce'], 'get-csv-file' ) ) exit;
	$file_name = 'file_xml.xml';
	$file_src    = WP_CONTENT_DIR.'/plugins/wp-reservation-place/xml/'.$file_name;
	
	$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
	$orders = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_orders_history WHERE res_session = '".$_POST['session']."' AND res_status IN (1,4) AND res_zalid = '".$_POST['zalid']."' ORDER BY ID DESC");
	
	$inv_id = 0;
	$xml .= "<posts>\n";
	//$xml .= '<th>Заказ ID</th><th>Пользователь</th><th>Сумма заказа</th><th>Дата и время</th><th>Статус</th><th>Действие</th>';
	foreach((array)$orders as $order){
		if($inv_id == $order->res_order) continue;
		
			$xml .= "<post>\n";
			
			$inv_id = $order->res_order;
			
			$x = 0;
			foreach((array)$orders as $sing_order){
				if($inv_id == $sing_order->res_order){
					$sumprise[$inv_id] += $sing_order->res_price;
					if(++$x>1) $place[$inv_id] .= ',';
					$place[$inv_id] .= $sing_order->place_name;
				}			
			}
			
			switch($order->res_status){
				case 0: $status = 'Не оплачен'; break;
				case 1: $status = 'SALE'; break;
				case 2: $status = 'Просрочен'; break;
				default: $status = 'BRON';
			}
			
			$time = substr($order->timeaction, -9);
			$date = substr($order->timeaction, 0, 10);

			$xml .= "<ID>".$inv_id."</ID>\n";
			$xml .= "<EMAIL><![CDATA[".$order->user_email."]]></EMAIL>\n";
			$xml .= "<ZAL><![CDATA[".$order->zal_name."]]></ZAL>\n";
			$xml .= "<PLACE><![CDATA[".$place[$inv_id]."]]></PLACE>\n";
			$xml .= "<SESSION><![CDATA[".$order->res_session."]]></SESSION>\n";
			$xml .= "<SUMMA><![CDATA[".$sumprise[$inv_id]."]]></SUMMA>\n";
			$xml .= "<DATE><![CDATA[".$date."]]></DATE>\n";
			$xml .= "<STATUS><![CDATA[".$status."]]></STATUS>\n";
						
			/*$table .= '<tr id="row-'.$inv_id.'"><td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$inv_id.'">Заказ '.$inv_id.'</a></td><td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&user='.$order->user_email.'">'.$order->user_email.'</a></td><td>'.$sumprise[$inv_id].'</td><td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&date='.$date.'">'.$date.'</a>'.$time.'</td><td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&status='.$order->res_status.'"><span class="change-'.$inv_id.'">'.$status.'</span></a></td><td>'.$delete.'</td></tr>';*/

			$xml .= "</post>\r";				
	}
	$xml .= "</posts>";	
	
	/*$sql_field = explode(',',$sql_field);
	$cnt = count($sql_field);
	
	if($posts){	
	$xml .= "<posts>\n";
		foreach($posts as $post){
			$xml .= "<post>\n";
			for($a=0;$a<$cnt;$a++){
				$xml .= "<".$sql_field[$a].">";
				if($a==0) $xml .= $post->$sql_field[$a];
				else $xml .= "<![CDATA[".$post->$sql_field[$a]."]]>";
				$xml .= "</".$sql_field[$a].">\n";	
			}
			foreach ($postmeta as $key){
				if (strpos($key->meta_key, "goods_id") === FALSE && strpos($key->meta_key , "_") !== 0){
					if($_POST[$key->meta_key]==1){
						$xml .= "<".$key->meta_key.">";
						$xml .= "<![CDATA[".get_post_meta($post->ID, $key->meta_key, true)."]]>";
						$xml .= "</".$key->meta_key.">\n";	
					}
				}
			}
			$xml .= "</post>\r";
		}
	$xml .= "</posts>";
	}*/

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
