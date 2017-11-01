<?php
/*
Plugin Name: WP-Reservation-place
Plugin URI: http://wppost.ru
Description: 
Version: 2.9.10
Author: Plechev Andrey
Author URI: http://vk.com/device64
*/

/*  Copyright 2012  Plechev Andrey  (email : plechev.a {at} yandex.ru) */

include('core.php');
include('payments.php');

function wp_reservation_uninstall() {
global $wpdb;
	$wpdb->query("DROP TABLE ".WP_PREFIX ."reservation_orders_history");
	$wpdb->query("DROP TABLE ".WP_PREFIX ."reservation_pay_results");
	$wpdb->query("DROP TABLE ".WP_PREFIX ."reservation_details_orders");
	
	delete_option('wp_reservation_interidshop');
	delete_option('wp_reservation_intersecretkey');
	delete_option('wp_reservation_connect_sale');
	delete_option('wp_reservation_robologin');
	delete_option('wp_reservation_onerobopass');
	delete_option('wp_reservation_tworobopass');
	delete_option('wp_reservation_robotest');
	delete_option('wp_reservation_page_result_pay');
	delete_option('wp_reservation_page_success_pay');
	delete_option('wp_reservation_page_successfully_pay');	
	delete_option('wp_reservation_orders_field');
	delete_option('options-reservation-place');
	delete_option('list-reservation-place');
	delete_option(WP_PREFIX.'wprp');
}
register_uninstall_hook(__FILE__, 'wp_reservation_uninstall');

if (!session_id()) { session_start(); }

add_filter('widget_text', 'do_shortcode');

if(is_admin()):
	add_action('admin_head','wp_reservation_scripts_admin');
endif;

function datepicker_scripts(){
    wp_enqueue_style( 'datepicker', plugins_url('js/datepicker/style.css',__FILE__) );   
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    //wp_enqueue_script( 'init_datepicker', plugins_url('js/datepicker/datepicker-init.js',__FILE__), array('jquery-ui-datepicker') );
}

function wp_reservation_scripts_admin(){
	if($_GET['page']=='place-wp-reservation'||$_GET['page']=='manage-orderform-fields'){
		wp_enqueue_script('jquery');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('script_admin_wp_reservation', plugins_url('js/admin.js', __FILE__), array( 'jquery', 'thickbox', 'wp-color-picker' ), false, true);
		//wp_enqueue_script( 'field-date-js', 'Field_Date.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), time(), true );	
		wp_enqueue_style( 'style_admin_wp_reservation', plugins_url('css/admin.css', __FILE__) );
		wp_enqueue_style( 'wp-color-picker' ); 
	}
	//wp_enqueue_style( 'jquery-ui-datepicker' );	
	if($_GET['page']=='manage-orderform-fields') wp_enqueue_script( 'script_sortable_wp_reservation', plugins_url('js/sortable.js', __FILE__) );
}

if (!is_admin()):
	add_action('wp_enqueue_scripts', 'wp_reservation_style_frontend');
	//add_action('wp_enqueue_scripts', 'datepicker_scripts');
endif;

function wp_reservation_style_frontend(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('script_wp_reservation', plugins_url('js/scripts.js', __FILE__));	
	wp_enqueue_style( 'style_wp_reservation', plugins_url('css/style.css', __FILE__) );
}

add_action( 'init', 'register_posttype_action' );
function register_posttype_action(){

    $labels = array( 
        'name' => 'Міроприємства',
        'singular_name' => 'Міроприємства',
        'add_new' => 'Додати',
        'add_new_item' => 'Додати',
        'edit_item' => 'Редагувати',
        'new_item' => 'Нове',
        'view_item' => 'Перегляд',
        'search_items' => 'Пошук',
        'not_found' => 'Не знайдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon' => 'Батьківський',
        'menu_name' => 'Міроприємства'
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,        
        'supports' => array( 'title', 'editor','custom-fields','thumbnail','comments'),
        'taxonomies' => array( 'times' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 10,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'action', $args );
}

add_action( 'init', 'register_taxonomy_times' );
function register_taxonomy_times() {

    $labels = array( 
        'name' => 'Час',
        'singular_name' => 'Час',
        'search_items' => 'Пошук',
        'popular_items' => 'Популярні',
        'all_items' => 'Все',
        'parent_item' => 'Батьківський',
        'parent_item_colon' => 'Батьківський:',
        'edit_item' => 'Редагувати',
        'update_item' => 'Обновити',
        'add_new_item' => 'Додати нову',
        'new_item_name' => 'Нова категорія',
        'separate_items_with_commas' => 'Separate страна with commas',
        'add_or_remove_items' => 'Додати або видалити',
        'choose_from_most_used' => 'Виберіть для використання',
        'menu_name' => 'Час'
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'times', array('action'), $args );
}

add_action( 'init', 'register_taxonomy_type' );
function register_taxonomy_type() {

    $labels = array( 
        'name' => 'Тип',
        'singular_name' => 'Тип',
        'search_items' => 'Пошук',
        'popular_items' => 'Популярні',
        'all_items' => 'Все',
        'parent_item' => 'Батьківська',
        'parent_item_colon' => 'Батьківська:',
        'edit_item' => 'Редагувати',
        'update_item' => 'Обновити',
        'add_new_item' => 'Додати нову',
        'new_item_name' => 'Новя категорія',
        'separate_items_with_commas' => 'Separate страна with commas',
        'add_or_remove_items' => 'Додати або видалити',
        'choose_from_most_used' => 'Виберіть для використання',
        'menu_name' => 'Тип'
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'type', array('action'), $args );
}

// создаем колонку товарных категорий
add_filter('manage_edit-action_columns', 'add_action_column', 10, 1);  
function add_action_column( $columns ){  
    $columns['type'] = 'Тип'; 
    return $columns;  
}  
  
// заполняем колонку данными  
add_filter('manage_action_posts_custom_column', 'fill_type_column', 10, 2);
function fill_type_column($column_name, $post_id) {  
    if( $column_name != 'type' )  
        return;  
  
    $cur_terms = get_the_terms( $post_id, 'type' );  
		foreach((array)$cur_terms as $cur_term){  
			echo '<a href="./edit.php?post_type=action&type='. $cur_term->slug .'">'. $cur_term->name .'</a><br />'  ;
		}   
}
// добавляем возможность сортировать колонку  
add_filter('manage_edit-action_sortable_columns', 'add_type_sortable_column');  
function add_type_sortable_column($sortable_columns){  
        $sortable_columns['type'] = 'type_type';  
        return $sortable_columns;  
}

// создаем колонку миниатюр
add_filter('manage_edit-action_columns', 'add_action_thumb_column', 10, 1);  
function add_action_thumb_column( $columns ){   
	$out = array();  
    foreach((array)$columns as $col=>$name){  
        if(++$i==3)  
             $out['thumb'] = 'Мініатюра';  
        $out[$col] = $name;  
    }   
    return $out;   
  
}  
  
// заполняем колонку миниатюр  
add_filter('manage_action_posts_custom_column', 'fill_action_thumb_column', 5, 2); // wp-admin/includes/class-wp-posts-list-table.php  
function fill_action_thumb_column($column_name, $post_id) {  
    if( $column_name != 'thumb' )  
        return;     
    if(get_the_post_thumbnail($post_id,'thumbnail')) $img = get_the_post_thumbnail($post_id,array(70,70)) ;
    
    echo '<div class="thumbnail">'.$img.'</div>';
}

add_action('admin_menu', 'wp_reservation_options_panel');
function wp_reservation_options_panel(){
	add_menu_page('Настройки WP-Reservation', 'WP-Reservation', 'edit_others_posts', 'options-wp-reservation', 'wp_reservation_options');
	add_submenu_page( 'options-wp-reservation', 'Схема мест', 'Схема мест', 'edit_others_posts', 'place-wp-reservation', 'wp_reservation_place'); 
	add_submenu_page( 'options-wp-reservation', 'Форма заказа', 'Форма заказа', 'edit_others_posts', 'manage-orderform-fields', 'custom_fields_orders_reservation');
	add_submenu_page( 'options-wp-reservation', 'Заказы', 'Заказы', 'edit_others_posts', 'manage-order-history', 'wp_reservation_order_history');
	add_submenu_page( 'options-wp-reservation', 'Платежи', 'Платежи', 'edit_others_posts', 'manage-order-sale', 'wp_reservation_order_sales');
	add_submenu_page( 'options-wp-reservation', 'Сеансы', 'Сеансы', 'edit_others_posts', 'manage-session-sale', 'wp_reservation_session_sales');
	add_submenu_page( 'options-wp-reservation', 'Наценка', 'Наценка', 'edit_others_posts', 'manage-price-sale', 'wp_reservation_price_sales');
}

function wp_reservation_price_sales(){
	
	if(isset($_POST['delete-prices'])){
		delete_option('reservation-prices');
	}
	
	$prices = get_option('reservation-prices');
	
	if(isset($_POST['add-prices'])&&$_POST['price']){
		foreach($_POST['types'] as $type){
			foreach($_POST['times'] as $time){
				$prices[$type][$time] = $_POST['price'];
			}
		}
		update_option('reservation-prices',$prices);
	}
	
	echo '<h2>Керування націнками</h2>';
	echo '<p>Отметьте галочками созданный тип и время, укажите уровень наценки, на который будет увеличиваться цена места и нажмите "Добавить наценку"<br>
	Важно! Для правильного начисления наценки мероприятие должно принадлежать только к одному типу</p>';
	
	echo '<form method="post"">
	
	<div style="overflow:hidden;width:400px;">';
	
	$terms = get_terms("type",array('hide_empty'=>false));
	 $count = count($terms);
	 if($count > 0){
		 echo "<ul id='type-action' style='float:left;width:200px;'>";
		 foreach ($terms as $term) {
		   echo "<li><input type='checkbox' name='types[]' value='".$term->name."'> ".$term->name."</li>";

		 }
		 echo "</ul>";
	 }
	 $terms = get_terms("times",array('hide_empty'=>false));
	 $count = count($terms);
	 if($count > 0){
		 echo "<ul id='times-action' style='float:right;width:200px;'>";
		 foreach ($terms as $term) {
		   echo "<li><input type='checkbox' name='times[]' value='".$term->name."'> ".$term->name."</li>";

		 }
		 echo "</ul>";
	 }
	 
	 echo '</div>';
	 echo '<div style="clear:both;">';
	 echo 'Значение наценки <input type="text" name="price" value=""> р';
	 echo ' <input type="submit" name="add-prices" value="Добавить наценку">';
	 echo '</div>';
	 echo '</form>';
	 
	 if($prices){
		 echo '<h3>Действующие наценки</h3>';
		 foreach($prices as $type=>$data){
			 
			 echo '<div><h4>Тип: '.$type.'</h4>';
			foreach($data as $time=>$price){
				
				echo '<p>Время: '.$time;
				echo ' Наценка: '.$price.' p</p>';
			}
			echo '</div>';
		 }
		 
		 echo '<div style="clear:both;"><form method="post">';
		 echo ' <input type="submit" name="delete-prices" value="Сбросить наценки">';
		 echo '</div>';
		 echo '</form>';
	 }
}

function wp_reservation_session_sales(){
	global $wpdb;
	$zal_array = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."options WHERE option_name LIKE 'options-reservation-place%'");
	
	if($_POST['action']=='empty'){
		$new_place = $place;
		$cnt = count($_POST['session']);
		
		$connect_sale = get_option('wp_reservation_connect_sale');
		if($connect_sale) $res_status = 1;
		else $res_status = 4;
		
		foreach((array)$zal_array as $zal_data){
			$id_form = preg_replace("/[a-z_-]+/", '', $zal_data->option_name);
			$options = get_option('options-reservation-place-'.$id_form);
			$place = get_option('list-reservation-place-'.$id_form);
			for($a=0;$a<$cnt;$a++){		
				foreach($place['status'] as $session => $value){
					//if($idform==$_POST['idzal'][$a]&&$session!=$_POST['session'][$a]) $new_status[$session] = $value;
					if($id_form==$_POST['idzal'][$a]&&$session==$_POST['session'][$a]) unset($place['status'][$session]);
				}
				$wpdb->update( WP_PREFIX.'reservation_orders_history',  
					array( 'res_status' => 2 ),  
					array( 'res_status' => $res_status, 'res_session' => $_POST['session'][$a], 'res_zalid' => $_POST['idzal'][$a] ) 
				);  
				//$place['status'] = $new_status;
				//$new_status = '';
			}
			//print_r($place);		
			update_option('list-reservation-place-'.$id_form,$place);
			$place = '';
		}
	}
	//print_r($place);
	echo '
	<h2>Управление сеансами</h2>
	<h3>Сеансы с проданными билетами</h3>
	<form action="" method="post">
	<div class="tablenav top">
		<div class="alignleft actions">
		<select name="action">
			<option selected="selected" value="-1">Действия</option>
			<option value="empty">Сбросить заказы</option>
		</select>
		<input id="doaction" class="button action" type="submit" value="Применить" name="">
		</div>	
	</div>
	<table class="widefat">
	<tr>
		<th class="check-column" scope="row"></th>
		<th class="manage-column">№</th>
		<th class="manage-column">Зал</th>
		<th class="manage-column">Сеанс</th>
		<th class="manage-column">Билетов продано</th>
		<th class="manage-column"></th>
	</tr>';	

	foreach((array)$zal_array as $zal_data){
		$id_form = preg_replace("/[a-z_-]+/", '', $zal_data->option_name);
		$options = get_option('options-reservation-place-'.$id_form);
		$place = get_option('list-reservation-place-'.$id_form);
		
		//print_r($place);		
		if(!$place['status']) continue;
		foreach($place['status'] as $session => $placelist){
		
		$session_data = explode('#',$session);
		
			echo '<tr>
				<th class="check-column" scope="row">
				<input type="checkbox" value="'.$session.'" name="session[]">
				<input type="hidden" value="'.$id_form.'" name="idzal[]">
				</th>
				<td>'.++$n.'</td>
				<td>'.$options['name'].'</td>
				<td>'.$session.'</td>
				<td>'.count($placelist).'</td>
				<td>
					<a href="/wp-admin/admin.php?page=manage-order-history&session='.$session_data[0].'&time='.$session_data[1].'&idzal='.$id_form.'">Смотреть заказы на сеанс</a>
				</td>
			</tr>';	
		}
	}
	
	echo '</table>';
}

