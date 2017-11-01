<?php
add_action('admin_menu', 'admin_kassa_panel');
function admin_kassa_panel(){
	add_submenu_page( 'options-wp-reservation', 'Касса', 'Касса', 'edit_others_posts', 'manage-admin-sale', 'manage_admin_sale');
}

function manage_admin_sale(){
	global $post;
	
	wp_reservation_style_frontend();
	
	$posts = get_posts(array('post_type'=>'action','numberposts'=>-1,'post_status'=>'publish'));
	
	if(!$posts){
		echo '<h3>Мероприятия не найдены!</h3>';
		return false;
	}
	
	$content = '<style>
		#cart-reservation{margin:20px 0;}
		#cart-reservation td{border:1px solid #333;padding:5px;}
	</style>';
	
	$content .= '<h2>Бронирование мест администратором</h2>
	<p>Вы можете создать заказ и забронировать нужные места на этой странице.<br>
	Выберите мероприятие и время его посещения, выберите нужные места и сформируйте заказ.<br>
	Выбранные места будут забронированы и будут недоступны для выбора в дальнейшем.</p>
	<form action="'.get_bloginfo('wpurl').'/wp-admin/admin.php" method="get">
	<select name="action-id">';
	foreach($posts as $post){
		$content .= '<option value="'.$post->ID.'">'.$post->post_title.'</option>';
	}
	$content .= '</select>
	<input type="hidden" name="page" value="manage-admin-sale">
	<input type="submit" value="Получить конфигурацию">
	</form>';

	if(isset($_GET['action-id'])){
		$post = get_post($_GET['action-id']);
		setup_postdata($post);
		$content .= get_content_action_placelist($_GET['action-id']);
	}
	
	if(isset($_GET['form-cart'])){
		$content .= get_cart_data();
	}
	
	echo $content;
}

function get_admin_minicart_data(){

	foreach((array)$_SESSION['order-place'] as $id => $ses_val){
		foreach($ses_val as $session => $value){
			$count_place_minicart += count($value);
		}
	}
	
	$mini .= '<div style="margin:20px 0;">
	<form>В корзине: ';
	if(!$count_place_minicart) $count_place_minicart = 0;		
	else $display = 'style="display:initial;"';
	$mini .= '<span id="count-place">'.$count_place_minicart.'</span> мест
	<input type="submit" id="cart-link" '.$display.' value="Оформить заказ">
	<input type="hidden" name="page" value="manage-admin-sale">
	<input type="hidden" name="form-cart" value="1">
	</form>
	</div>';
	
	return $mini;
}