<?php 

/*

Template name:Future

*/

?>

<?php get_header();?>

<div class="container wrap-side">

        <div class="future">

            <div class="title">Незабаром</div>

            <div class="tab_content">

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

        <!--

                <div class="wrap-pagination">

                    <hr/>

                    <ul class="pagination">

                      <li><a href="#"><</a></li>

                       <li><a href="#">1</a></li>

                       <li><a href="#">2</a></li>

                       <li><a href="#">3</a></li>

                      <li><a href="#">></a></li>

                    </ul>

                </div>-->

            </div>

        </div>

        <div class="clear"></div>

    </div>

    <div class="hfooter"></div>

<?php get_footer();?>