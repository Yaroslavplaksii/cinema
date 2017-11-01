jQuery(document).ready(function(){	

	var tbframe_interval;
	var value;
	var button;
	var i=0;
    jQuery('#back-wrp .add-back').on('click',function() {
		button = jQuery(this);
        tb_show('', 'media-upload.php?type=image&TB_iframe=true&width=800');
        tbframe_interval = setInterval(function() {
			jQuery('#TB_iframeContent').contents().find('.subsubsub').remove();
			jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Выбрать фоном');
			value = jQuery('#TB_iframeContent').contents().find('.open .url .field .urlfield').val();		
		}, 2000);

        return false;
    });

    window.send_to_editor = function(html) {	
        clearInterval(tbframe_interval);
		button.parent().children('#back-wrp .url-back').val(value);
        tb_remove();		
    };
	
	/*var file_frame;
	jQuery('#back-wrp .add-back').on('click', function(event){
			event.preventDefault();
			if ( file_frame ) {
				file_frame.open();
		  return;
		}
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
		  title: jQuery( this ).data( 'File upload' ),
		  button: {
			text: jQuery( this ).data( 'Upload' ),
		  },
		  multiple: false  // Set to true to allow multiple files to be selected
		});
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
		  // We set multiple to false so only get one image from the uploader
		  attachment = file_frame.state().get('selection').first().toJSON();
			jQuery('#back-wrp .url-back').attr('value',attachment.url);
		});

		// Finally, open the modal
		file_frame.open();
	});*/

	function str_replace_reservation(search, replace, subject) {
		return subject.split(search).join(replace);
	}
	
	function isnum( num ) {
		return res = ( num / num ) ? true : false;
	}

	jQuery(".color-tariff").wpColorPicker();
	//jQuery('.datepicker').datepicker();	

	jQuery('#add_tariff').click(function() {
        jQuery('<tr class="tariff"><td class="price-row">Вартість: <input size="3" type="text" value="" name="price-tariff[]">р. <input type="text" value="" class="color-tariff" name="color-tariff[]"></td></tr>').fadeIn('slow').appendTo('#table-tariff');
		jQuery(".color-tariff").wpColorPicker();
		return false;
    });
	
	jQuery('#price-blocks .price-block').click(function() {
		if(jQuery(this).hasClass('active')){
			jQuery(this).removeClass('active');
			jQuery('#config-places').removeClass('false');
			return false;
		}
		jQuery('#config-places').addClass('false');
		jQuery('#price-blocks .price-block').removeClass('active');
		jQuery(this).addClass('active');
	});
	
	jQuery('.back-false').click(function() {
		var type = jQuery('#price-blocks .active').children('.typetariff').attr('value');
		if(jQuery(this).parent().hasClass(type)){
			jQuery(this).next().val('');
			jQuery(this).parent().removeClass(type);
			jQuery(this).prev().attr('disabled',false);
			return false;
		}
		var price = jQuery('#price-blocks .active').children('.pricetariff').attr('value');
		jQuery(this).next().attr('value',price);
		jQuery(this).parent().removeClass().addClass('place '+jQuery('#price-blocks .active').children('.typetariff').attr('value'));
		if(!isnum(price)) jQuery(this).prev().attr('disabled',true);
		else jQuery(this).prev().attr('disabled',false);
	});
	
	jQuery('.type-autocomplete').click(function() {
		var type = jQuery(this).attr('autocomplete');
		var i=0;
		var value;
		var index;
		var cancel = false;
		jQuery('#config-places').find('.place').each(function(){		
			value = jQuery(this).children('.price-place').val();
			//if(value&&isnum(value)){
				index = jQuery(this).attr('index');
				if(index==1) cancel = true;
				if(value&&isnum(value)){
					++i;
					if(type==1) jQuery(this).children('.name-place').val(i);
					if(type==2){
						jQuery(this).children('.name-place').val(jQuery(this).attr('row')+'-'+i);
					}
					if(type==3){
						if(cancel) i = 1;
						jQuery(this).children('.name-place').val(i);
					}
					if(type==4){
						if(cancel) i = 1;
						jQuery(this).children('.name-place').val(jQuery(this).attr('row')+'-'+i);
					}
					cancel = false;
				}else{
					jQuery(this).children('.name-place').val('');
				}
			//}
		});
	});
	
	var i = jQuery('#inputs_order_fields .field').size();
    jQuery('#add_order_field').click(function(){
        jQuery('<li class="menu-item menu-item-edit-active"><dl class="menu-item-bar"><dt class="menu-item-handle"><span class="item-title"><input type="text" size="40" name="order_fields_title[]" class="field" value=""/></span><span class="item-controls"><span class="item-type">Тип: <select name="type_field_'+i+'"><option value="email">E-mail</option><option value="text">Однострочное поле</option><option value="textarea">Многострочное поле</option><option value="select">Выпадающий список</option><option value="checkbox">Чекбокс</option><option value="radio">Радиокнопки</option></select></span></span></dt></dl><div class="menu-item-settings" style="display: block;"><p><input type="checkbox" name="requared_field_'+i+'" value="1"/> обязательное поле</p></div></li>').fadeIn('slow').appendTo('.order_fields');
		i++;
		return false;
    });
	
	jQuery('.profilefield-submitdelete').click(function() {
		var id_item = jQuery(this).attr('id');
		jQuery('#item-'+id_item+' .field').attr('value','');
		jQuery('#settings-'+id_item).slideUp();
		jQuery('#item-'+id_item+' .item-controls').empty();
		jQuery('#item-'+id_item+' .item-title').text('Будет удалено');
		return false;
	});
	jQuery('.profilefield-item-edit').click(function() {
		var id_button = jQuery(this).attr('id');
		var id_item = str_replace_reservation('edit-','settings-',id_button);	
		jQuery('#'+id_item).slideToggle();
		return false;
	});
/*************************************************
Удаляем заказ воопще)
*************************************************/
	jQuery('.delete-order').on('click',function(){
		if(confirm('Уверены?')){
			var idorder = jQuery(this).attr('id');
			var dataString_reg = 'action=all_delete_order_reservation&idorder='+ idorder;

			jQuery.ajax({
			type: 'POST',
			data: dataString_reg,
			dataType: 'json',
			url: ajaxurl,
			success: function(data){
				if(data['otvet']==100){
					jQuery('#row-'+data['idorder']).remove();
				}else{
					alert('Ошибка при удалении заказа!');
				}
			} 
			});	  	
			return false;
		}
	});
});