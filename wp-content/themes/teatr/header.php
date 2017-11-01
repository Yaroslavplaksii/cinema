<!DOCTYPE html>

<html lang="">

<head><?php wp_head(); ?>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="description" content="">

<meta name="author" content="">

<title><?php if( is_front_page() ) {bloginfo('name');}else{wp_title();} ?></title>

<link rel="shortcut icon" href="http://cinema.vn.ua/wp-content/uploads/2016/10/favicon_cinema.png">

<link rel="stylesheet" href="<?php get_site_url(); ?>/wp-content/themes/teatr/css/bootstrap.min.css">

<link rel="stylesheet" href="<?php get_site_url(); ?>/wp-content/themes/teatr/css/style.css">


<!--[if IE]>

<script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>

<script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>

<![endif]-->

</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<div class="vk_block">
<div class="fb-page" data-href="https://www.facebook.com/KocubVN/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/KocubVN/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/KocubVN/">Кінотеатр ім.Коцюбинського</a></blockquote></div>

</div>


<div class="wrapper">  
    <?php if(is_front_page()){?>    
    <div class="banner-wrap">



    <?php echo do_shortcode('[wonderplugin_slider id="2"]'); ?> 



    <?php if (!dynamic_sidebar("Top Block")) :?> <?php endif;?>



        <div class="shadow-line"></div>



         <div id="sliderFrame">        



    </div>



    </div>



     <?php }?>



    <header  <?php if(!is_front_page()){ echo 'class="white"';}?>>

    <?php if(!is_front_page()){ echo '<div class="line-top"></div>';}?>



        <div class="container">



            <a href="/" class="logo"><img src="/wp-content/themes/teatr/images/logo.png" alt=""></a>



            <div class="top-phone"><span>(0432)</span> 52-59-78</div>



            <nav class="navbar">



              <?php $args = array(



                        	'menu'	=> 2



                        );



            wp_nav_menu( $args );?>   



            </nav>



            



        </div>



    </header>   