function wp_reservation_order_sales(){
global $wpdb;
	if($_POST['action']=='trash'){
		$cnt = count($_POST['addcashe']);
		for($a=0;$a<$cnt;$a++){
			$id = $_POST['addcashe'][$a];
			if($id) $wpdb->query("DELETE FROM ".WP_PREFIX ."reservation_pay_results WHERE ID = '$id'");
		}
	}

	if($_GET['paged']) $page = $_GET['paged'];
	else $page=1;
	
	$inpage = 30;
	$start = ($page-1)*$inpage;
	
	if($_GET['user']){
		$get = $_GET['user'];
		$get_data = '&user='.$get;
		$statistic = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_pay_results WHERE user_email = '$get' ORDER BY ID DESC LIMIT $start,$inpage");
		$count_adds = $wpdb->get_var("SELECT COUNT(ID) FROM ".WP_PREFIX ."reservation_pay_results WHERE user_email = '$get'");
	}elseif($_GET['date']){
		$get = $_GET['date'];
		$get_data = '&date='.$get;
		$statistic = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_pay_results WHERE timeaction LIKE '$get%' ORDER BY ID DESC LIMIT $start,$inpage");
		$count_adds = $wpdb->get_var("SELECT COUNT(ID) FROM ".WP_PREFIX ."reservation_pay_results WHERE timeaction LIKE '$get%'");
	}else{
		$statistic = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_pay_results ORDER BY ID DESC LIMIT $start,$inpage");
		$count_adds = $wpdb->get_var("SELECT COUNT(ID) FROM ".WP_PREFIX ."reservation_pay_results");
	}
		
	$num_page = ceil($count_adds/$inpage); 
	
	$cnt = count($statistic);
	
	$header = '
	<div class="wrap"><h2>Приход средств через платежные системы</h2>
	<h3>Всего переводов: '.$count_adds.'</h3>';
	
	$table .= '<form action="" method="post">
	<div class="tablenav top">
		<div class="alignleft actions">
		<select name="action">
			<option selected="selected" value="-1">Действия</option>
			<option value="trash">Удалить</option>
		</select>
		<input id="doaction" class="button action" type="submit" value="Применить" name="">
		</div>	
	</div>
	<table class="widefat"><tr><th class="check-column" scope="row"></th><th class="manage-column">№пп</th><th class="manage-column">Пользователь</th><th class="manage-column">К заказу</th><th class="manage-column">Сумма платежа</th><th class="manage-column">Дата и время</th></tr>';
	
	$n=0;
	foreach((array)$statistic as $add){
		$n++;
		$time = substr($add->timeaction, -9);
		$date = substr($add->timeaction, 0, 10);
		$table .= '<tr><th class="check-column" scope="row"><input id="delete-addcashe-'.$add->ID.'" type="checkbox" value="'.$add->ID.'" name="addcashe[]"></th><td>'.$n.'</td><td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-sale&user='.$add->user_email.'">'.$add->user_email.'</a></td><td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$add->res_order.'">'.$add->res_order.'</a></td><td>'.$add->count_summ.'</td><td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-sale&date='.$date.'">'.$date.'</a>'.$time.'</td></tr>';
	}
	
	$table .= '</table></form>';
	
	
	$prev = $page-1;
	$next = $page+1;
	$pagination .= '<div class="tablenav"><div class="tablenav-pages"><span class="pagination-links">';
		
	if($page!=1)$pagination .= '<a class="first-page" href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-sale'.$get_data.'" title="Перейти на первую страницу">«</a>
	<a class="prev-page" href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-sale'.$get_data.'&paged='.$prev.'" title="Перейти на предыдущую страницу">‹</a>';
	$pagination .= '<span class="paging-input">
		'.$page.' из <span class="total-pages">'.$num_page.'</span>
	</span>';
	if($page!=$num_page)$pagination .= '<a class="next-page" href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-sale'.$get_data.'&paged='.$next.'" title="Перейти на следующую страницу">›</a>
	<a class="last-page" href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-sale'.$get_data.'&paged='.$num_page.'" title="Перейти на последнюю страницу">»</a>';
			
	$pagination .= '</span></div></div>
	<input type="button" value="Назад" onClick="history.back()"></form><div style="text-align:right;"><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-sale">Показать все платежи</a></div><div>';		
	
	
	echo $header.$table.$pagination;
}

add_action('init','delete_place_wprp_activate');
function delete_place_wprp_activate ( ) {
  if ( isset( $_GET['delete-place'] ) ) {
	if( !wp_verify_nonce( $_GET['_wpnonce'], 'delete_place' ) ) return false;
	global $wpdb;
	$order = $_GET['order'];
	$pl_ce = $_GET['delete-place'];
	
	$place_data = $wpdb->get_row("SELECT * FROM ".WP_PREFIX."reservation_orders_history WHERE ID = '$pl_ce'");
	
	$order_data = $wpdb->get_results("SELECT res_session,res_place,res_zalid FROM ".WP_PREFIX."reservation_orders_history WHERE res_order = '$order'");
		
		foreach($order_data as $d){
			$data_or[$d->res_zalid][$d->res_session][] = $d->res_place;
		}
		//print_r($place_data); exit;
		foreach($data_or as $zalid=>$ses_data){
			if($zalid!=$place_data->res_zalid) continue;
			
			$place = get_option('list-reservation-place-'.$zalid);
			
			foreach($ses_data as $ses=>$pl){
				$old_status = $place['status'][$ses];
				foreach($pl as $code){
					foreach($old_status as $code_place=>$status){
						if($place_data->res_place!=$code_place) continue;
						if($code_place==$code) unset($place['status'][$ses][$code_place]);	
					}
				}
				
			}
		
			foreach($place['status'] as $session => $value){
				if($value) $new_place[$session] = $value;
			}
			$place['status'] = $new_place;
			update_option('list-reservation-place-'.$zalid,$place);
			$place = '';
			$new_place='';
		}
		
		$wpdb->query("DELETE FROM ".WP_PREFIX ."reservation_orders_history WHERE ID = '$pl_ce'");
		/*$wpdb->query("DELETE FROM ". WP_PREFIX ."reservation_details_orders WHERE order_id = '$idorder'");
		$wpdb->query("DELETE FROM ". WP_PREFIX ."reservation_pay_results WHERE res_order = '$idorder'");
		$res = $wpdb->query("DELETE FROM ". WP_PREFIX ."reservation_orders_history WHERE res_order = '$idorder'");*/
	
	wp_redirect(get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$order); exit;
  }
}

