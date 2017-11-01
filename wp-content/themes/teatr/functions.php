<?php 

if (!current_user_can('manage_options')) {

	add_filter('show_admin_bar', '__return_false');

}

 

if (!current_user_can('edit_posts')) {

	add_filter('show_admin_bar', '__return_false');

}



function teatr_setup() {

    add_theme_support('post-thumbnails');

	set_post_thumbnail_size(368, 534, true);

 }

add_action('after_setup_theme', 'teatr_setup');



if ( function_exists( 'add_theme_support' ) ) {

	add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size(368,534); // размер миниатюры поста по умолчанию

}

if ( function_exists( 'add_image_size' ) ) {

	add_image_size( 'category-thumb',368,534); // 300 в ширину и без ограничения в высоту

	add_image_size( 'homepage-thumb',368,534, true ); // Кадрирование изображения

}

function trim_excerpt($text) { 

        $text = rtrim($text,'[...]');

  return rtrim($text,'[&hellip');

}

add_filter('get_the_excerpt', 'trim_excerpt');



if ( function_exists('register_sidebar') )

    register_sidebar(array(

        'name' => 'Top Block',

        'id' => 'primary-widget-area',

        'before_widget' => '',

        'after_widget' => '',

        'before_title' => '<div class="title">',

        'after_title' => '</div>',

    ));

    

if (class_exists('MultiPostThumbnails')) { 

new MultiPostThumbnails(array(

'label' => 'Зображення для банера на головну',

'id' => 'secondary-image',

'post_type' => 'post'

 ) ); 

 }

 function true_register_wp_sidebars() {

 

	/* В боковой колонке - первый сайдбар */

	register_sidebar(

		array(

			'id' => 'true_side', // уникальный id

			'name' => 'Field subscribe', // название сайдбара

			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание

			'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком

			'after_widget' => '</div>',

			'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>

			'after_title' => '</h3>'

		)

	);

 

	/* В подвале - второй сайдбар */

	register_sidebar(

		array(

			'id' => 'true_foot',

			'name' => 'Футер',

			'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',

			'before_widget' => '<div id="%1$s" class="foot widget %2$s">',

			'after_widget' => '</div>',

			'before_title' => '<h3 class="widget-title">',

			'after_title' => '</h3>'

		)

	);

}

 

add_action( 'widgets_init', 'true_register_wp_sidebars' );

if ( function_exists('register_sidebar') )

    register_sidebar(array(

        'name' => 'Top Block',

        'id' => 'second-widget-area',

        'before_widget' => '',

        'after_widget' => '',

        'before_title' => '<div class="title">',

        'after_title' => '</div>',

    ));

    



function my_meta_box() {  

    add_meta_box(  

        'my_meta_box', // Идентификатор(id)

        'Відомості про фільм', // Заголовок области с мета-полями(title)

        'show_my_metabox', // Вызов(callback)

        'post', // Где будет отображаться наше поле, в нашем случае в Записях

        'normal', 

        'high');

}  

add_action('add_meta_boxes', 'my_meta_box'); 



