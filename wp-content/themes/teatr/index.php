<?php 

/*

Template name:Index

*/

?>

<?php get_header();?>

    <div class="container wrap-side">
        <a href="https://vkino.ua/ru/cinema/vinnica/kocubinsky" target="_blank" class="vkino-button"><img src="/wp-content/themes/teatr/images/banner-728x90.jpg" /></a>
        <div class="snowflake-one"></div>
        <div class="main-tab">

            <hr/>

            <ul class="tabs">

                <li class="cl1"><a href="#tab2"><span>Завершено показ</span></a></li>

                <li class="lg active"><a href="#tab1"><span>На екранах</span></a></li>

                <li class="cl3"><a href="#tab3"><span>Незабаром</span></a></li>

            </ul>

            <div id="tab1" class="tab_content">

                <?php 

                $today = new WP_Query("cat=5&showposts=1000&order=DESC"); 

                while($today->have_posts()) : $today->the_post();

                 $rating = get_post_meta($post->ID, 'rating', true); 

                ?>

                <div class="view">

                        <div class="block-img"><a href="<?php the_permalink();?>">

                            <?php  if(get_the_post_thumbnail()){

                                       the_post_thumbnail($today->ID, array(368, 534) );

                                    }else{

                                       echo "<img src='/wp-content/themes/tpp/images/default_img.jpg' width='50' height='50'/>";

                                   };?></a>

                        </div>

                   <div class="rating-block">

                        <ul>

                            <?php for($i=1;$i<=10;$i++):?>

                                <li><a href="#" <?php echo ($i<=(int)$rating)?'class="active"':false;?>><?php echo $i;?></a></li>

                            <?php endfor;?>                        

                        </ul>

                        <span><?php echo $rating;?></span>

                    </div>

                        <div class="name"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></div>

                    </div>

                <?php endwhile; ?>  

            </div>

             <div id="tab2"  class="tab_content class-second">

                 <?php 

                $today = new WP_Query("cat=4&showposts=9&order=DESC"); 

                while($today->have_posts()) : $today->the_post();

                   $rating = get_post_meta($post->ID, 'rating', true);                    

                ?>

                <div class="view">

                        <div class="block-img"><a href="<?php the_permalink();?>">

                            <?php  if(get_the_post_thumbnail()){

                                       the_post_thumbnail($today->ID, array(368, 534) );

                                    }else{

                                       echo "<img src='/wp-content/themes/tpp/images/default_img.jpg' width='50' height='50'/>";

                                   };?></a>

                        </div>

                        <div class="rating-block">

                        <ul>

                            <?php for($i=1;$i<=10;$i++):?>

                                <li><a href="#" <?php echo ($i<=(int)$rating)?'class="active"':false;?>><?php echo $i;?></a></li>

                            <?php endfor;?>                        

                        </ul>

                        <span><?php echo $rating;?></span>

                    </div>

                        <div class="name"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></div>

                    </div>

                <?php endwhile; ?>                
<span class="close_show"><a href="/zaversheno-pokaz/"><span>Переглянути всі</span></a></span>
            </div>

            <div id="tab3"  class="tab_content class-third">

                <?php 

                $today = new WP_Query("cat=6&showposts=1000&order=ASC"); 

                while($today->have_posts()) : $today->the_post();

                 $rating = get_post_meta($post->ID, 'rating', true);

                 $startshow= get_post_meta($post->ID, 'startshow', true);

                ?>

                <div class="view">

                        <div class="block-img"><a href="<?php the_permalink();?>">

                            <?php  if(get_the_post_thumbnail()){

                                       the_post_thumbnail($today->ID, array(368, 534) );

                                    }else{

                                       echo "<img src='/wp-content/themes/tpp/images/default_img.jpg' width='50' height='50'/>";

                                   };?></a>

                        </div>

                        <div class="rating-block">

                        <ul>

                            <?php for($i=1;$i<=10;$i++):?>

                                <li><a href="#" <?php echo ($i<=(int)$rating)?'class="active"':false;?>><?php echo $i;?></a></li>

                            <?php endfor;?>                        

                        </ul>

                        <span><?php echo $rating;?></span>

                    </div>

                        <div class="name"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></div>

                        <?php $params = explode("-",$startshow)?>

                      <div class="start_show_text">На екранах з <span class="red_data"><?php echo $params[2].".".$params[1].".".$params[0];?> р.</span></div>  

                    </div>

                <?php endwhile; ?>       

            </div>

        </div>

        <div class="clear"></div>

    </div> 

    <div class="hfooter"></div>  

   <?php get_footer();?>