function wp_reservation_order_history(){
global $wpdb;

	if(isset($_POST['action'])&&$_POST['order']){
		
		foreach($_POST['order'] as $id_order){
			switch($_POST['action']){
				case 'pay': wrp_update_order_status($id_order,1); break;
				case 'bron': wrp_update_order_status($id_order,4); break;
				case 'trash': wrp_delete_order($id_order); break;
			}
		}	
			
	}

	list( $year, $month, $day, $hour, $minute, $second ) = preg_split( '([^0-9])', current_time('mysql') );
	
echo '<h2>Управление заказами</h2>
		<div style="width:900px">';//начало блока настроек профиля
$n=0;
$s=0;

if($_POST['filter-date']){
	if($_POST['year']&&$_POST['month'])$get = 'WHERE timeaction  LIKE "'.$_POST['year'].'-'.$_POST['month'].'%"';
	if($_POST['status']) $get .= ' AND res_status = "'.$_POST['status'].'"';
	$get .= ' ORDER BY ID DESC';
	$orders = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_orders_history ".$get);
}else{
	if($_GET['status']){
		$get = $_GET['status'];
		$orders = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_orders_history WHERE res_status = '$get' ORDER BY ID DESC");
	}elseif($_GET['session']){
		$get = $_GET['session'].'#'.$_GET['time'];
		$orders = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_orders_history WHERE res_session = '$get' AND res_status IN (1,4) ORDER BY ID DESC");
	}elseif($_GET['order']){
		$get = $_GET['order'];
		$orders = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_orders_history WHERE res_order = '$get' ORDER BY ID DESC");
	}elseif($_GET['date']||$_POST['filter-date']){		
		$get = $_GET['date'];
		$orders = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_orders_history WHERE timeaction  LIKE '$get%' ORDER BY ID DESC");
	}else{ 
		$orders = $wpdb->get_results("SELECT * FROM ".WP_PREFIX ."reservation_orders_history ORDER BY ID DESC");

		$_POST['year'] = $year;
		$_POST['month'] = $month;

	}
}

if($_GET['order']){

	$a=0;
	foreach((array)$orders as $sing_order){
			$sumprise += $sing_order->res_price;
			$a++;			
	}
	echo '<h3>ID замовлення: '.$_GET['order'].'</h3>
	<table class="widefat">
	<tr>
	<th>№ п/п</th>
	<th>Зал</th>
	<th>Сеанс</th>
	<th>Місце</th>
	<th>Ціна</th>
	<th>Статус</th>
	<th></th>
	</tr>';
	foreach((array)$orders as $order){
	//print_r($order);
		$n++;		
		switch($order->res_status){
			case 0: $status = 'Не оплачено'; break;
			case 1: $status = 'Оплачено'; break;	
			case 2: $status = 'Просрочений'; break;
			default: $status = 'Місця заброньованні';
		}
		if($order->res_order==$_GET['order']){
			echo '<tr>
			<td>'.$n.'</td>
			<td>'.$order->zal_name.'</td>
			<td>'.$order->res_session.' '.$order->comment_place.'</td>
			<td>'.$order->place_name.'</td>
			<td>'.$order->res_price.'</td>
			<td>'.$status.'</td>
			<td>';
			if($a>1) echo '<a href="'.wp_nonce_url( get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$_GET['order'].'&delete-place='.$order->ID, 'delete_place' ).'">Удалить из заказа</a></td></tr>';						
		}
	}
	if($n==$a) echo '<tr><td colspan="4">Сумма заказа</td><td colspan="2">'.$sumprise.'</td></tr>';
	
	$details_order = $wpdb->get_var("SELECT details_order FROM ".WP_PREFIX ."reservation_details_orders WHERE order_id = '$order->res_order'");
	
	echo '</table>
	<form><input type="button" value="Назад" onClick="history.back()"></form><div style="text-align:right;"><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history">Показать все заказы</a></div>';
	if($details_order) echo '<h3>Деталі замовлення:</h3>'.$details_order;	
	
	echo $table;
}else{
	
	

	$inv_id = 0;
	foreach((array)$orders as $order){
		if($inv_id != $order->res_order){
			$inv_id = $order->res_order;
			if($inv_id == $order->res_order){
				$n++;		
			}
		}
	}

$table .= '<h3>Всего заказов: '.$n.'</h3>';
if($_GET['session']){
$table .= '<form method="post" action="'.plugins_url("impexp.php", __FILE__).'">
	'.wp_nonce_field('get-csv-file','_wpnonce',true,false).'
	<input type="hidden" name="session" value="'.$_GET['session'].'#'.$_GET['time'].'">
	<input type="hidden" name="zalid" value="'.$_GET['idzal'].'">
	<input type="submit" class="button-primary" style="float:right;" name="get_csv_file" value="Выгрузить заказы на сеанс в файл">
</form>';
}
$table .= '<form action="" method="post">';
$table .= '<select name="status">';
$table .= '<option value="">Все заказы</option>';
for($a=1;$a<=2;$a++){
	switch($a){
		case 0: $status = 'Не оплачен'; break;
		case 1: $status = 'Оплачен'; break;
		case 2: $status = 'Просрочен'; break;
		default: $status = 'Места забронированы';
	}
	$table .= '<option value="'.$a.'" '.selected($a,$_POST['status'],false).'>'.$status.'</option>';
}
$table .= '</select>';
$table .= '<select name="month">';
	$months = array('За все месяцы','январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
	foreach($months as $k=>$month){
		if($k) $k = zeroise($k, 2);
		$table .= '<option value="'.$k.'" '.selected($k,$_POST['month'],false).'>'.$month.'</option>';
	}
	$table .= '</select>';

	$table .= '<select name="year">';
	for($a=2013;$a<=$year+1;$a++){
	$table .= '<option value="'.$a.'" '.selected($a,$_POST['year'],false).'>'.$a.'</option>';
	}
	$table .= '</select>';
$table .= '<input type="submit" value="Фильтровать" name="filter-date" class="button-secondary"></form>';
$table .= '<form method="post" action>
	<div class="tablenav top">
		<div class="alignleft actions">
		<select name="action">
			<option selected="selected" value="0">Действия</option>
			<option value="pay">Оплачено</option>
			<option value="bron">Забронировано</option>
			<option value="trash">Удалить</option>
		</select>
		<input id="doaction" class="button action" type="submit" value="Применить" name="">
		</div>
	</div>
	<table class="widefat">
	<tr>
		<th class="check-column" scope="row"></th>
		<th>Заказ ID</th>
		<th>Пользователь</th>
		<th>Сумма заказа</th>
		<th>Дата и время</th>
		<th>Статус</th>
		
	</tr>';
$inv_id = 0;
foreach((array)$orders as $order){
	if($inv_id != $order->res_order){
		
		$inv_id = $order->res_order;
	
		foreach((array)$orders as $sing_order){
			if($inv_id == $sing_order->res_order){
				$sumprise[$inv_id] += $sing_order->res_price;		
			}			
		}
		
		switch($order->res_status){
			case 0: $status = 'Не оплачен'; break;
			case 1: $status = 'Оплачен'; break;
			case 2: $status = 'Просрочен'; break;
			default: $status = 'Места забронированы';
		}

		
		$delete = '<input type="button" class="button-primary delete-order" id="'.$inv_id.'" value="Удалить">';
		
		$time = substr($order->timeaction, -9);
		$date = substr($order->timeaction, 0, 10);
		$table .= '<tr id="row-'.$inv_id.'">
			<th class="check-column" scope="row"><input type="checkbox" value="'.$inv_id.'" name="order[]"></th>
			<td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&order='.$inv_id.'">Заказ '.$inv_id.'</a></td>
			<td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&user='.$order->user_email.'">'.$order->user_email.'</a></td>
			<td>'.$sumprise[$inv_id].'</td>
			<td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&date='.$date.'">'.$date.'</a>'.$time.'</td>
			<td><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history&status='.$order->res_status.'"><span class="change-'.$inv_id.'">'.$status.'</span></a></td>
			</tr>';		
	}	
}

$table .= '</table></form>';

echo $table;

if($_GET['status']||$_GET['date'])echo '<form><input type="button" value="Назад" onClick="history.back()"></form><div style="text-align:right;"><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=manage-order-history">Показать текущие заказы</a></div>';
}

echo '</div>';//конец блока заказов
}

function custom_fields_orders_reservation(){
	global $wpdb;

	if($_POST['add_field_orders']){
		$get_fields = get_option( 'wp_reservation_orders_field' );
		
		$order_field = $_POST['order_fields_title'];
		$slug_field = $_POST['order_fields_slug'];
		
		if($order_field){
		
			$count_field = count($order_field);

			for($a=0;$a<$count_field;$a++){
				if($order_field[$a]){
					$slug_edit = true;
					
				if($get_fields){
					foreach((array)$get_fields as $get){				
						if($get['slug']==$_POST['order_fields_slug'][$a]){
							$slug_edit = false;	
							$slug = $get['slug'];
							$end = $slug;
							break;
						}else{
							$end = $a;
						}				
					}
				}else{
					$end = $a;
				}
					
					if($slug_edit){
						$slug = sanitize_title($order_field[$a]);	
						$slug = $slug.'-'.rand(10,100);
					}
					
					$fields[$a]['slug'] = $slug;
					
					$fields[$a]['type'] = $_POST['type_field_'.$end];
					$fields[$a]['title'] = $order_field[$a];																				
					
					if($_POST['requared_field_'.$end])
						$fields[$a]['req'] = $_POST['requared_field_'.$end];
					else
						$fields[$a]['req'] = 0;					
						
					if($_POST['type_field_'.$end]=='select'||$_POST['type_field_'.$end]=='checkbox'||$_POST['type_field_'.$end]=='radio') $fields[$a]['field_select'] = $_POST['field_select_'.$end];
				}else{
					if($slug_field[$a]){
						//$slug = str_replace('-','_',$slug_field[$a]);
						//if($slug) $res = $wpdb->query("DELETE FROM wp_usermeta WHERE meta_key = '$slug' OR meta_key LIKE '$slug%'");
						if($res) echo 'Все значения поля "'.$slug.'" были удалены из БД.';
					}
				}
			}
		}

		$res = update_option( 'wp_reservation_orders_field', $fields );

	}else{
		$fields = get_option( 'wp_reservation_orders_field' );
	}

	if($fields){		
		$n=0;
		foreach((array)$fields as $custom_field){
			if($custom_field['type']=='select'||$custom_field['type']=='checkbox'||$custom_field['type']=='radio'){ 				
				$textarea_select = '<textarea rows="1" name="field_select_'.$custom_field['slug'].'">'.$custom_field['field_select'].'</textarea>';
			}
			$type_field = '<select name="type_field_'.$custom_field['slug'].'"><option '.selected($custom_field['type'],'email',false).' value="email">E-mail</option><option value="text" '.selected($custom_field['type'],'text',false).'>Однострочное поле</option><option value="textarea" '.selected($custom_field['type'],'textarea',false).'>Многострочное поле</option><option value="select" '.selected($custom_field['type'],'select',false).'>Выпадающий список</option><option value="checkbox" '.selected($custom_field['type'],'checkbox',false).'>Чекбокс</option><option value="radio" '.selected($custom_field['type'],'radio',false).'>Радиокнопки</option></select>';			
			
			$field .= '
			<li id="item-'.$custom_field['slug'].'" class="menu-item menu-item-edit-active">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title">'.$custom_field['title'].'</span>						
						<span class="item-controls">
						<span class="item-type">'.$custom_field['type'].'</span>						
						<a id="edit-'.$custom_field['slug'].'" class="profilefield-item-edit item-edit" href="#" title="Изменить">Изменить</a>
						</span>
					</dt>
				</dl>
				<div id="settings-'.$custom_field['slug'].'" class="menu-item-settings" style="display: none;">
					<p class="link-to-original" style="clear:both;">Ярлык: '.$custom_field['slug'].'<input type="hidden" name="order_fields_slug[]" value="'.$custom_field['slug'].'"/></p>
					<div class="link-to-original" style="overflow:hidden;">
						<p class="description description-thin" style="width: 300px;">
						<label>Заголовок<br><input type="text" name="order_fields_title[]" size="50" class="field" value="'.$custom_field['title'].'"/></label></p>
						<p class="description description-thin"><label>Тип поля<br>'.$type_field.'</label></p>
					</div>					
					<p class="link-to-original">'.$textarea_select.'
					<input type="checkbox" name="requared_field_'.$custom_field['slug'].'" value="1" '.checked($custom_field['req'],1,false).' /> обязательное поле</p>
					<p align="right"><a id="'.$custom_field['slug'].'" class="item-delete profilefield-submitdelete deletion" href="#">Удалить</a></p>				
				</div>					
			</li>
			';
			
			$n++;
			$textarea_select = '';
		}
	}else{
		
		$type_field = 'Тип: <select name="type_field_0"><option value="email">E-mail</option><option value="text">Однострочное поле</option><option value="textarea">Многострочное поле</option><option value="select">Выпадающий список</option><option value="checkbox">Чекбокс</option><option value="radio">Радиокнопки</option></select>';
		
		$field = '
		<li class="menu-item menu-item-edit-active">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><input type="text" name="order_fields_title[]" class="field" value=""/></span>
						<span class="item-controls">
						<span class="item-type">'.$type_field.'</span>
						</span>
					</dt>
				</dl>
				<div class="menu-item-settings" style="display: block;">										
					<p><input type="checkbox" name="requared_field_0" value="1"/> обязательное поле</p>									
				</div>					
			</li>';
	}
	$users_fields = '
	<style>#inputs_order_fields textarea{width:100%;}  #inputs_order_fields .menu-item-settings, #inputs_order_fields .menu-item-handle{padding-right:10px;width:100%;}</style>
	<h2>Управление полями Формы заказа</h2>	
	<form class="nav-menus-php" action="" method="post">
	<small>Ярлык должен быть латиницей, если формируется другой, то ставим плагин Rustolat</small><br>
	<small># - разделитель между вариантами в полях с типом select, checkbox и radio</small><br>
	<div id="inputs_order_fields" class="order_fields" style="width:550px;">
	<ul id="sortable">
	'.$field.'
	</ul>
	
	 </div>	 
	 <p style="width:550px;"><input type="button" id="add_order_field"  class="button-secondary right" value="+ Добавить еще"></p>
	 <input id="save_menu_footer" class="button button-primary menu-save" type="submit" value="Сохранить" name="add_field_orders">
	 </form>
	 <script>
	jQuery(function(){
		jQuery("#sortable").sortable();
		return false;
	});
	 </script>
	 ';
	echo $users_fields;
}

function wp_reservation_options(){ ?>
		<?php echo reg_form_wpp('wprp'); ?>
		<h2>Настройки WP-Reservation</h2>
		<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
	<table width="800">
	<?php
		$args = array(    
				'selected'   => get_option('cart_page_wprp'),   
				'name'       => 'cart_page_wprp',
				'show_option_none' => 'Не выбрано'
			);  
	?>
	<tr>
		<td>
				<h3>Страница корзины (обязательно!)</h3>				
		</td>
		<td>
			<?php wp_dropdown_pages( $args ); ?>		
		</td>
	</tr>
	<tr>
		<td>
			<h3>Формирование QR-кода</h3>
			<p>Высылать ли пользователю QR-код для подтверждения с помощью него этого заказа.</p>
			<p>QR-код будет выслан на почту пользователя после оформления его заказа и может быть использован организаторами мероприятия для подтверждения пользователем своего заказа.</p>
		</td>
		<td>
		<?php $qr_code_wprp = get_option('qr_code_wprp'); ?>
		<select name="qr_code_wprp" size="1">
			<option value="">Не высылать</option>
			<option value="1" <?php selected($qr_code_wprp,1); ?>>Высылать</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>
				<h3>Ограничение мест в корзине</h3>	
				<small>Укажите максимальное кол-во мест доступное для добавление в корзину на один заказ. Если пусто или ноль, то без ограничений.</small>
		</td>
		<td>
		<input type="number" name="wprp_max_place_cart" size="45" value="<?php echo get_option('wprp_max_place_cart'); ?>" />
		
		</td>
	</tr>
	<tr>
		<td>
				<h3>Подключение к платежному агрегатору</h3>
				<p>Выберите используемое подключение! Если подключение не используется, то место будет бронироваться без оплаты заказа.</p>
		</td>
		<td>
		<?php $connect_sale = get_option('wp_reservation_connect_sale'); ?>
		<select name="wp_reservation_connect_sale" size="1">
			<option value="">Не используется</option>
			<option value="1" <?php selected($connect_sale,1); ?>>Robokassa</option>
			<option value="2" <?php selected($connect_sale,2); ?>>Интеркасса</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>
			<h3>Настройки Интеркасса:</h3>	
		</td>
	</tr>
	<tr><td><strong>Secret Key:</strong></td>
		<td><input type="password" name="wp_reservation_intersecretkey" size="45" value="<?php echo get_option('wp_reservation_intersecretkey'); ?>" /></td>
	</tr>
	<tr><td><strong>Test Key:</strong></td>
		<td><input type="password" name="wp_reservation_intertestkey" size="45" value="<?php echo get_option('wp_reservation_intertestkey'); ?>" /></td>
	</tr>
	<tr><td><strong>Идентификатор магазина:</strong></td>
		<td><input type="text" name="wp_reservation_interidshop" size="45" value="<?php echo get_option('wp_reservation_interidshop'); ?>" /></td>
	</tr>
	<tr>
	<td>
			<p>Статус аккаунта Интеркасса</p>
	</td>
	<td>
	<?php $intertest = get_option('wp_reservation_intertest'); ?>
	<select name="wp_reservation_intertest" size="1">		
		<option value="1" <?php selected($intertest,1); ?>>Тестовый</option>
		<option value="0" <?php selected($intertest,0); ?>>Рабочий</option>
	</select>
	</td>
	</tr>
	<tr>
		<td>
			<h3>Настройки Робокасса:</h3>	
		</td>
	</tr>
	<tr><td><strong>Логин:</strong></td>
		<td><input type="text" name="wp_reservation_robologin" size="45" value="<?php echo get_option('wp_reservation_robologin'); ?>" /></td>
	</tr>
	<tr><td><strong>1 Пароль:</strong></td>
		<td><input type="password" name="wp_reservation_onerobopass" size="45" value="<?php echo get_option('wp_reservation_onerobopass'); ?>" /></td>
	</tr>
	<tr><td><strong>2 Пароль:</strong></td>
		<td><input type="password" name="wp_reservation_tworobopass" size="45" value="<?php echo get_option('wp_reservation_tworobopass'); ?>" /></td>
	</tr>
	<tr>
	<td>
			<p>Статус аккаунта Робокассы</p>
	</td>
	<td>
	<?php $robotest = get_option('wp_reservation_robotest'); ?>
	<select name="wp_reservation_robotest" size="1">		
		<option value="1" <?php selected($robotest,1); ?>>Тестовый</option>
		<option value="0" <?php selected($robotest,0); ?>>Рабочий</option>
	</select>
	</td>
	</tr>
	<tr><td colspan="2"><h3>Сервисные страницы платежных систем:</h3> 
		<p>1. Создайте на своем сайте четыре страницы:</p>
		- пустую для success<br>
		- пустую для result<br>
		- одну с текстом о неудачной оплате (fail)<br>
		- одну с текстом об удачной оплате<br>
		Название и URL созданных страниц могут быть произвольными.<br>
		<p>2. Укажите здесь какие страницы и для чего вы создали. </p>
		<p>3. В настройках своего аккаунта платежной системы укажите URL страницы для fail, success и result</p>
		</td>
	</tr>
	<tr><td><h3>Страница result:</h3></td>
	<?php $args = array(    
    'selected'   => get_option('wp_reservation_page_result_pay'),   
    'name'       => 'wp_reservation_page_result_pay'
	);  
	 ?> 
		<td><?php wp_dropdown_pages( $args ); ?>
		<p>Для Интеркассы: URL взаимодействия</p></td>
		</td>
	</tr>
	<tr><td><h3>Страница success:</h3></td>
	<?php $args = array(    
    'selected'   => get_option('wp_reservation_page_success_pay'),   
    'name'       => 'wp_reservation_page_success_pay'
	);  
	 ?> 
		<td><?php wp_dropdown_pages( $args ); ?>
		<p>Для Интеркассы: URL успешной оплаты</p></td>
	</tr>
	<tr><td><h3>Страница удачной оплаты:</h3></td>
	<?php $args = array(    
    'selected'   => get_option('wp_reservation_page_successfully_pay'),   
    'name'       => 'wp_reservation_page_successfully_pay'
	);  
	 ?> 
		<td><?php wp_dropdown_pages( $args ); ?></td>
	</tr>
	</table>
	<p><input type="submit" name="Submit" value="Сохранить" /></p>
	<input type="hidden" name="action" value="update" />			
	<input type="hidden" name="page_options" value="wprp_max_place_cart,qr_code_wprp,cart_page_wprp,wp_reservation_intertestkey,wp_reservation_intertest,wp_reservation_interidshop,wp_reservation_intersecretkey,wp_reservation_connect_sale,wp_reservation_robologin,wp_reservation_onerobopass,wp_reservation_tworobopass,wp_reservation_robotest,wp_reservation_page_result_pay,wp_reservation_page_success_pay,wp_reservation_page_successfully_pay" />
	</form>
<?php
}

function wp_reservation_place(){

	$cols = 0;
	$rows = 0;
	global $wpdb;
	
	//$wpdb->query("DELETE FROM ".$wpdb->prefix."options WHERE option_name = 'list-reservation-place'");
	//$wpdb->query("DELETE FROM ".$wpdb->prefix."options WHERE option_name = 'options-reservation-place'");
	
	if($_GET['form']) $form = $_GET['form'];
	
	if($_POST['delete-form']&&wp_verify_nonce( $_POST['_wpnonce'], 'update-public-fields' )){		
		$id_form = $_POST['id-form'];
		$_GET['status'] = 'old';
		$wpdb->query("DELETE FROM ".$wpdb->prefix."options WHERE option_name = 'list-reservation-place-$id_form'");
		$wpdb->query("DELETE FROM ".$wpdb->prefix."options WHERE option_name = 'options-reservation-place-$id_form'");
		$form = false;
	}
	
	if(!$form){
		$option_name = $wpdb->get_var("SELECT option_name FROM ".$wpdb->prefix."options WHERE option_name LIKE 'options-reservation-place%'");
		if($option_name) $form = preg_replace("/[a-z_-]+/", '', $option_name);
		else $form = 1;
	}

	$place = get_option('list-reservation-place-'.$form);
	
	if(isset($_POST)&&$_POST['size-table']){
		
		$cols = $_POST['cols'];
		$rows = $_POST['rows'];
		$back = $_POST['background'];
		$name_zal = $_POST['name_zal'];
		
		if($name_zal) $options['name'] = $name_zal;
		if($cols) $options['cols'] = $cols;
		if($rows) $options['rows'] = $rows;
		if($back) $options['background'] = $back;
		
		if($_POST['view-rows']) $options['view-rows'] = $_POST['view-rows'];
		$cnt = count($_POST['price-tariff']);
		for($a=0;$a<$cnt;$a++){
			$options['tariffs'][$a]['price'] = $_POST['price-tariff'][$a];
			$options['tariffs'][$a]['color'] = $_POST['color-tariff'][$a];
		}

		update_option('options-reservation-place-'.$form,$options);
	}
	
	if(!$options){
		$options = get_option('options-reservation-place-'.$form);
		$name_zal = $options['name'];
		$cols = $options['cols'];
		$rows = $options['rows'];
	}
	
	if($_POST['place-table']){
		//print_r($_POST);exit;
		$new_place['status'] = $place['status'];
		if($_POST['r']) $new_place['rows'] = $_POST['r'];
		
		for($r=0;$r<=$rows;$r++){
				for($c=1;$c<=$cols;$c++){
					if($_POST['n'][$r.'-'.$c]) $new_place['name'][$r.'-'.$c] = $_POST['n'][$r.'-'.$c];
					if($_POST['p'][$r.'-'.$c]) $new_place['price'][$r.'-'.$c] = $_POST['p'][$r.'-'.$c];
				}
		}
		$place = $new_place;		
		update_option('list-reservation-place-'.$form,$place);
	}
	
	$cnt_tarif = count($options['tariffs']);
	echo '<style>';
	for($a=0;$a<$cnt_tarif;$a++){
		if($options['tariffs'][$a]['color']) echo '.tariff-'.$a.'{background:'.$options['tariffs'][$a]['color'].';}';
	}
	echo '</style>';
	
	$custom_public_form_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."options WHERE option_name LIKE 'options-reservation-place%' ORDER BY option_id ASC");
	$count_form = count($custom_public_form_data);
	
	if($custom_public_form_data){
		$form_navi = '<h3>Доступные залы</h3><div class="form-navi">';
		foreach((array)$custom_public_form_data as $form_data){
			$id_form = preg_replace("/[a-z_-]+/", '', $form_data->option_name);
			if($form==$id_form) $class = 'button-primary';
			else $class = 'button-secondary';
			$form_navi .= '<input class="'.$class.'" type="button" onClick="document.location=\''.get_bloginfo('wpurl').'/wp-admin/admin.php?page=place-wp-reservation&form='.$id_form.'\';" value="ID:'.$id_form.'" name="public-form-'.$id_form.'">';
		}	
		if($_GET['status']!='new') $form_navi .= '<input class="button-secondary" type="button" onClick="document.location=\''.get_bloginfo('wpurl').'/wp-admin/admin.php?page=place-wp-reservation&form='.++$id_form.'&status=new\';" value="Добавить еще" name="public-form-'.$id_form.'">';
		$form_navi .= '</div>
		
		<h3 style="float: left; margin-right: 30px;">Зал ID:'.$form.' </h3>';
		if($_GET['status']!='new') $form_navi .= '<form method="post" action="">
			'.wp_nonce_field('update-public-fields','_wpnonce',true,false).'
			<input class="button-primary" type="submit" style="margin-top: 10px;" value="Удалить зал" onClick="return confirm(\'Вы уверены?\');" name="delete-form">
			<input type="hidden" value="'.$form.'" name="id-form">
		</form>';
	}else{
		$form = 1;
		echo '<h3>Зал ID:1 </h3>';
	}
	
	//echo '<p>Для вывода созданной конфигурации используйте шорткод [place-list] на требуемой странице с указанием идентификатора зала и времени проведения мероприятия,<br> 
	//например: [place-list id="1" session="19.00"]</p>';
	
	echo '<h2>Управление залами</h2>';
	echo $form_navi;
	echo '<form style="clear:both;" action="" method="post">
		<input type="text" value="'.$name_zal.'" name="name_zal"> Название зала<br />
		<input type="text" value="'.$cols.'" name="cols"> Количество мест в ряду<br />
		<input type="text" value="'.$rows.'" name="rows"> Количество рядов<br />
		<input type="checkbox" value="1" '.checked($options['view-rows'],1,false).' name="view-rows"> Выводить ряды<br />
		
		'.wrp_get_background_place($options).'
		
		<h3>Тарифная сетка:</h3>
		<p><small>Вы можете создавать фальш-блоки в конфигурации мест,<br>
		указав в тарифной сетке в качестве стоимости букву,<br> 
		а затем пометив этим тарифом нужные блоки в конфигурации мест</small></p>
		<table width="500" id="table-tariff">';
		for($a=0;$a<$cnt_tarif;$a++){
			if($options['tariffs'][$a]['price']) 
			echo '<tr class="tariff"><td class="price-row">Стоимость: <input type="text" size="3" value="'.$options['tariffs'][$a]['price'].'" name="price-tariff[]">р. <input type="text" value="'.$options['tariffs'][$a]['color'].'" class="color-tariff" name="color-tariff[]"></td></tr>';
		}
		echo '<tr class="tariff"><td class="price-row">Стоимость: <input size="3" type="text" value="" name="price-tariff[]">р. <input type="text" value="" class="color-tariff" name="color-tariff[]"></td></tr>
		</table>
		<table width="500">
		<tr><td colspan="2"><p align="right"><input class="button-secondary" type="button" id="add_tariff" name="add_tariff" value="Добавить еще" /></p></td></tr>
		</table>
		<input type="submit" class="button-primary" value="Применить настройки" name="size-table">
	</form>';
	
	if($rows&&$cols){
		echo '
		<h3>Конфигурация мест в зале</h3>';
		
		echo '<div id="price-blocks">';
		for($a=0;$a<$cnt_tarif;$a++){
			if($options['tariffs'][$a]['price']){ 
				echo '<div style="background:'.$options['tariffs'][$a]['color'].';" class="price-block">
					<input type="hidden"  value="'.$options['tariffs'][$a]['price'].'" class="pricetariff" name="price-tariff">
					<input type="hidden"  value="tariff-'.$a.'" class="typetariff" name="type-tariff">
				</div>';
			}
		}
		echo '</div>
		<b>Автозаполнение</b>: 
		
		<input type="button" class="button-secondary type-autocomplete" autocomplete="1" value="Тип 1"> 
		<input type="button" class="button-secondary type-autocomplete" autocomplete="2" value="Тип 2">
		<input type="button" class="button-secondary type-autocomplete" autocomplete="3" value="Тип 3">
		<input type="button" class="button-secondary type-autocomplete" autocomplete="4" value="Тип 4">';
		
		echo '<form id="config-places" action="" method="post">
		<table>';
		
		for($r=0;$r<=$rows;$r++){
				echo '<tr><th>';
				if($r){
					$nr = (isset($place['rows'][$r]))? $place['rows'][$r]: $r;
					echo $r.' ';
					if($options['view-rows']) echo '<input style="width:60px;" type="number" name="r['.$r.']" value="'.$nr.'"> ';
				}
				echo '</th>';
				$i = 0;
				for($c=1;$c<=$cols;$c++){
					if($r==0){
						echo '<th>'.$c.'</th>';
					}else{
						$name = $place['name'][$r.'-'.$c];
						//if(!isset($place['name'][$r.'-'.$c])) $name = ++$p;
						for($a=0;$a<$cnt_tarif;$a++){
							if($options['tariffs'][$a]['price']){
							$selected = selected($place['price'][$r.'-'.$c],$options['tariffs'][$a]['price'],false);
								if($selected) $class2 = 'tariff-'.$a;
							//$tarif_list .= '<option '.$selected.' value="'.$options['tariffs'][$a]['price'].'">'.$options['tariffs'][$a]['price'].'</option>';
							}
						}
						echo '<td>
						<div class="place '.$class2.'" index="'.++$i.'" col="'.$c.'" row="'.$r.'">
						<input type="text" class="name-place" name="n['.$r.'-'.$c.']" size="2"';
						if($place['price'][$r.'-'.$c]&&!is_numeric($place['price'][$r.'-'.$c])) echo ' disabled=disabled';
						echo ' value="'.$name.'">
						<div class="back-false"></div>';
						/*<br /><select name="price-place['.$r.'-'.$c.']">
						<option value="">цена</option>'.$tarif_list.'</select>*/
						echo '<input type="hidden" class="price-place" name="p['.$r.'-'.$c.']" value="'.$place['price'][$r.'-'.$c].'">
						</div></td>';
						$class2 = '';
						$selected = '';
						$tarif_list = '';
					}
				}
			echo '</tr>';
		}
		
		echo '</table>
		<input type="submit" class="button-primary" value="Обновить конфигурацию зала" name="place-table">
		</form>';
		echo "<script>
			jQuery('#config-places').submit(function() {
				jQuery('#config-places').find('input').each(function(){		
					var val = jQuery(this).val();
					if(!val) jQuery(this).attr('disabled',true);				
				});
			});
		</script>";
		
		/*echo '<form method="post" action="'.plugins_url("impexp-zal.php", __FILE__).'">
			'.wp_nonce_field('get-csv-file','_wpnonce',true,false).'
			<input type="hidden" name="zalid" value="'.$form.'">
			<input type="submit" class="button-primary" style="float:right;" name="get_csv_file" value="Выгрузить конфигурацию в файл">
		</form>';*/
	}
	
}