$meta_fields = array(    

    array(  

        'label' => 'Посилання на vkino.ua:',  

        'desc'  => 'посилання',  

        'id'    => 'linkvkino', // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ), 
    array(  

        'label' => 'Країна:',  

        'desc'  => 'країна',  

        'id'    => 'country', // даем идентификатор.

        'type'  => 'text',

        'class' => '' // Указываем тип поля.

    ),  

     array(  

        'label' => 'Рік:',  

        'desc'  => 'рік (тільки число)',  

        'id'    => 'year', // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ), 

     array(  

        'label' => 'Жанр:',  

        'desc'  => 'жанр',  

        'id'    => 'ganr', // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ),  

    array(  

        'label' => 'Режисер:',  

        'desc'  => 'режисер',  

        'id'    => 'regiser', // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ),

     array(  

        'label' => 'У ролях:',  

        'desc'  => 'у ролях',  

        'id'    => 'roles', // даем идентификатор.

        'type'  => 'textarea',

        'class' => ''  // Указываем тип поля.

    ),

      array(  

        'label' => 'Сценарій:',  

        'desc'  => 'сценарій',  

        'id'    => 'scenarii', // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ),

     array(  

        'label' => 'Бюджет:',  

        'desc'  => 'бюджет (тільки число)',  

        'id'    => 'baxs', // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ),

    array(  

        'label' => 'Тривалість:',  

        'desc'  => 'тривалість (тільки число в хвилинах)',  

        'id'    => 'minutes', // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ),

    array(  

        'label' => 'Дата початку прокату:',  

        'desc'  => 'дата початку прокату',  

        'id'    => 'startshow', // даем идентификатор.

        'type'  => 'date',

        'class' => ''  // Указываем тип поля.

    ),
      array(  

        'label' => 'Дата кінця прокату:',  

        'desc'  => 'дата кінця прокату',  

        'id'    => 'endshow', // даем идентификатор.

        'type'  => 'date',

        'class' => ''  // Указываем тип поля.

    ),
    array(  

        'label' => 'Рейтинг фільму:',  

        'desc'  => 'рейтинг фільму (потрібно задати число, можна ціле: наприклад 8 або з дійне, наприклад 9.5-через крапочку)',  

        'id'    => 'rating',  // даем идентификатор.

        'type'  => 'text',

        'class' => ''  // Указываем тип поля.

    ),

      array(  

        'label' => 'Трейлер:',  

        'desc'  => 'трейлер (потрібно задати ширину width - 100%, висоту height - 550 )',  

        'id'    => 'videorolik',  // даем идентификатор.

        'type'  => 'textarea',

        'class' => ''  // Указываем тип поля.

    ),

    array( 
        'label' => 'Графік сеансів на поточний тиждень:  ',  
        'desc'  => 'з',  
        'id'    => 'showstart',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'rozklad',
        'style' => 'float:left;width:20%;'  // Указываем тип поля.
    ),
    array( 
        'label' => '', 
        'desc'  => 'по',  
        'id'    => 'showend',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'rozklad',
        'style' => 'float:left;width:80%;'  // Указываем тип поля.
    ),
    
    /*--------------------------------------*/
   /*1*/
    array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date1',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date1',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  
        'label' => 'Зал',  
        'desc'  => 'зал',  
        'id'    => 'select1', 
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),
            'two' => array (  
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
           )
        ) 
    ),     
     array( 
        'label' => '',  
        'desc'  => 'початок показу',  
        'id'    => 'time1',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time1',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
     array( 
        'label' => 'Вартість:',
        'desc'  => 'вартість',  
        'id'    => 'cast1',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast1',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url1',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url1',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*2*/
      array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date2',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date2',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал', 
        'desc'  => 'зал', 
        'id'    => 'select2',
        'type'  => 'select', 
        'class' => 'rozklad',
        'style' => 'float:left;width:20%;height:50px;display:block',
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:',
        'desc'  => 'початок показу',  
        'id'    => 'time2',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time2',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
     array(  

        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast2',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast2',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url2',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url2',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*3*/
      array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date3',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date3',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(
        'label' => 'Зал', 
        'desc'  => 'зал',  
        'id'    => 'select3',  
        'type'  => 'select',  
        'class' => 'rozklad',         
        'style' => 'float:left;width:20%;height:50px;display:block',
        'options' => array (  // Параметры, всплывающие данны
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),
            'two' => array (  
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time3',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time3',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
     array( 
        'label' => 'Вартість:', 
        'desc'  => 'вартість', 
        'id'    => 'cast3',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast3',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url3',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url3',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*4*/
      array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date4',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date4',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал', 
        'id'    => 'select4', 
        'type'  => 'select', 
        'class' => 'rozklad',
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array (  
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        ) 
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time4',  
        'type'  => 'time',
        'class' => 'time4',
        'style' => 'float:left;width:20%;height:50px;display:block'  
    ),
     array( 
        'label' => 'Вартість:', 
        'desc'  => 'вартість',
        'id'    => 'cast4', 
        'type'  => 'text',
        'class' => 'cast4',
        'style' => 'float:left;width:20%;height:50px;display:block'  
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url4',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url4',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*5*/
     array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date5',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date5',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',
        'id'    => 'select5',
        'type'  => 'select',
        'class' => 'rozklad',
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array (  
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time5',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time5',  // Указываем тип поля.
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:', 
        'desc'  => 'вартість',  
        'id'    => 'cast5',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast5',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
     array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url5',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url5',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
/*6*/
 array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date6',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date6',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  
        'label' => 'Зал', 
        'desc'  => 'зал',  
        'id'    => 'select6',
        'type'  => 'select',  
        'class' => 'rozklad',
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array (  
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array( 
        'label' => 'Початок показу:',  
        'desc'  => 'початок показу',  
        'id'    => 'time6',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time6',        
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість', 
        'id'    => 'cast6',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast6',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url6',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url6',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
/*7*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date7',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date7',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  
        'label' => 'Зал', 
        'desc'  => 'зал',  
        'id'    => 'select7', 
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block',
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array (  
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:',  
        'desc'  => 'початок показу',  
        'id'    => 'time7',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time7',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість', 
        'id'    => 'cast7',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast7',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url7',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url7',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*8*/
    array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date8',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date8',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  
        'label' => 'Зал',  
        'desc'  => 'зал',  
        'id'    => 'select8',  
        'type'  => 'select', 
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block',
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array (
                'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение            
                )
        ) 
    ),
     array(  
        'label' => 'Початок показу:',
        'desc'  => 'початок показу',  
        'id'    => 'time8',  
        'type'  => 'time',
        'class' => 'time8', 
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:', 
        'desc'  => 'вартість',  
        'id'    => 'cast8',  
        'type'  => 'text',
        'class' => 'cast8',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
 array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url8',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url8',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*9*/
    array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date9',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date9',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  

        'label' => 'Зал',  

        'desc'  => 'зал',  

        'id'    => 'select9',  

        'type'  => 'select',  

        'class' => 'rozklad',  
        'style' => 'float:left;width:20%;height:50px;display:block',

        'options' => array (  // Параметры, всплывающие данные

            'one' => array (  

                'label' => 'Червоний зал',  // Название поля

                'value' => 'red'  // Значение

            ),  

            'two' => array (  

                'label' => 'Зелений зал',  // Название поля

                'value' => 'green'  // Значение

            )

        )  

    ),

     array(  

        'label' => 'Початок показу:',  

        'desc'  => 'початок показу',  

        'id'    => 'time9',  // даем идентификатор.

        'type'  => 'time',

        'class' => 'time9',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),

     array(  

        'label' => 'Вартість:',  

        'desc'  => 'вартість',  

        'id'    => 'cast9',  // даем идентификатор.

        'type'  => 'text',

        'class' => 'cast9',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url9',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url9',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),

/*10*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date10',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date10',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  

        'label' => 'Зал',  

        'desc'  => 'зал',  

        'id'    => 'select10',  

        'type'  => 'select',  

        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 

        'options' => array (  // Параметры, всплывающие данные

            'one' => array (  

                'label' => 'Червоний зал',  // Название поля

                'value' => 'red'  // Значение

            ),  

            'two' => array (  

                'label' => 'Зелений зал',  // Название поля

                'value' => 'green'  // Значение

            )

        )  

    ),

     array(  

        'label' => 'Початок показу:',  

        'desc'  => 'початок показу',  

        'id'    => 'time10',  // даем идентификатор.

        'type'  => 'time',

        'class' => 'time10',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),

     array(  

        'label' => 'Вартість:',  

        'desc'  => 'вартість',  

        'id'    => 'cast10',  // даем идентификатор.

        'type'  => 'text',

        'class' => 'cast10',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url10',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url10',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*11*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date11',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date11',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),

    array(  

        'label' => 'Зал',  

        'desc'  => 'зал',  

        'id'    => 'select11',  

        'type'  => 'select',  

        'class' => 'rozklad',
        'style' => 'float:left;width:20%;height:50px;display:block',  

        'options' => array (  // Параметры, всплывающие данные

            'one' => array (  

                'label' => 'Червоний зал',  // Название поля

                'value' => 'red'  // Значение

            ),  

            'two' => array (  

                'label' => 'Зелений зал',  // Название поля

                'value' => 'green'  // Значение

            )

        )  

    ),

     array(  

        'label' => 'Початок показу:',  

        'desc'  => 'початок показу',  

        'id'    => 'time11',  // даем идентификатор.

        'type'  => 'time',

        'class' => 'time11',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),

     array(  

        'label' => 'Вартість:',  

        'desc'  => 'вартість',  

        'id'    => 'cast11',  // даем идентификатор.

        'type'  => 'text',

        'class' => 'cast11',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url11',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url11',
        'style' => 'float:left;width:20%;height:50px;display:block'
        
    ),

/*12*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date12',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date12',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  

        'label' => 'Зал',  

        'desc'  => 'зал',  

        'id'    => 'select12',  

        'type'  => 'select',  

        'class' => 'rozklad',  
        'style' => 'float:left;width:20%;height:50px;display:block',

        'options' => array (  // Параметры, всплывающие данные

            'one' => array (  

                'label' => 'Червоний зал',  // Название поля

                'value' => 'red'  // Значение

            ),  

            'two' => array (  

                'label' => 'Зелений зал',  // Название поля

                'value' => 'green'  // Значение

            )

        )  

    ),

     array(  

        'label' => 'Початок показу:',  

        'desc'  => 'початок показу',  

        'id'    => 'time12',  // даем идентификатор.

        'type'  => 'time',

        'class' => 'time12',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),

     array(  

        'label' => 'Вартість:',  

        'desc'  => 'вартість',  

        'id'    => 'cast12',  // даем идентификатор.

        'type'  => 'text',

        'class' => 'cast12',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url12',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url12',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
/*13*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date13',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date13',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  

        'label' => 'Зал',  

        'desc'  => 'зал',  

        'id'    => 'select13',  

        'type'  => 'select',  

        'class' => 'rozklad',  
        'style' => 'float:left;width:20%;height:50px;display:block',

        'options' => array (  // Параметры, всплывающие данные

            'one' => array (  

                'label' => 'Червоний зал',  // Название поля

                'value' => 'red'  // Значение

            ),  

            'two' => array (  

                'label' => 'Зелений зал',  // Название поля

                'value' => 'green'  // Значение

            )

        )  

    ),

     array(  

        'label' => 'Початок показу:',  

        'desc'  => 'початок показу',  

        'id'    => 'time13',  // даем идентификатор.

        'type'  => 'time',

        'class' => 'time13',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),

     array(  

        'label' => 'Вартість:',  

        'desc'  => 'вартість',  

        'id'    => 'cast13',  // даем идентификатор.

        'type'  => 'text',

        'class' => 'cast13',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url13',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url13',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
/*14*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date14',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date14',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  

        'label' => 'Зал',  

        'desc'  => 'зал',  

        'id'    => 'select14',  

        'type'  => 'select',  

        'class' => 'rozklad',
        'style' => 'float:left;width:20%;height:50px;display:block',  

        'options' => array (  // Параметры, всплывающие данные

            'one' => array (  

                'label' => 'Червоний зал',  // Название поля

                'value' => 'red'  // Значение

            ),  

            'two' => array (  

                'label' => 'Зелений зал',  // Название поля

                'value' => 'green'  // Значение

            )

        )  

    ),

     array(  

        'label' => 'Початок показу:',  

        'desc'  => 'початок показу',  

        'id'    => 'time14',  // даем идентификатор.

        'type'  => 'time',

        'class' => 'time14',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),

     array(  

        'label' => 'Вартість:',  

        'desc'  => 'вартість',  

        'id'    => 'cast14',  // даем идентификатор.

        'type'  => 'text',

        'class' => 'cast14',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url14',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url14',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
/*15*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date15',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date15',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array(  

        'label' => 'Зал',  

        'desc'  => 'зал',  

        'id'    => 'select15',  

        'type'  => 'select',  

        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 

        'options' => array (  // Параметры, всплывающие данные

            'one' => array (  

                'label' => 'Червоний зал',  // Название поля

                'value' => 'red'  // Значение

            ),  

            'two' => array (  

                'label' => 'Зелений зал',  // Название поля

                'value' => 'green'  // Значение

            )

        )  

    ),

     array(  

        'label' => 'Початок показу:',  

        'desc'  => 'початок показу',  

        'id'    => 'time15',  // даем идентификатор.

        'type'  => 'time',

        'class' => 'time15',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),

     array(  

        'label' => 'Вартість:',  

        'desc'  => 'вартість',  

        'id'    => 'cast15',  // даем идентификатор.

        'type'  => 'text',

        'class' => 'cast15',
        'style' => 'float:left;width:20%;height:50px;display:block'

    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url15',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url15',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
/*16*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date16',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date16',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select16',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time16',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time16',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast16',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast16',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url16',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url16',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*17*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date17',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date17',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select17',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time17',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time17',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast17',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast17',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url17',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url17',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
/*18*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date18',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date18',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select18',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time18',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time18',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast18',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast18',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url18',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url18',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*19*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date19',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date19',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select19',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time19',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time19',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast19',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast19',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url19',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url19',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*20*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date20',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date20',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select20',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time20',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time20',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast20',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast20',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url20',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url20',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*21*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date21',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date21',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select21',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time21',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time21',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast21',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast21',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url21',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url21',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*22*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date22',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date22',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select22',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time22',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time22',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast22',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast22',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url22',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url22',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*23*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date23',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date23',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select23',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time23',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time23',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast23',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast23',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url23',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url23',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
    /*24*/
array( 
        'label' => '',  
        'desc'  => 'дата показу',  
        'id'    => 'date24',  // даем идентификатор.
        'type'  => 'date',
        'class' => 'date24',
        'style' => 'float:left;width:20%;height:50px;display:block' // Указываем тип поля.
    ),
    array( 
        'label' => 'Зал',
        'desc'  => 'зал',  
        'id'    => 'select24',  
        'type'  => 'select',  
        'class' => 'rozklad', 
        'style' => 'float:left;width:20%;height:50px;display:block', 
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (  
                'label' => 'Червоний зал',  // Название поля
                'value' => 'red'  // Значение
            ),  
            'two' => array ( 
               'label' => 'Зелений зал',  // Название поля
                'value' => 'green'  // Значение
            )
        )  
    ),
     array(  
        'label' => 'Початок показу:', 
        'desc'  => 'початок показу',  
        'id'    => 'time24',  // даем идентификатор.
        'type'  => 'time',
        'class' => 'time24',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
     array(  
        'label' => 'Вартість:',  
        'desc'  => 'вартість',  
        'id'    => 'cast24',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'cast24',
        'style' => 'float:left;width:20%;height:50px;display:block'
    ),
    array( 
        'label' => 'Посилання на сторінку з формою бронювання:',
        'desc'  => 'url сторінки з формою',  
        'id'    => 'url24',  // даем идентификатор.
        'type'  => 'text',
        'class' => 'url24',
        'style' => 'float:left;width:20%;height:50px;display:block'  // Указываем тип поля.
    ),
);

function show_my_metabox() {  

global $meta_fields; // Обозначим наш массив с полями глобальным

global $post;  // Глобальный $post для получения id создаваемого/редактируемого поста

// Выводим скрытый input, для верификации. Безопасность прежде всего!

echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  

  

    // Начинаем выводить таблицу с полями через цикл

  foreach ($meta_fields as $field) {  

          if(!empty($field['class']) && $field['class']){

            $meta = get_post_meta($post->ID, $field['id'], true);

            switch($field['type']) {
                    case 'date':
                    echo '<div class="'.$field['class'].'" style="'.$field['style'].'"><span class="'.$field['id'].'"><b>'.$field['label'].'</b></span><span class="description">'.$field['desc'].'</span><br /><input type="date" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" /></div> ';  
                    break; 
                    case 'select':  
                    echo '<div class="'.$field['class'].'" style="'.$field['style'].'"><span class="description">'.$field['desc'].'</span><br /><select name="'.$field['id'].'" id="'.$field['id'].'">';  
                    foreach ($field['options'] as $option) {  
                        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';  
                    } 
                    echo '</select></div>'; 
                    break;
                    case 'text':  
                    echo '<div class="'.$field['class'].'" style="'.$field['style'].'"><span class="description">'.$field['desc'].'</span><br /><input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'"/></div>';  
                    break;
                    case 'time':  
                    echo '<div class="'.$field['class'].'" style="'.$field['style'].'"><span class="description">'.$field['desc'].'</span><br /><input type="time" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'"  /></div>';  
                    break;
            }  
          } 
   }

   

    echo '<table class="form-table">';  

    foreach ($meta_fields as $field) {  

          if(empty($field['class'])){

        // Получаем значение если оно есть для этого поля 

        $meta = get_post_meta($post->ID, $field['id'], true);  

        // Начинаем выводить таблицу

        echo '<tr> 

                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 

                <td colspan="6">';  

                switch($field['type']) {  

                    case 'text':  

                    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /> 

                        <br /><span class="description">'.$field['desc'].'</span>';  

                    break;

                    case 'date':  

                    echo '<input type="date" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /> 

                        <br /><span class="description">'.$field['desc'].'</span>';  

                    break;

                    case 'textarea':  

                    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea> 

                        <br /><span class="description">'.$field['desc'].'</span>';  

                    break;

                }

        echo '</td></tr>';  

    }

    }

    echo '</table>'; 

     

}



function save_my_meta_fields($post_id) {  

    global $meta_fields;  // Массив с нашими полями

 

    // проверяем наш проверочный код 

    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))   

        return $post_id;  

    // Проверяем авто-сохранение 

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  

        return $post_id;  

    // Проверяем права доступа  

    if ('page' == $_POST['post_type']) {  

        if (!current_user_can('edit_page', $post_id))  

            return $post_id;  

        } elseif (!current_user_can('edit_post', $post_id)) {  

            return $post_id;  

    }  

 

    // Если все отлично, прогоняем массив через foreach

    foreach ($meta_fields as $field) {  

        $old = get_post_meta($post_id, $field['id'], true); // Получаем старые данные (если они есть), для сверки

        $new = $_POST[$field['id']];  

        if ($new && $new != $old) {  // Если данные новые

            update_post_meta($post_id, $field['id'], $new); // Обновляем данные

        } elseif ('' == $new && $old) {  

            delete_post_meta($post_id, $field['id'], $old); // Если данных нету, удаляем мету.

        }  

    } // end foreach  

}  

add_action('save_post', 'save_my_meta_fields'); 



function contact_form(){

echo <<<laba

<form role="form" action="/wp-content/themes/teatr/form.php" method="POST">

   <div class="form-group">	

        <input type="text" name="name" value="" class="form-control" id="name" placeholder="Ваше ім'я *">					

   </div>

    <div class="form-group">

        <input type="text" pattern="|^[-0-9A-Za-z_\.]+@[-0-9A-Za-z^\.]+\.[a-z]{2,6}$|i" title="Введите правильный email-адрес" name="mail" value=""  class="form-control" id="mail" placeholder="Ваш e-mail *">						

    </div>

<div class="form-group group-full">

     <input type="text" class="form-control" id="tema" name="tema" placeholder="Тема"/>

</div>   

<div class="form-group group-full">	

    <textarea name="msg" class="form-control" rows="3" placeholder="Повідомлення"></textarea>

</div>

    <input type="submit" name="send" value="Відправити" class="btn btn-default"/> 

<div class="clear"></div>

</form>

laba;

}

/*

function pagination($pages = '', $range = 1)

{ 

     $showitems = ($range * 2)+1; 

  

     global $paged;

     if(empty($paged)) $paged = 1;

  

     if($pages == '')

     {

         global $wp_query;

         $pages = $wp_query->max_num_pages;

         if(!$pages)

         {

             $pages = 1;

         }

     }  

  

     if(1 != $pages)

     {

         //echo "<div class=\"blog-pagenat\"><span>Page ".$paged." of ".$pages."</span>";

         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a  class='frist' href='".get_pagenum_link(1)."'>&laquo;&laquo;</a></li>";

         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Предыдущие</a></li>";

  

         for ($i=1; $i <= $pages; $i++)

         {

             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))

             {

                 echo ($paged == $i)? "<li><span>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";

             }

         }

  

         if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\">Следущие &rsaquo;</a></li>"; 

         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a class='last' href='".get_pagenum_link($pages)."'> &raquo; &raquo;</a></li>";

       //  echo "</div>";

     }

}*/
function callBack(){    
     $ip = $_SERVER['REMOTE_ADDR'];
    echo <<<contact
    <div class="calback_site" style="display:none">
    <div class="close_this">X</div>
    <form action="/wp-content/themes/teatr/form.php" method="POST">                 
                <input type="hidden" name="ip_address" value="$ip"/> 
                <input class="field_site" type="text" name="name_user" placeholder="Ім'я*" value=""/>
                <input class="field_site" type="text" name="phone_user" placeholder="Тел.*" value=""/>    
                <input class="button_site" type="submit" name="send_calback" class="button" value="Замовити сайт"/>
         </form>
    </div>
contact;
}
function subscribe_to_film($post_id,$category_id,$data_start){

    $time = time();

    $ip = $_SERVER['REMOTE_ADDR'];

    $post_id = $post_id;

    $category_id = $category_id;

    $data_start = $data_start;

    echo <<<film

     <div class="remind-block"> 

        <span>Нагадати про вихід фільма на екрани</span> 

        <form method="POST">

                <input type="hidden" name="post_id" value="$post_id"/> 

                <input type="hidden" name="category_id" value="$category_id"/>

                <input type="hidden" name="data_today" value="$time"/>  

                <input type="hidden" name="data_start_show" value="$data_start"/>        

                <input type="hidden" name="ip_address" value="$ip"/>                           

                <input type="text" name="email_user" placeholder="Введіть свій e-mail" value=""/>

                <input class="check-day" type="checkbox" name="from_two_days" value="1"/> за 2 дні

                <input class="check-day" type="checkbox" name="from_one_days" value="1"/> за 1 день  

                <input class="check-day" type="checkbox" name="from_in_days" value="1"/> в день початку показу

                <input type="submit" name="send_film" class="button" value="Відправити"/>

         </form>

      </div>

film;

}


?>