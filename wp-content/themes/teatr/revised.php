<?php 

/*

Template name:Переглянуті

*/

?>

<?php session_start();?>

<?php get_header();?>

    <div class="container wrap-side">

        <div class="contact">

            <div class="title">Завершено показ</div>

    
             <div class="tab_content class-second">

                 <?php 
               

                $today = new WP_Query("cat=4"); 

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


        </div>

        <div class="clear"></div>

    </div>

    <div class="hfooter"></div>


<?php get_footer();?>