function wrp_get_background_place($options){
	
	
	$pr = '<h3>Фоновое изображение</h3>
	<div style="clear:both;" id="back-wrp"><div class="alignleft">';
	if($options['background']){
		$pr .= '<style>
		#config-places table{
			background:url('.$options['background'].') no-repeat center;
			background-size: 100%;
		}
		</style>';
	}
	$pr .= '</div>URL изображения<br />
			<input type="url" class="url-back" name="background" value="'.$options['background'].'" style="width:300px" />
			<a href="#" class="add-back button" style="display: inline-block;">Выбрать</a>';
	$pr .= '</div>';

	return $pr;

}

add_filter('the_content','wprp_placelist');
function wprp_placelist($content){
	global $post;
	
	if($post->post_type!='action') return $content;
	
	//datepicker_scripts();
	$content .= get_content_action_placelist($post->ID);
	
	return $content;
}

function get_content_action_placelist($action_id){
	
	$content = '<div id="times-list">
	<h3>Выберите время посещения:</h3>
	<form action method="get">';
	
	if(is_admin()){
		$content .= '<input type="hidden" name="page" value="manage-admin-sale">
		<input type="hidden" name="action-id" value="'.$action_id.'">';
	}

	$dates = get_post_meta($action_id,'date-action',1);
	if($dates){
		$content .= 'Дата <select name="action-date">';
		$dates = explode(',',$dates);
		$a = 0;
		
		$now = strtotime(current_time('mysql')) - 86400;
		
		foreach($dates as $date){
			$dt = explode('-',$date);
			$cnt = count($dt);
			if($cnt>1){
				$start = strtotime($dt[0]);
				$stop = strtotime($dt[1]);
				for($temp=$start; $temp <= $stop; $temp += 86400){
					if($temp>=$now){
						$d = date('d.m.Y',$temp);
						if(++$a==1) $ac_date = $d;
						$content .= '<option '.selected($_GET['action-date'],$d,false).' value="'.$d.'">'.$d.'</option>';
					}
				}
			}else{
				if(++$a==1) $ac_date = $dt[0];
				$content .= '<option '.selected($_GET['action-date'],$dt[0],false).' value="'.$dt[0].'">'.$dt[0].'</option>';
			}
		}
		$content .= '</select> ';
		//$content .= 'Дата <input type="text" class="datepicker" name="action-date" value>';
	}
	
	$cur_terms = get_the_terms( $action_id, 'times' );
	
	$content .= 'Время <select name="action-time">';
	$a = 0;
	foreach($cur_terms as $cur_term){
		if(++$a==1) $ac_time = $cur_term->name;
		$content .= '<option '.selected($_GET['action-time'],$cur_term->name,false).' value="'.$cur_term->name.'">'.$cur_term->name.'</option>';
	}
	$content .= '</select> ';
	$content .= '<input type="submit" value="Выбрать дату">
	</form>';
	/*$content .= '<script>';
	$dates = explode(',',$dates);
	$a = 0;
	foreach($dates as $date){
		$dt = explode('-',$date);
		$cnt = count($dt);
		if($cnt>1){
			$start = 'minDate: "'.$dt[0].'"';
			$stop = 'maxDate: "'.$dt[1].'"';		
		}else{
			if(++$a==1) $ac_date = $dt[0];
			$content .= '<option '.selected($_GET['action-date'],$dt[0],false).' value="'.$dt[0].'">'.$dt[0].'</option>';
		}
	}
	$content .= 'jQuery(function(){
		jQuery.datepicker.setDefaults(jQuery.extend(jQuery.datepicker.regional["ru"]));
		jQuery(".datepicker").datepicker({
			monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
			dayNamesMin: [ "Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс" ],
			dateFormat: "dd.mm.yy",
			//gotoCurrent:true,
			'.$start.',
			'.$stop.'
			//yearRange: "1950:c+3",
			//changeYear: true
		  });
	});
	</script>';*/
	$content .= '</div>';
	
	if(isset($_GET['action-time'])) $ac_time = $_GET['action-time'];
	if(isset($_GET['action-date'])) $ac_date = $_GET['action-date'];
	
	$time = false;
	foreach($cur_terms as $cur_term){
		if($ac_time==$cur_term->name){
			$time = true;
			break;
		}
	}
	
	if(!$time) return $content;
	
	if(is_admin()){
		$content .= get_admin_minicart_data();
	}
	
	$content .= get_shortcode_place_reservation(array('id'=>get_post_meta($action_id,'place_id',1),'date'=>$ac_date, 'time'=>$ac_time));
	
	return $content;
}

