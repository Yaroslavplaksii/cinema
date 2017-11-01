<?php get_header();?>

  <div class="container wrap-side">

        <div class="contact shchedule">

            <div class="title">Розклад</div>

            <div class="col-md-12 col-lg-12 col-sm12 col-xs-12"><span class="data_uniqu"><?php echo date("d.m.Y");?></span>

               <?php while ( have_posts() ) : the_post(); ?>                             

                            <?php the_content();?>

                        <?php endwhile; ?>   

            </div>

         </div>

          <div class="clear"></div>

  </div>   

   <div class="hfooter"></div>

<?php get_footer();?>