<?php

function payments_request_recall_magazine(){
	global $post;
	global $wpdb;
	if(get_option('qr_code_wprp')) include('a-qr-code/a-qr-code.php');
	if($post->ID==get_option('wp_reservation_page_result_pay')){	
		if(get_option('wp_reservation_connect_sale')==1){ //если используется робокасса
			$time_action = date("Y-m-d H:i:s");
			$mrh_pass2 = get_option('wp_reservation_tworobopass');
			$out_summ = $_REQUEST["OutSum"];
			$inv_id = $_REQUEST["InvId"];
			$shp_item = $_REQUEST["Shp_item"];
			$email_user = $_REQUEST["shpa"];
			$crc = $_REQUEST["SignatureValue"];			
			$crc = strtoupper($crc);

			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_item=$shp_item:shpa=$email_user"));

			if ($my_crc !=$crc){
			  echo "bad sign\n";
			  exit();
			}
			
			$pay = $wpdb->get_row("SELECT * FROM ".WP_PREFIX ."reservation_pay_results WHERE res_order = '$inv_id'");
			
			if($pay){
				$add_cashe = true;				
			}else{
			$results = $wpdb->insert( WP_PREFIX .'reservation_pay_results', 
						array( 'res_order' => "$inv_id", 'user_email'=>"$email_user", 'count_summ' => "$out_summ", 'timeaction' => "$time_action" )
						);
						
			if($results) $add_cashe = true;
				else wp_die('Запис в БД не вдалий!');
			}
			
			if($add_cashe){				
				
				$wpdb->update( WP_PREFIX ."reservation_orders_history", 
					array( 'res_status' => 1 ),
					array( 'res_order' => $inv_id)
				);
								
				$place_data = get_option('list-reservation-place');
				
				$allplace = $wpdb->get_results("SELECT res_session,res_place FROM ".WP_PREFIX."reservation_orders_history WHERE res_order = '$inv_id'");
				
				foreach($allplace as $place){
					$place_data['status'][$place->res_session][$place->res_place]='closed';
				}

				update_option('list-reservation-place', $place_data);
				
				//session_destroy();
				
				//Если работает реферальная система и партнеру начисляются проценты с покупок его реферала
				//if(function_exists('add_referall_incentive_order')) 
					//add_referall_incentive_order($user_ID,$out_summ);
				
				//Отправляем письмо об оплате админам
				$args = array(
					'role' => 'administrator'
				);
				$users = get_users( $args );

				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
				$headers = 'From: '.get_bloginfo('name').' <noreaply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
				$subject = 'Замовлення оплатили!';				
				$textmail = '
				<p>Користувач оплатив замовлення "'.get_bloginfo('name').'"</p>
				<h3>Інформація про користувача:</h3>
				<p>Замовлення №'.$inv_id.' отримало статус "Оплачено".</p>
				<p>Посилання для керування замовленням в адмін панелі:</p>  
				<p>'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$inv_id.'</p>';
				
				$admin_email = get_option('admin_email');				
				wp_mail($admin_email, $subject, $textmail, $headers);
				
				
				//Отправляем письмо об оплате покупателю				
				$textmail = '
				<p>Ви оплатили замовлення "'.get_bloginfo('name').'".</p>
				<h3>Інформація про користувача:</h3>
				<p>Замовлення №'.$inv_id.' отримало статус "Оплачено".</p>';
				if (function_exists('aQRCode')) { 
					$textmail .= '<p>Завантажте і роздрукуйте свій білет (QR-code). Для підтвердження вашого замовлення пред\'явіть його при вході в кінозал.</p>';
					$url_attach = aQRCode('Замовлення №'.$order_id);
					$attach = array($url_attach);
				}	
				$textmail .= '<p>Цей лист був створений автоматично, не потрібно відповідати на нього</p>';				
				wp_mail($email_user, $subject, $textmail, $headers,$attach);
				
				echo "OK$inv_id\n";
			}
		}
		
		if(get_option('wp_reservation_connect_sale')==2){ //если используется интеркасса
			
			$time_action = current_time('mysql');

			foreach ($_REQUEST as $key => $value) {
				if (!preg_match('/ik_/', $key)) continue;
				$data[$key] = $value;
			}

			$ikSign = $data['ik_sign'];
			unset($data['ik_sign']);

			if ($data['ik_pw_via'] == 'test_interkassa_test_xts') {
				$secret_key = get_option('wp_reservation_intertestkey');
			} else {
				$secret_key = get_option('wp_reservation_intersecretkey');
			}

			ksort ($data, SORT_STRING);
			array_push($data, $secret_key);
			$signStr = implode(':', $data);
			$my_sign = base64_encode(md5($signStr, true));	
			
			$ik_baggage_fields = $data['ik_x_user_id'];
			$order_id = $data["ik_pm_no"];
			$ik_payment_amount = $data["ik_am"];

			if ($my_sign !=$ikSign) exit();
			
			$pay = $wpdb->get_row("SELECT * FROM ".WP_PREFIX ."reservation_pay_results WHERE res_order = '$order_id'");
			
			if(!$pay){
				
					$wpdb->update( WP_PREFIX ."reservation_orders_history", 
						array( 'res_status' => 1 ),
						array( 'res_order' => $order_id)
					);
					
					
					//Если работает реферальная система и партнеру начисляются проценты с покупок его реферала
					//if(function_exists('add_referall_incentive_order')) 
						//add_referall_incentive_order($ik_baggage_fields,$ik_payment_amount);
					
					$args = array(
					'role' => 'administrator'
					);
					$users = get_users( $args );
					
					//Отправляем письмо об оплате админам
					add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
					$headers = 'From: '.get_bloginfo('name').' <noreaply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
					$subject = 'Замовлення оплачено!';				
					$textmail = '
					<p>Користувач оплатив замовлення "'.get_bloginfo('name').'" зі свого рахунку.</p>
					<h3>Інформація про користувача:</h3>
					<p><b>Email</b>: '.$ik_baggage_fields.'</p>
					<p>Замовлення №'.$order_id.' отримало статус "Оплачено".</p>
					<p>Посилання для керування замовлденням в адмін панелі:</p>  
					<p>'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$order_id.'</p>';
					
					$admin_email = get_option('admin_email');				
					wp_mail($admin_email, $subject, $textmail, $headers);

					//Отправляем письмо об оплате покупателю
					$email = $ik_baggage_fields;				
					$textmail = '
					<p>Ви оплатили замовлення "'.get_bloginfo('name').'" зі свого рахунку.</p>
					<h3>Інформація про користувача:</h3>
					<p><b>Email</b>: '.$ik_baggage_fields.'</p>
					<p>Замовлення №'.$order_id.' отримало статус "Оплачено".</p>';
					if (function_exists('aQRCode')) { 
						$textmail .= '<p>Завантажте і роздрукуйте свій білет (QR-code). Для підтвердження вашого замовлення пред\'явіть його при вході в кінозал.</p>';
						$url_attach = aQRCode('Заказ №'.$order_id);
						$attach = array($url_attach);
					}	  
					$textmail .= '<p>Цей лист був створений автоматично, не потрібно відповідати на нього</p>';				
					wp_mail($email, $subject, $textmail, $headers,$attach);
								
					$results = $wpdb->insert( WP_PREFIX .'reservation_pay_results', 
							array( 'res_order' => "$order_id", 'count_summ' => "$ik_payment_amount", 'timeaction' => "$time_action" )
						);											
			}
		}
	}
	
	if($post->ID==get_option('wp_reservation_page_success_pay')){
	
		if(get_option('wp_reservation_connect_sale')==1){ //если используется робокасса
		
			$order_id = $_REQUEST["InvId"];
			//$user_ID = $_REQUEST["shpa"];

		}
		
		if(get_option('wp_reservation_connect_sale')==2){ //если используется Интеркасса
		
			$order_id = $_REQUEST["ik_pm_no"];	

		}
	
		$results = $wpdb->get_row("SELECT * FROM ".WP_PREFIX ."reservation_pay_results WHERE res_order='$order_id'");
			
			if($results){

			wp_redirect(get_permalink(get_option('wp_reservation_page_successfully_pay'))); exit;
			
			} else {
				wp_die('Запис про платіж в базі даних не знайдено');
			}
	}
}

function payments_request_recall_magazine_activate(){
  if (isset($_REQUEST["InvId"])||isset($_REQUEST["ik_co_id"])){
    payments_request_recall_magazine();
  }
}
add_action('wp', 'payments_request_recall_magazine_activate');
?>