function wrp_get_margin_price($post_id,$time=false){
	$prices = get_option('reservation-prices');
	$margin = 0;
	if($prices){
		$type_post = get_the_terms( $post_id, 'type' );		
		foreach($type_post as $tp){
			$type_post = $tp->name; break;
		}
		
		if($time){
			$time_post = $time;			
		}
		if(isset($prices[$type_post][$time_post])) $margin = $prices[$type_post][$time_post];
	}
	return $margin;
}

function get_shortcode_place_reservation($atts, $content = null){
	
	global $wpdb,$post,$wp_query;
	
	extract(shortcode_atts(array(
		'id' => 1,
		'date' => 0,
		'time' => 0,
		'desc' => ''	
	),
	$atts));
	$date_param_b = ($_GET['date_b'])?$_GET['date_b']:$date;
    $time_param_b = ($_GET['time_b'])?$_GET['time_b']:$time;
	$session = $date_param_b.'#'.$time_param_b;

	$margin = wrp_get_margin_price($post_id,$time);

	$options = get_option('options-reservation-place-'.$id);
	$place = get_option('list-reservation-place-'.$id);

	//print_r($place);

	$cols = $options['cols'];
	$rows = $options['rows'];
	$cnt_tarif = count($options['tariffs']);
	$pl_list .= '<style>';

	for($a=0;$a<$cnt_tarif;$a++){
		if($options['tariffs'][$a]['color']) $pl_list .= '.tariff-'.$a.'{background:'.$options['tariffs'][$a]['color'].';}';
		
	}
	if($options['background']){
		$pl_list .= '#place-reservation{
			background:url('.$options['background'].') no-repeat center;
			background-size: 100%;
		}';
	}
	$pl_list .= '</style>';
	
	if($options['name']) $pl_list .= '<div class="teatr_block"><h4>'.$options['name'];
    $date_param_b = ($_GET['date_b'])?$_GET['date_b']:$date;
    $time_param_b = ($_GET['time_b'])?$_GET['time_b']:$time;
	if($session) $pl_list .= ': '.$date_param_b.' '.$time_param_b;
	$pl_list .= '</h4>';
	
	$pl_list .= '<div id="price-blocks">';
	for($a=0;$a<$cnt_tarif;$a++){
		if($options['tariffs'][$a]['price']&&is_numeric($options['tariffs'][$a]['price'])){ 
			$price = $options['tariffs'][$a]['price']+$margin;
			$pl_list .= '<div class="price-block"><span style="background:'.$options['tariffs'][$a]['color'].';" class="color-price"></span> '.$price.' грн.</div>';
		}
	}
	$pl_list .= '</div>';
	
	$pl_list .= '<table id="place-reservation">';
	for($r=0;$r<=$rows;$r++){
	
		if(!$r) continue;
		
			for($c=0;$c<=$cols;$c++){

				if($c==0){
					if($r&&$options['view-rows']){
						$nr = (isset($place['rows'][$r]))? $place['rows'][$r]: $r;
						$pl_list .= '<td>';
						if($nr) $pl_list .= 'ряд '.$nr;
						else $pl_list .= '<div class="empty-row"></div>';
						$pl_list .= '</td>';
					}
				}else{
					for($a=0;$a<$cnt_tarif;$a++){
						if($options['tariffs'][$a]['price']){
							$selected = selected($place['price'][$r.'-'.$c],$options['tariffs'][$a]['price'],false);
							if($selected) $class = 'tariff-'.$a;							
						}
					}
					$pl_list .= '<td>';
					
					if($_SESSION['order-place'][$id][$session][$r.'-'.$c]){
						if(isset($place['name'][$r.'-'.$c])&&$place['name'][$r.'-'.$c]) $pl_list .= '<a id="place-'.$r.'-'.$c.'" class="ordered" href="#"><div class="place '.$class.'">'.$place['name'][$r.'-'.$c].'</div></a>';
					}else{
						$free=false;
						if($place['name'][$r.'-'.$c]){
							if(isset($place['status'][$session])&&$place['status'][$session]){
								if($place['status'][$session][$r.'-'.$c]=='closed') $pl_list .= '<div class="place closed">'.$place['name'][$r.'-'.$c].'</div>';
								else $free=true;
							}else{
								$free=true;
							}
							if($free){
								$price = $place['price'][$r.'-'.$c]+$margin;
								$pl_list .= '<div class="place-info" id="info-'.$r.'-'.$c.'"><div class="wprp-ballon-content">Місце: '.$place['name'][$r.'-'.$c].'<br />Ціна: '.$price.' грн.<br />Статус: Вільне<br /></div></div><a class="getplace" id="place-'.$r.'-'.$c.'" href="#"><div class="place '.$class.'">'.$place['name'][$r.'-'.$c].'</div></a>';
							}
						}else{
							$pl_list .= '<div class="empty-place '.$class.'" id="info-'.$r.'-'.$c.'"></div>';
						}
					}
					
					$pl_list .= '</td>';
					$class = '';
					$selected = '';	
				}
			}
		$pl_list .= '</tr>';
	}
	
	$pl_list .= '</table>
	<input type="hidden" id="zal-id" value="'.$id.'">
	<input type="hidden" id="post-id" value="'.$post->ID.'">
	<input type="hidden" id="place-session" value="'.$session.'">';
	return $pl_list;
}
add_shortcode('place-list','get_shortcode_place_reservation');

