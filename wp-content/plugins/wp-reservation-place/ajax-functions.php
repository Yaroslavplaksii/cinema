<?php
function add_place_in_basket(){
	global $post;

	$idplace = $_POST['idplace'];
	$session = $_POST['session'];
	$zalid = $_POST['zalid'];
	$post_id = $_POST['post_id'];
	$count_place_minicart = 0;
	
	$max_place = get_option('wprp_max_place_cart');
	
	if(isset($_SESSION['order-place'])){
		foreach($_SESSION['order-place'] as $id => $ses_data){
			foreach($ses_data as $ses => $val){
				$count_place_minicart += count($val);
			}
		}
	}
	
	++$count_place_minicart;
	
	if($max_place&&$count_place_minicart>$max_place){
		$log['max'] = $max_place;
		$log['recall'] = 200;
		echo json_encode($log);	
		exit;
	}
	
	$_SESSION['order-place'][$zalid][$session][$idplace] = $post_id;	
	$log['place'] = $idplace;
	$log['count'] = $count_place_minicart;
	$log['recall'] = 100;
	echo json_encode($log);	
    exit;
}
add_action('wp_ajax_add_place_in_basket', 'add_place_in_basket');
add_action('wp_ajax_nopriv_add_place_in_basket', 'add_place_in_basket');

function delete_place_in_basket(){
	$idplace = $_POST['idplace'];
	$session = $_POST['session'];
	$zalid = $_POST['zalid'];
	unset($_SESSION['order-place'][$zalid][$session][$idplace]);
	//$_SESSION['order-place'][$zalid][$session][$idplace] = '';
	/*foreach($_SESSION['order-place'][$zalid][$session] as $key => $value){
		if($value!=$idplace) $order['order-place'][$key] = $key;		
	}*/
	
	//$_SESSION['order-place'][$zalid][$session] = '';
	//$_SESSION['order-place'][$zalid][$session] = $order['order-place'];	
	foreach($_SESSION['order-place'][$zalid] as $ses => $val){
		$count_place_minicart += count($val);		
	}
	//print_r($_SESSION);
	$log['place'] = $idplace;
	$log['count'] = $count_place_minicart;
	$log['recall'] = 100;
	echo json_encode($log);	
    exit;
}
add_action('wp_ajax_delete_place_in_basket', 'delete_place_in_basket');
add_action('wp_ajax_nopriv_delete_place_in_basket', 'delete_place_in_basket');

function delete_place_out_cart_page(){
	$idplace = $_POST['idplace'];
	$session = $_POST['session'];
	$zalid = $_POST['zalid'];
	foreach($_SESSION['order-place'][$zalid][$session] as $key => $value){
		if($key!=$idplace) $order['order-place'][$key] = $value;		
	}
	
	$_SESSION['order-place'][$zalid][$session] = '';
	$_SESSION['order-place'][$zalid][$session] = $order['order-place'];	
	foreach($_SESSION['order-place'][$zalid] as $ses => $val){
		$count_place_minicart += count($val);		
	}
	
	$log['place'] = $idplace;
	$log['session'] = $session;
	$log['count'] = $count_place_minicart;
	$log['recall'] = 100;
	echo json_encode($log);	
    exit;
}
add_action('wp_ajax_delete_place_out_cart_page', 'delete_place_out_cart_page');
add_action('wp_ajax_nopriv_delete_place_out_cart_page', 'delete_place_out_cart_page');

function get_empty_basket(){
	session_destroy();
	$log['recall'] = 100;
	echo json_encode($log);	
    exit;
}
add_action('wp_ajax_get_empty_basket', 'get_empty_basket');
add_action('wp_ajax_nopriv_get_empty_basket', 'get_empty_basket');

