jQuery(function(){
	function str_replace_reservation(search, replace, subject) {
		return subject.split(search).join(replace);
	}
	jQuery('.getplace').hover(
		
		function(){		
			var id_place = jQuery(this).attr('id');
			var id_info = str_replace_reservation('place-','info-',id_place);
			jQuery('#'+id_info).css('display','block');
		},
		function(){
			var id_place = jQuery(this).attr('id');
			var id_info = str_replace_reservation('place-','info-',id_place);
			jQuery('#'+id_info).removeAttr('style');
	});
	
	jQuery('.getplace').on('click',function(){
		var idplace = jQuery(this).attr('id');
		var session = jQuery('#place-session').attr('value');
		var zal_id = jQuery('#zal-id').attr('value');
		var post_id = jQuery('#post-id').attr('value');
		idplace = str_replace_reservation('place-','',idplace);
		var dataString = 'action=add_place_in_basket&idplace='+idplace+'&session='+session+'&zalid='+zal_id+'&post_id='+post_id;
		jQuery.ajax({
			type: 'POST',
			data: dataString,
			dataType: 'json',
			url: "/wp-admin/admin-ajax.php",
			success: function(data){
				if(data['recall']==100){
					jQuery('#place-'+data['place']).removeClass('getplace').addClass('ordered');
					jQuery('#count-place').html(data['count']);
					jQuery('#cart-link').fadeIn();
				}else if(data['recall']==200){
					alert('Перебільшено максимальну кіл-ть мість на одне замовлення! Максимальна кіл-ть - '+data['max']);
				}else{
					alert('Помилка!');
				}
			} 
		});  	
		return false;
	});
	
	jQuery('.ordered').on('click',function(){
		var idplace = jQuery(this).attr('id');
		var session = jQuery('#place-session').attr('value');
		var zal_id = jQuery('#zal-id').attr('value');
		idplace = str_replace_reservation('place-','',idplace);
		var dataString = 'action=delete_place_in_basket&idplace='+idplace+'&session='+session+'&zalid='+zal_id;
		jQuery.ajax({
			type: 'POST',
			data: dataString,
			dataType: 'json',
			url: "/wp-admin/admin-ajax.php",
			success: function(data){
				if(data['recall']==100){
					jQuery('#place-'+data['place']).removeClass('ordered').addClass('getplace');
					jQuery('#count-place').html(data['count']);
					if(data['count']=='0') jQuery('#cart-link').fadeOut();
					var price = parseInt(jQuery('#row-'+data['place']+' .price-place').text());
					if(price){
						var allprice = parseInt(jQuery('#price-allplace').text());
						var new_allprice = allprice - price;
						jQuery('#price-allplace').text(new_allprice);
						jQuery('#row-'+data['place']).remove();
					}
				}else{
					alert('Помилка!');
				}
			} 
		});  	
		return false;
	});
	
	jQuery('.outcart').on('click',function(){
		var idslug = jQuery(this).attr('id');
		var session = jQuery('#session-'+idslug).attr('value');
		var zalid = jQuery('#zal-'+idslug).attr('value');
		var idplace = jQuery('#row-'+idslug+' .hidden-info').attr('value');
		var dataString = 'action=delete_place_out_cart_page&idplace='+idplace+'&session='+session+'&zalid='+zalid;
		jQuery.ajax({
			type: 'POST',
			data: dataString,
			dataType: 'json',
			url: "/wp-admin/admin-ajax.php",
			success: function(data){
				if(data['recall']==100){					
					jQuery('#count-place').html(data['count']);
					if(data['count']=='0'){
						jQuery('#cart-link').fadeOut();
						jQuery('.confirm_order').remove();
					}
					var price = parseInt(jQuery('#row-'+idslug+' .price-place').text());
					if(price){
						var allprice = parseInt(jQuery('#price-allplace').text());
						var new_allprice = allprice - price;
						jQuery('#price-allplace').text(new_allprice);
						jQuery('#row-'+idslug).remove();
					}
				}else{
					alert('Помилка!');
				}
			} 
		});  	
		return false;
	});
	
	jQuery('.empty-cart').on('click',function(){
		
		var dataString = 'action=get_empty_basket';
		jQuery.ajax({
			type: 'POST',
			data: dataString,
			dataType: 'json',
			url: "/wp-admin/admin-ajax.php",
			success: function(data){
				if(data['recall']==100){
					jQuery('#cart-reservation').empty();
					jQuery('.confirm_order').remove();					
				}else{
					alert('Помилка!');
				}
			} 
		});  	
		return false;
	});
	
});