function get_minicart_data(){

	foreach((array)$_SESSION['order-place'] as $id => $ses_val){
		foreach($ses_val as $session => $value){
			$count_place_minicart += count($value);
		}
	}
	
	$mini .= '<div class="uvas">У вашому замовленні:';
	if(!$count_place_minicart) $count_place_minicart = 0;		
	else $display = 'style="display:block;"';
    if($count_place_minicart==1){
        $param_place = 'місце';
    }elseif($count_place_minicart==0 || $count_place_minicart>4){
        $param_place = 'місць';
    }else{
        $param_place = 'місця';
    }
	$mini .= '<span id="count-place">'.$count_place_minicart.'</span> '.$param_place.'</div>
	<a id="cart-link" '.$display.' href="'.get_permalink(get_option('cart_page_wprp')).'">Оформити замовлення</a></div>';
	return $mini;
}
add_shortcode('minicart','get_minicart_data');

function get_cart_data(){ 
	
	if(!is_admin()){
		
	$get_fields_order = get_option( 'wp_reservation_orders_field' );
				
			if($get_fields_order){
				$number_field=0;
					foreach((array)$get_fields_order as $custom_field){
				
						$slug = str_replace('-','_',$custom_field['slug']);
						if($custom_field['req']==1) $requared = ' <span class="req-star">*</span> ';
							else $requared = '';
						$order_field .= '<tr><td><label for="pass1">'.$custom_field['title'].$requared.':</label></th>';
						if($custom_field['type']=='text'||$custom_field['type']=='email')
							$order_field .= '<td><input type="text" name="'.$slug.'" class="regular-text" id="'.$slug.'" maxlength="50" value="" /><br/></td>';
						if($custom_field['type']=='textarea')
							$order_field .= '<td><textarea name="'.$slug.'" class="regular-text" id="'.$slug.'" rows="5" cols="50"></textarea></td>';
						if($custom_field['type']=='select'){
							$fields = explode('#',$custom_field['field_select']);
							$count_field = count($fields);
							for($a=0;$a<$count_field;$a++){
								$field_select .='<option value="'.$fields[$a].'">'.$fields[$a].'</option>';
							}
							$order_field .= '<td><select name="'.$slug.'" class="regular-text" id="'.$slug.'">
							'.$field_select.'
							</select></td>';
						}
						if($custom_field['type']=='file') 
							$order_field .='<td><input type="file" name="'.$slug.'" id="'.$slug.'"></td>';
						$order_value[$number_field]['other'] .= $slug;
						if($custom_field['type']=='checkbox'){
							$chek = explode('#',$custom_field['field_select']);
							$count_field = count($chek);
							$order_field .='<td>';
							for($a=0;$a<$count_field;$a++){
								$number_field++;
								$slug_chek = $slug.'_'.$a;
								$order_field .='<input type="checkbox" id="'.$slug_chek.'" name="'.$slug_chek.'" value="'.$chek[$a].'"> '.$chek[$a].'<br />';
								$order_value[$number_field]['chek'] .= $slug_chek;
							}
							$order_field .='</td>';
						}
						if($custom_field['type']=='radio'){
							$radio = explode('#',$custom_field['field_select']);
							$count_field = count($radio);
							$order_field .='<td>';
							for($a=0;$a<$count_field;$a++){
								$number_field++;
								$slug_chek = $slug.'_'.$a;
								$order_field .='<input type="radio" '.checked($a,0,false).' name="'.$slug.'" id="'.$slug_chek.'" value="'.$radio[$a].'"> '.$radio[$a].'<br />';
								$order_value[$number_field]['radio']['name'] .= $slug;
								$order_value[$number_field]['radio']['id'] .= $slug_chek;
							}
							
							$order_field .='</td>';
						}
						
						$order_field .= '</tr>';
						$number_field++;
						
					}					
				}
	}
	
	//print_r($_SESSION);
	foreach((array)$_SESSION['order-place'] as $id => $ses_value){
	
		$options = get_option('options-reservation-place-'.$id);
		$place = get_option('list-reservation-place-'.$id);
		$cols = $options['cols'];
		$rows = $options['rows'];

		foreach($ses_value as $session => $value){
	
			for($r=0;$r<=$rows;$r++){
				for($c=1;$c<=$cols;$c++){
					if($r==0){
					}else{					
						if($_SESSION['order-place'][$id][$session][$r.'-'.$c]){
							if($place['name'][$r.'-'.$c]){
								
								$post_id = $value[$r.'-'.$c];
								$sess = explode('#',$session);
								$date = $sess[0];
								$time = $sess[1];
								$margin = wrp_get_margin_price($post_id,$time);								
								$price = $place['price'][$r.'-'.$c] + $margin;
								
								if($options['view-rows']) $nr = (isset($place['rows'][$r]))? $place['rows'][$r]: $r;
								else $nr = false;
								if($nr) $nr = 'Ряд: '.$nr;
								$ses_slug = preg_replace('/[^\d]*/','',$session);
								$basketdata .= '<tr id="row-'.$id.'-'.$ses_slug.'-'.$r.'-'.$c.'">						
								<td>'.$place['name'][$r.'-'.$c].' 
								<input type="hidden" class="hidden-info" id="'.$id.'-'.$ses_slug.'-'.$r.'-'.$c.'" name="idplace[]" value="'.$r.'-'.$c.'">
								</td>
								<td class="name-row">'.$nr.'</td>
								<td data-post="'.$post_id.'" class="comment-place">"'.get_the_title($post_id).'"</td>
								<td>
								<span class="session-place">'.$date.' '.$time.'
								<input type="hidden" class="session-info" id="session-'.$id.'-'.$ses_slug.'-'.$r.'-'.$c.'" name="session-'.$id.'-'.$ses_slug.'-'.$r.'-'.$c.'" value="'.$session.'">
								</span>
								</td>
								<td>
									'.$options['name'].'
									<input type="hidden" class="zal-id" id="zal-'.$id.'-'.$ses_slug.'-'.$r.'-'.$c.'" name="session-'.$id.'-'.$ses_slug.'-'.$r.'-'.$c.'" value="'.$id.'">
								</td>
								<td><span class="price-place">'.$price.'</span>грн.</td>
								<td><a href="#" id="'.$id.'-'.$ses_slug.'-'.$r.'-'.$c.'" class="outcart">Видалити</a></td>
								</tr>';
								$summa += $price;	
							}
						}	
					}
				}
			}
			
		}
	
	}
	
	if($summa){
		$basket .= '<div class="block_zamovlenya"><table id="cart-reservation"><tr><td>Замовленні місця</td><td></td><td>Назва</td><td>Час проведення</td><td>Зал</td><td>Вартість</td><td></td></tr>';
		$basket .= $basketdata;
		$basket .= '<tr><td colspan="5">Сума замовлення</td><td><span id="price-allplace">'.$summa.'</span>грн.</td><td><a href="#" class="empty-cart">Очистити корзину</a></td></tr>
		</table>';
	}
	if(!$summa) $basket .= '<h3>Ваша корзина поки пуста!</h3>';
	
	if($summa){ 
			
			$basket .= '<div class="confirm">';
			if($order_field) $basket .= '<h3 align="center">Для оформлення замовлення заповніть форму нижче:</h3>';
			
			$basket .= '<div id="regnewuser"  style="display:none;"></div>';
			
			if(!is_admin()){
				$basket .= '<table class="form-table">
				'.$order_field.'
				</table>';
			}
			
			if($summa) $basket .= '<input class="confirm_order" type="button" value="Підтвердіть замовлення">';	
			$basket .= '</div>
			<div class="redirectform" style="text-align:center;"></div></div>';
			$basket .= "<script>
			jQuery(function(){
				jQuery(document).on('click','.confirm_order',function(){";
				
				if(!is_admin()){
					foreach((array)$order_value as $value){
						if($value['chek']){
							$basket .=  "if(jQuery('#".$value['chek']."').attr('checked')=='checked') var ".$value['chek']." = jQuery('#".$value['chek']."').attr('value');";
							$reg_request .= "+'&".$value['chek']."='+".$value['chek'];
						}
						if($value['radio']){
							$basket .=  "if(jQuery('#".$value['radio']['id']."').attr('checked')=='checked') var ".$value['radio']['name']." = jQuery('#".$value['radio']['id']."').attr('value');";
							$reg_radio .= "+'&".$value['radio']['name']."='+".$value['radio']['name'];
						}
						if($value['other']){
							$basket .=  "var ".$value['other']." = jQuery('#".$value['other']."').attr('value');";
							$reg_request .= "+'&".$value['other']."='+".$value['other'];
						}
					}
				}
				
				if(is_admin()) $admin = "&admin=1";
				else $admin = "";
				
				$basket .= "
					var idplace = new Array();
					var session = new Array();
					var zalid = new Array();
					var comment = new Array();
					var post = new Array();
					var i=0;
					var postdata = '';
					var count = 0;
					jQuery('#cart-reservation').find('.hidden-info').each(function(){
						i++;
						idplace[i] = jQuery(this).attr('value');
						var ses_id = jQuery(this).attr('id');
						session[i] = jQuery('#session-'+ses_id).attr('value');
						zalid[i] = jQuery('#zal-'+ses_id).attr('value');
						comment[i] = jQuery('#row-'+ses_id+' .comment-place').text();
						post[i] = jQuery('#row-'+ses_id+' .comment-place').data('post');
						postdata += 'idplace-'+[i]+'='+ idplace[i]+'&session-'+[i]+'='+ session[i]+'&zalid-'+[i]+'='+ zalid[i]+'&comment-'+[i]+'='+ comment[i]+'&post-'+[i]+'='+ post[i]+'&';		
					});
					var dataString = postdata+'action=confirm_order_reservation".$admin."&count='+i+'&e_mail_95='+$('#e_mail_95').val()+'&telefon_56='+$('#telefon_56').val()+'&pib_91='+$('#pib_91').val();
					jQuery.ajax({
					type: 'POST',
					data: dataString,
					dataType: 'json',
					url: '".get_bloginfo('wpurl')."/wp-admin/admin-ajax.php',
					success: function(data){
						if(data['otvet']==100){
							jQuery('.redirectform').html(data['redirectform']);
							jQuery('.confirm').remove();
							jQuery('.outcart').remove();
							jQuery('.empty-cart').remove();
						} else if(data['otvet']==10){
						   jQuery('.redirectform').html(data['amount']);
						} else if(data['otvet']==5){
							jQuery('#regnewuser').html(data['recall']);
							jQuery('#regnewuser').slideDown(500).delay(5000).slideUp(500);
						}else {
						   alert('Помилка перевірки даних.');
						}
					} 
					});	
					
					return false;
				});
			});
			</script>";

	}
	return $basket;
}
add_shortcode('cart','get_cart_data');