function confirm_order_reservation(){

	global $wpdb;
	$time_action = date("Y-m-d H:i:s");
	$_POST = stripslashes_deep($_POST);
	$count = $_POST['count'];
	$is_admin = (isset($_POST['admin']))? true: false;
	if(!$is_admin) $get_fields = get_option( 'wp_reservation_orders_field' );	
	$requared = true;
	$correctemail = true;
	
	if($is_admin) $email_user = 'admin';
	
	if($get_fields){	
		foreach((array)$get_fields as $custom_field){				
			$slug = str_replace('-','_',$custom_field['slug']);
			if($custom_field['req']==1){
				if($custom_field['type']=='checkbox'){
					$chek = explode('#',$custom_field['field_select']);
					$count_field = count($chek);
					for($a=0;$a<$count_field;$a++){
						$slug_chek = $slug.'_'.$a;
						if($_POST[$slug_chek]=='undefined'){
							$requared = false;
						}else{
							$requared = true;
							break;
						}
					}
				}else{
					if(!$_POST[$slug]) $requared = false;	
				}									
			}
			if($custom_field['type']=='email'&&$_POST[$slug]){
				$email_user = $_POST[$slug];
				$correctemail = is_email($email_user);					
			}			
		}
					
		if(!$correctemail){
			$res['otvet']=5;
			$res['recall'] .= '<p style="text-align:center;color:red;">Ви ввели не правильний email!</p>';
			echo json_encode($res);	
			exit;
		}
	}
		
	if($requared&&$correctemail){

		if(get_option('qr_code_wprp')) include('a-qr-code/a-qr-code.php');
			
			if($get_fields){
				foreach((array)$get_fields as $custom_field){				
					$slug = str_replace('-','_',$custom_field['slug']);
						if($custom_field['type']=='text'&&$_POST[$slug]||$custom_field['type']=='email'&&$_POST[$slug])
							$order_custom_field .= '<p><b>'.$custom_field['title'].':</b> <span>'.$_POST[$slug].'</span></p>';
						if($custom_field['type']=='select'&&$_POST[$slug]||$custom_field['type']=='radio'&&$_POST[$slug])
							$order_custom_field .= '<p><b>'.$custom_field['title'].':</b> <span>'.$_POST[$slug].'</span></p>';
						if($custom_field['type']=='checkbox'){
							$chek = explode('#',$custom_field['field_select']);
							$count_field = count($chek);					
							$n=0;
							for($a=0;$a<$count_field;$a++){
								$slug_chek = $slug.'_'.$a;
								if($_POST[$slug_chek]!='undefined'){
								$n++;
									if($n==1) $chek_field .= $_POST[$slug_chek];
										else $chek_field .= ', '.$_POST[$slug_chek];
								}
							}
							if($n!=0) $order_custom_field .= '<p><b>'.$custom_field['title'].': </b>'.$chek_field.'</p>';
						}					
						if($custom_field['type']=='textarea'&&$_POST[$slug])
							$order_custom_field .= '<p><b>'.$custom_field['title'].':</b></p><p>'.$_POST[$slug].'</p>';
				}
			}
			
			$zal_array = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."options WHERE option_name LIKE 'options-reservation-place%'");
						
			foreach((array)$zal_array as $zal_data){
				$id_form = preg_replace("/[a-z_-]+/", '', $zal_data->option_name);
				$options = get_option('options-reservation-place-'.$id_form);
				$place = get_option('list-reservation-place-'.$id_form);
				$cols = $options['cols'];
				$rows = $options['rows'];
						
				for($i=1;$i<=$count;$i++){
					if($_POST['idplace-'.$i]){				
						if(!$place['status']) break;
						if($_POST['zalid-'.$i]!=$id_form) break;
						if($place['status'][$_POST['session-'.$i]][$_POST['idplace-'.$i]]=='closed'){
							$log['otvet']=5;
							$log['recall'] = '<p style="text-align:center;color:red;">Одне або кілька місць вибраних вами вже заброньовані іншими користувачами. ПОверніться назад і виберіть місця знову.</p>';
							session_destroy();
							echo json_encode($log);							
							exit;
						}
					}
				}
			}

			$a=0;
			$order_id = false;
			
				$connect_sale = (!$is_admin)? get_option('wp_reservation_connect_sale') : false;
				
				foreach((array)$zal_array as $zal_data){
					$id_form = preg_replace("/[a-z_-]+/", '', $zal_data->option_name);
					$options = get_option('options-reservation-place-'.$id_form);
					$place = get_option('list-reservation-place-'.$id_form);
					$cols = $options['cols'];
					$rows = $options['rows'];
					$new_place = array();
							
					for($i=1;$i<=$count;$i++){
					
						if($_POST['idplace-'.$i]&&$_POST['zalid-'.$i]==$id_form){
						
							for($r=0;$r<=$rows;$r++){
								for($c=1;$c<=$cols;$c++){
									if($r==0){
									}else{					
										if($_POST['idplace-'.$i]==$r.'-'.$c){
											
											$sess = explode('#',$_POST['session-'.$i]);
											$date = $sess[0];
											$time = $sess[1];
											$margin = wrp_get_margin_price($_POST['post-'.$i],$time);								
											$price_margin = $place['price'][$r.'-'.$c] + $margin;
											
											if($options['view-rows']) $order_data[$a]['row'] = (isset($place['rows'][$r]))? $place['rows'][$r]: $r;
											$order_data[$a]['session'] = $_POST['session-'.$i];
											$order_data[$a]['zalid'] = $_POST['zalid-'.$i];
											$order_data[$a]['comment'] = $_POST['comment-'.$i];
											$order_data[$a]['zal_name'] = $options['name'];
											$order_data[$a]['place'] = $place['name'][$r.'-'.$c];
											$order_data[$a]['price'] = $price_margin;
											$sumprise += $order_data[$a]['price'];
										}
									}
									if($price) break;
								}
								if($price) break;
							}

							if($connect_sale) $res_status = 0;
							else $res_status = 4;
							
							$comm = ($order_data[$a]['row'])? $order_data[$a]['comment'].' Ряд:'.$order_data[$a]['row']: $order_data[$a]['comment'];
							
							if(!$order_id){
								$order_max = $wpdb->get_var("SELECT MAX(res_order) FROM ".WP_PREFIX ."reservation_orders_history");
								if($order_max) $order_id = $order_max+1;
								else $order_id = rand(0,1000);
							}
							
							$data = array( 
								'res_order' => $order_id,
								'user_email' => $email_user,
								'res_zalid' => $order_data[$a]['zalid'],
								'zal_name' => $options['name'], 									
								'res_session' => $order_data[$a]['session'], 
								'res_place' => $_POST['idplace-'.$i], 
								'place_name' => $order_data[$a]['place'], 
								'res_price' => $order_data[$a]['price'],
								'comment_place' => $comm,
								'timeaction' => $time_action,
								'res_status' => $res_status
								);
							
							$row = $wpdb->insert( WP_PREFIX ."reservation_orders_history",  $data );								
							if(!$row){
								
								foreach($data as $k=>$v){
									$errs[] = $k.':'.$v;
								}
								
								$log['otvet']=5;
								$log['recall'] = '<p style="text-align:center;color:red;">Створення замовлення не вдалося! Повідомте адміністрацію сайту і передайте код помилки:<br>'.implode(';',$errs).'</p>';
								echo json_encode($log);		
								exit;
							}
								
							$new_place[$order_data[$a]['session']][$_POST['idplace-'.$i]] = 'closed';
							
							$a++;							 
						}
					}
					
					if($new_place){
						foreach($new_place as $ses=>$pl_data){
							foreach($pl_data as $pl=>$stat){
								$place['status'][$ses][$pl] = $stat;
							}
						}
					}
					
					update_option('list-reservation-place-'.$id_form, $place);
				}
				
				$wpdb->insert(
					WP_PREFIX ."reservation_details_orders",
					array(
					'order_id'=>$order_id,
					'details_order'=>$order_custom_field)
				);
			
			$table_order .= '<table class="order-form">
			<tr>
				<th><b>№ п/п</b></th>
				<th><b>Назва фільма</b></th>
				<th><b>Зал</b></th>
			
				<th><b>Заброньованні місця</b></th>
				<th><b>Час сеансу</b></th>
				<th><b>Вартість</b></th>
			</tr>';
			foreach((array)$order_data as $order){
				++$n;
				$rowname = ($order['row'])? 'Ряд: '.$order['row']: '';
				$table_order .= '<tr align="center">
					<td style="padding:5px;">'.$n.'</td>
					<td style="padding:5px;">'.$order['comment'].'</td>
					<td style="padding:5px;">'.$order['zal_name'].'</td>
				
					<td style="padding:5px;">'.$order['place'].'</td>
					<td style="padding:5px;">'.$order['session'].'</td>
					<td style="padding:5px;">'.$order['price'].' грн.</td>
				</tr>';						
			}
			$table_order .= '<tr><td>Сума замовлення</td><td>'.$sumprise.' грн.</td></tr></table>';
			
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			$headers = 'From: '.get_bloginfo('name').' <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
			$subject = 'Сформовано замовлення!';
			
			if(!$connect_sale){
				
				//$allplace = $wpdb->get_results("SELECT res_session,res_place,res_zalid FROM ".WP_PREFIX."reservation_orders_history WHERE res_order = '$order_id'");
				if(!$is_admin){
					$email = get_the_author_meta('display_name',$user_ID);			
					$textmail = '
					<p>Ви сформували замовлення на "'.get_bloginfo('name').'".</p>
					<h3>Дані вказані при оформленні:</h3>
					'.$order_custom_field.'
					<p>Замовлення №'.$order_id.' отримало статус "Виконане", місця по вашому замовленні було заброньовано.</p>
					<h3>Деталі замовлення:</h3>
					'.$table_order;	
					if (function_exists('aQRCode')) { 
						$textmail .= '<p>Завантажте і роздрукуйте свій білет (QR-code). Для підтвердження вашого замовлення пред\'явіть його при вході в кінозал.</p>';
						$url_attach = aQRCode('Замовлення №'.$order_id);
						$attach = array($url_attach);
					}				
					wp_mail($email_user, $subject, $textmail, $headers, $attach);
					
					$log['redirectform'] = "<p class='res_confirm' style='border:1px solid #ccc;font-weight:bold;padding:10px;'>Ви підтвердили бронювання замовлених вами мість!<br />Вказані в замовленні місця були заброньовані, ви можете підтвердити це вказавши реквізити вашого замовлення, висланні на вашу пошту.</p>";
				}else{
					$log['redirectform'] = "<p class='res_confirm' style='border:1px solid #ccc;font-weight:bold;padding:10px;'>Замовлення було створено, місця по замовленню були заброньованні</p>";
				}
				
			}else{
			
				$email = get_the_author_meta('display_name',$user_ID);			
				$textmail = '
				<p>Ви сформували замовлення на "'.get_bloginfo('name').'".</p>
				<h3>Дані вказані при оформленні:</h3>
				'.$order_custom_field.'
				<p>Замовлення №'.$order_id.' отримало статус "не оплачено",.</p>
				<h3>Деталі замовлення:</h3>
				'.$table_order;				
				wp_mail($email_user, $subject, $textmail, $headers);
			
			if($connect_sale==1){ //если используется робокасса
					$out_summ = $sumprise;
					$mrh_login = get_option('wp_reservation_robologin'); 
					$mrh_pass1 = get_option('wp_reservation_onerobopass'); 
					$shpb = 2; //тип платежа. 1 - пополнение личного счета, 2 - оплата заказа
					$shp_item = "2";  
					$culture = "ru"; 

					$crc = md5("$mrh_login:$out_summ:$order_id:$mrh_pass1:Shp_item=$shp_item:shpa=$email_user"); 

					if(get_option('wp_reservation_robotest')==1) $formaction = 'http://test.robokassa.ru/Index.aspx';
					if(get_option('wp_reservation_robotest')==0) $formaction = 'https://merchant.roboxchange.com/Index.aspx';

					$log['redirectform'] = "
					<p class='res_confirm' style='border:1px solid #ccc;font-weight:bold;padding:10px;'>Ви підтвердили купівлю білетів!<br />Залишилось лише їх оплатити.<br />Оплатіть своє замовлення за допомогою доступних платіжних систем.</p>
					<form action='".$formaction."' method=POST><input type=hidden name=MrchLogin value=$mrh_login><input type=hidden name=OutSum value=$out_summ><input type=hidden name=InvId value=$order_id><input type=hidden name=shpa value=$email_user><input type=hidden name=SignatureValue value=$crc><input type=hidden name=Shp_item value='$shp_item'><input type=hidden name=IncCurrLabel value=$in_curr><input type=hidden name=Culture value=$culture><input type=submit class='recall-button' value='Оплатити через платіжні системи'></form>";
					$log['otvet']=100;
			}
			if(get_option('wp_reservation_connect_sale')==2){ //если используется интеркасса
			
					$ik_am = $sumprise;
					$ik_co_id = get_option('wp_reservation_interidshop');
					$ik_pm_no = $order_id;
					$ik_desc = 'Пополнение личного счета пользователя';
					$ik_x_user_id = $email_user;
					$test = get_option('wp_reservation_intertest');
					$key = get_option('wp_reservation_intersecretkey');

					if($test==1){				
						$ik_pw_via = 'test_interkassa_test_xts';
						$data['ik_pw_via'] = $ik_pw_via;
						$test_input = "<input type='hidden' name='ik_pw_via' value='$ik_pw_via'>";				
					}
							
					$data['ik_am'] = $ik_am;
					$data['ik_co_id'] = $ik_co_id;
					$data['ik_pm_no'] = $ik_pm_no;
					$data['ik_desc'] = $ik_desc;
					$data['ik_x_user_id'] = $ik_x_user_id;		

					ksort ($data, SORT_STRING);
					array_push($data, $key);
					$signStr = implode(':', $data);			
					$ik_sign = base64_encode(md5($signStr, true));

					$log['redirectform'] = "<p class='res_confirm' style='border:1px solid #ccc;font-weight:bold;padding:10px;'>Ви підтвердили купівлю білетів!<br />Залишилось лише їх оплатити.<br />Оплатіть своє замовлення через платіжні системи.</p>
					<form action='https://sci.interkassa.com/' method='POST'>
						".$test_input."
						<input type='hidden' name='ik_co_id' value='$ik_co_id'>
						<input type='hidden' name='ik_am' value='$ik_am'>
						<input type='hidden' name='ik_pm_no' value='$ik_pm_no'>
						<input type='hidden' name='ik_desc' value='$ik_desc'>
						<input type='hidden' name='ik_x_user_id' value='$ik_x_user_id'>
						<input type='hidden' name='ik_sign' value='$ik_sign'>
						<input type='submit' value='Підтвердити запит'>
					</form>";
					
					$log['otvet']=100;
			}
		
			}
			
			if(!$is_admin){
				$args = array(
						'role' => 'administrator'
					);
				$users = get_users( $args );				
				
				$textmail = '
				<p>Користувач оформив замовлення на "'.get_bloginfo('name').'".</p>
				<h3>Дані вказанні при оформленні:</h3>
				'.$order_custom_field.'
				<p>Замовлення №'.$order_id.' отримало статус "Виконане", місця по вашому запиту були заброньованні.</p>
				<h3>Деталі замовлення:</h3>
				'.$table_order.'
				<p>Посилання в адмінці на деталі замовлення:</p>  
				<p>'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$order_id.'</p>';
				
				$admin_email = get_option('admin_email_magazin_recall');
				if($admin_email){
					wp_mail($admin_email, $subject, $textmail, $headers);
				}else{
					foreach((array)$users as $userdata){
						$email = $userdata->user_email;									
						wp_mail($email, $subject, $textmail, $headers);
					}
				}	
			}
			
			$log['otvet']=100;
			session_destroy();

	}else{
		$log['otvet']=5;
		$log['recall'] = '<p style="text-align:center;color:red;">Будь-ласка, заповніть всі обов\'язкові поля, відмічені зірочкою!</p>';	
	}
	
	echo json_encode($log);		
    exit;
}
add_action('wp_ajax_confirm_order_reservation', 'confirm_order_reservation');
add_action('wp_ajax_nopriv_confirm_order_reservation', 'confirm_order_reservation');

function all_delete_order_reservation(){
	global $wpdb;
	$idorder = $_POST['idorder'];

	if($idorder){
	
		$res = wrp_delete_order($idorder);

		if($res){
			
			$log['otvet']=100;
			$log['idorder']=$idorder;
		}
	} else {
		$log['otvet']=1;
	}
	echo json_encode($log);		
	exit;
}
add_action('wp_ajax_all_delete_order_reservation', 'all_delete_order_reservation');
//add_action('wp_ajax_nopriv_all_delete_order_reservation', 'all_delete_order_reservation');