if(is_admin()) add_action('admin_init', 'options_zalid', 1);
function options_zalid(){
	add_meta_box( 'zalid', 'Место проведения мероприятия', 'zalid_options', 'action', 'normal', 'high'  );
}

function zalid_options( $post ){
global $wpdb;

	$zal_array = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."options WHERE option_name LIKE 'options-reservation-place%'");
	
	$place_list = '<p><select name="wprp[place_id]">
	<option value="">- - - -</option>';
	foreach((array)$zal_array as $zal_data){
		$id_form = preg_replace("/[a-z_-]+/", '', $zal_data->option_name);
		$options = get_option('options-reservation-place-'.$id_form);
		$place_list .= '<option value="'.$id_form.'" '.selected($id_form,get_post_meta($post->ID,'place_id',1),false).'>'.$options['name'].'</option>';
	}
	$place_list .= '</select></p>';
	
	$place_list .= '<p>Дата (Формат даты: d.m.Y) <input type="text" style="width:100%" name="wprp[date-action]" value="'.get_post_meta($post->ID,'date-action',1).'"><br>
	Интервалы дат разделять дефисом (-), отдельные даты и интервалы дат разделять запятой (,)</p>';
	
	echo $place_list;
?>
	<input type="hidden" name="wprp_page_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" /><?php
}

add_action('save_post', 'wprp_post_update', 0);
function wprp_post_update( $post_id ){
    if ( !wp_verify_nonce($_POST['wprp_page_nonce'], __FILE__) ) return false;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false;
	if ( !current_user_can('edit_post', $post_id) ) return false;
	if( !isset($_POST['wprp']) ) return false;	
	$_POST['wprp'] = array_map('trim', $_POST['wprp']);
	foreach( (array)$_POST['wprp'] as $key=>$value ){
		if(empty($value)) delete_post_meta($post_id, $key);
		else update_post_meta($post_id, $key, $value);
	}
	return $post_id;
}

function wrp_update_order_status($order_id,$status){
	global $wpdb;
	
	$email = false;

	if($status==1){ //оплачен
		//print_r($order_id);exit;
		$wpdb->update( WP_PREFIX ."reservation_orders_history", 
			array( 'res_status' => $status ),
			array( 'res_order' => $order_id)
		);
						
		$place_data = get_option('list-reservation-place');
		
		$allplace = $wpdb->get_results("SELECT user_email,res_session,res_place FROM ".WP_PREFIX."reservation_orders_history WHERE res_order = '$order_id'");
		
		foreach($allplace as $place){
			$place_data['status'][$place->res_session][$place->res_place]='closed';
			$email = $place->user_email;
		}

		update_option('list-reservation-place', $place_data);
	}
	
	if($status==4){ //забронированы
		$wpdb->update( WP_PREFIX ."reservation_orders_history", 
			array( 'res_status' => $status ),
			array( 'res_order' => $order_id)
		);
						
		$place_data = get_option('list-reservation-place');
		
		$allplace = $wpdb->get_results("SELECT res_session,res_place FROM ".WP_PREFIX."reservation_orders_history WHERE res_order = '$order_id'");
		
		foreach($allplace as $place){
			$place_data['status'][$place->res_session][$place->res_place]='closed';
			$email = $place->user_email;
		}

		update_option('list-reservation-place', $place_data);
	}
	
	if($email){
		
		if(get_option('qr_code_wprp')) include_once('a-qr-code/a-qr-code.php');	
		
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		$headers = 'From: '.get_bloginfo('name').' <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
		$subject = 'Заказ оплачен!';
		
		$textmail = '
		<p>Ваше замовлення, сформирмоване в "'.get_bloginfo('name').'" було позначено як оплачено.</p>
		<h3>Інформація про клієнта:</h3>
		<p><b>Email</b>: '.$email.'</p>
		<p>Замовлення №'.$order_id.' отримало статус "Оплачено".</p>';
		if (function_exists('aQRCode')) { 
			$textmail .= '<p>Скачайте и распечатайте свой билет (QR-code). Для подтверждения вашего заказа просто предъявите его при входе на мероприятие.</p>';
			$url_attach = aQRCode('Заказ №'.$order_id);
			$attach = array($url_attach);
		}	  
		$textmail .= '<p>Это письмо было создано автоматически, не надо отвечать на него</p>';				
		wp_mail($email, $subject, $textmail, $headers,$attach);
	}
}

//Удаление заказа
function wrp_delete_order($id_order){
	global $wpdb;
	
	$order_data = $wpdb->get_results("SELECT res_session,res_place,res_zalid FROM ".WP_PREFIX."reservation_orders_history WHERE res_order = '$id_order'");
		
	foreach($order_data as $d){
		$data_or[$d->res_zalid][$d->res_session][] = $d->res_place;
	}
	
	foreach($data_or as $zalid=>$ses_data){
		$place = get_option('list-reservation-place-'.$zalid);
		
		foreach($ses_data as $ses=>$pl){
			$old_status = $place['status'][$ses];
			foreach($pl as $code){
				foreach($old_status as $code_place=>$status){						
					if($code_place==$code) unset($place['status'][$ses][$code_place]);	
				}
			}
			
		}
	
		foreach($place['status'] as $session => $value){
			if($value) $new_place[$session] = $value;
		}
		$place['status'] = $new_place;
		
		update_option('list-reservation-place-'.$zalid,$place);
		$place = '';
		$new_place='';
	}

	$wpdb->query("DELETE FROM ". WP_PREFIX ."reservation_details_orders WHERE order_id = '$id_order'");
	$wpdb->query("DELETE FROM ". WP_PREFIX ."reservation_pay_results WHERE res_order = '$id_order'");
	$res = $wpdb->query("DELETE FROM ". WP_PREFIX ."reservation_orders_history WHERE res_order = '$id_order'");
	
	return $res;
}

//Удаляем неоплаченные в течении часа заказы
add_action('wp','wrp_check_nopay_order');
function wrp_check_nopay_order(){
	global $wpdb;
	
	if(!get_option('wp_reservation_connect_sale')) return false;
	
	//$orders = $wpdb->get_results("SELECT res_order FROM ".WP_PREFIX."reservation_orders_history WHERE res_status='0' && timeaction  BETWEEN (NOW()-INTERVAL 3 HOUR) AND (NOW() - INTERVAL 1 HOUR) GROUP BY res_order");
	
		$orders = $wpdb->get_results("SELECT res_order,timeaction FROM ".WP_PREFIX."reservation_orders_history WHERE res_status='0' GROUP BY res_order");

	
	if(!$orders) return false;
	$now= strtotime(date("Y-m-d H:i:s"));

	foreach($orders as $order){
		$minute= ($now - strtotime($order->timeaction))/60;
		if($minute>60&&$minute<180){
			wrp_delete_order($order->res_order);
		}
	}
}

include('admin-kassa.php');
include 'ajax-functions.php';