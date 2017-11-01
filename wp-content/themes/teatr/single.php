<?php get_header();?>

 <?php while ( have_posts() ) : the_post(); ?>

 <?php $country='';

 $year = '';?>

 <?php foreach ($posts as $post):  setup_postdata ($post); ?>

           <?php 
                 $linkvkino = get_post_meta($post->ID, 'linkvkino', true);
                $country = get_post_meta($post->ID, 'country', true);
                $year = get_post_meta($post->ID, 'year', true); 
                $ganr = get_post_meta($post->ID, 'ganr', true);
                $regiser = get_post_meta($post->ID, 'regiser', true);
                $roles = get_post_meta($post->ID, 'roles', true);
                $scenarii = get_post_meta($post->ID, 'scenarii', true);
                $baxs = get_post_meta($post->ID, 'baxs', true);
                $minutes = get_post_meta($post->ID, 'minutes', true);
                $startshow= get_post_meta($post->ID, 'startshow', true);
                $endshow= get_post_meta($post->ID, 'endshow', true);  
                $videorolik = get_post_meta($post->ID, 'videorolik', true);
                $rating = get_post_meta($post->ID, 'rating', true);                
                $showstart= get_post_meta($post->ID, 'showstart', true);
                $showend = get_post_meta($post->ID, 'showend', true);
                
                $date1 = get_post_meta($post->ID, 'date1', true);
                $select1 = get_post_meta($post->ID, 'select1', true);
                $time1= get_post_meta($post->ID, 'time1', true);
                $cast1 = get_post_meta($post->ID, 'cast1', true);//url24
                $url1 = get_post_meta($post->ID, 'url1', true);
                
                $date2 = get_post_meta($post->ID, 'date2', true);
                $select2 = get_post_meta($post->ID, 'select2', true);
                $time2= get_post_meta($post->ID, 'time2', true);
                $cast2 = get_post_meta($post->ID, 'cast2', true);
                $url2 = get_post_meta($post->ID, 'url2', true);

                $date3 = get_post_meta($post->ID, 'date3', true);
                $select3 = get_post_meta($post->ID, 'select3', true);
                $time3= get_post_meta($post->ID, 'time3', true);
                $cast3 = get_post_meta($post->ID, 'cast3', true);
                $url3 = get_post_meta($post->ID, 'url3', true);
                
                $date4 = get_post_meta($post->ID, 'date4', true);
                $select4 = get_post_meta($post->ID, 'select4', true);
                $time4= get_post_meta($post->ID, 'time4', true);
                $cast4 = get_post_meta($post->ID, 'cast4', true);
                $url4 = get_post_meta($post->ID, 'url4', true);

                $date5 = get_post_meta($post->ID, 'date5', true);
                $select5 = get_post_meta($post->ID, 'select5', true);
                $time5= get_post_meta($post->ID, 'time5', true);
                $cast5 = get_post_meta($post->ID, 'cast5', true);
                $url5 = get_post_meta($post->ID, 'url5', true);
                
                $date6 = get_post_meta($post->ID, 'date6', true);  
                $select6 = get_post_meta($post->ID, 'select6', true);
                $time6= get_post_meta($post->ID, 'time6', true);
                $cast6 = get_post_meta($post->ID, 'cast6', true);
                $url6 = get_post_meta($post->ID, 'url6', true);
                
                $date7 = get_post_meta($post->ID, 'date7', true);
                $select7 = get_post_meta($post->ID, 'select7', true);
                $time7= get_post_meta($post->ID, 'time7', true);
                $cast7 = get_post_meta($post->ID, 'cast7', true);
                $url7 = get_post_meta($post->ID, 'url7', true);
                
                $date8 = get_post_meta($post->ID, 'date8', true);
                $select8 = get_post_meta($post->ID, 'select8', true);
                $time8= get_post_meta($post->ID, 'time8', true);
                $cast8 = get_post_meta($post->ID, 'cast8', true);
                $url8 = get_post_meta($post->ID, 'url8', true);
                
                $date9 = get_post_meta($post->ID, 'date9', true);
                $select9 = get_post_meta($post->ID, 'select9', true);
                $time9= get_post_meta($post->ID, 'time9', true);
                $cast9 = get_post_meta($post->ID, 'cast9', true);
                $url9 = get_post_meta($post->ID, 'url9', true);
                
                $date10 = get_post_meta($post->ID, 'date10', true);
                $select10 = get_post_meta($post->ID, 'select10', true);
                $time10= get_post_meta($post->ID, 'time10', true);
                $cast10 = get_post_meta($post->ID, 'cast10', true);
                $url10 = get_post_meta($post->ID, 'url10', true);
                
                $date11 = get_post_meta($post->ID, 'date11', true); 
                $select11 = get_post_meta($post->ID, 'select11', true);
                $time11= get_post_meta($post->ID, 'time11', true);
                $cast11 = get_post_meta($post->ID, 'cast11', true);
                $url11 = get_post_meta($post->ID, 'url11', true);
                
                $date12 = get_post_meta($post->ID, 'date12', true);
                $select12 = get_post_meta($post->ID, 'select12', true);
                $time12= get_post_meta($post->ID, 'time12', true);
                $cast12 = get_post_meta($post->ID, 'cast12', true);
                $url12 = get_post_meta($post->ID, 'url12', true);
                
                $date13 = get_post_meta($post->ID, 'date13', true);
                $select13 = get_post_meta($post->ID, 'select13', true);
                $time13= get_post_meta($post->ID, 'time13', true);
                $cast13 = get_post_meta($post->ID, 'cast13', true);
                $url13 = get_post_meta($post->ID, 'url13', true);
                
                $date14 = get_post_meta($post->ID, 'date14', true);
                $select14 = get_post_meta($post->ID, 'select14', true);
                $time14= get_post_meta($post->ID, 'time14', true);
                $cast14 = get_post_meta($post->ID, 'cast14', true);
                $url14 = get_post_meta($post->ID, 'url14', true);
                
                $date15 = get_post_meta($post->ID, 'date15', true);
                $select15 = get_post_meta($post->ID, 'select15', true);
                $time15= get_post_meta($post->ID, 'time15', true);
                $cast15 = get_post_meta($post->ID, 'cast15', true);
                $url15 = get_post_meta($post->ID, 'url15', true);
                
                $date16 = get_post_meta($post->ID, 'date16', true);
                $select16 = get_post_meta($post->ID, 'select16', true);
                $time16= get_post_meta($post->ID, 'time16', true);
                $cast16 = get_post_meta($post->ID, 'cast16', true);
                $url16 = get_post_meta($post->ID, 'url16', true);
                
                $date17 = get_post_meta($post->ID, 'date17', true);
                $select17 = get_post_meta($post->ID, 'select17', true);
                $time17= get_post_meta($post->ID, 'time17', true);
                $cast17 = get_post_meta($post->ID, 'cast17', true);
                $url17 = get_post_meta($post->ID, 'url17', true);
                
                $date18 = get_post_meta($post->ID, 'date18', true);
                $select18 = get_post_meta($post->ID, 'select18', true);
                $time18= get_post_meta($post->ID, 'time18', true);
                $cast18 = get_post_meta($post->ID, 'cast18', true);
                $url18 = get_post_meta($post->ID, 'url18', true);
                
                $date19 = get_post_meta($post->ID, 'date19', true);
                $select19 = get_post_meta($post->ID, 'select19', true);
                $time19= get_post_meta($post->ID, 'time19', true);
                $cast19 = get_post_meta($post->ID, 'cast19', true);
                $url19 = get_post_meta($post->ID, 'url19', true);
                
                $date20 = get_post_meta($post->ID, 'date20', true);
                $select20 = get_post_meta($post->ID, 'select20', true);
                $time20= get_post_meta($post->ID, 'time20', true);
                $cast20 = get_post_meta($post->ID, 'cast20', true);
                $url20 = get_post_meta($post->ID, 'url20', true);
                
                $date21 = get_post_meta($post->ID, 'date21', true);
                $select21 = get_post_meta($post->ID, 'select21', true);
                $time21= get_post_meta($post->ID, 'time21', true);
                $cast21 = get_post_meta($post->ID, 'cast21', true);
                $url21 = get_post_meta($post->ID, 'url21', true);
                
                $date22 = get_post_meta($post->ID, 'date22', true);
                $select22 = get_post_meta($post->ID, 'select22', true);
                $time22= get_post_meta($post->ID, 'time22', true);
                $cast22 = get_post_meta($post->ID, 'cast22', true);
                $url22 = get_post_meta($post->ID, 'url22', true);
                
                $date23 = get_post_meta($post->ID, 'date23', true);
                $select23 = get_post_meta($post->ID, 'select23', true);
                $time23= get_post_meta($post->ID, 'time23', true);
                $cast23 = get_post_meta($post->ID, 'cast23', true);
                $url23 = get_post_meta($post->ID, 'url23', true);
                
                $date24 = get_post_meta($post->ID, 'date24', true);
                $select24 = get_post_meta($post->ID, 'select24', true);
                $time24= get_post_meta($post->ID, 'time24', true);
                $cast24 = get_post_meta($post->ID, 'cast24', true);
                $url24 = get_post_meta($post->ID, 'url24', true);

                

  endforeach;
$category = get_the_category();
           ?>

<div class="container wrap-side">

        <div class="film-info">

            <div class="info-left">

                <div class="film-img">

                   <?php echo get_the_post_thumbnail();?>

                </div>

                <div class="rating-block">

                    <ul>

                    <?php for($i=1;$i<=10;$i++):?>

                        <li><a href="#" <?php echo ($i<=(int)$rating)?'class="active"':false;?>><?php echo $i;?></a></li>

                    <?php endfor;?>                        

                    </ul>

                    <span><?php echo $rating;?></span>

                </div>

            </div>

            <div class="info-right">
            <?php if(!empty($linkvkino)){?><a class="vkino" href="<?php echo $linkvkino;?>" target="_blank"><img src="/wp-content/themes/teatr/images/button-120x120.jpg" alt="вкіно"/></a><?php }?>

                <div class="name"><?php the_title();?></div>

                <?php if(!empty($country)){?> 

                    <div class="country"><?php echo $country;?>, <?php echo $year;?></div>

                <?php }?>

                <div class="description">

                <?php if(!empty($ganr)){?>

                    <div class="cap">Жанр:</div>

                    <div class="desc"><?php echo $ganr;?></div>

                <?php }?>

                 <?php if(!empty($regiser)){?>

                    <div class="cap">Режисeр:</div>

                    <div class="desc"><?php echo $regiser;?></div>

                 <?php }?>

                 <?php if(!empty($roles)){?>

                    <div class="cap">У ролях:</div>

                    <div class="desc"><?php echo $roles;?></div>

                 <?php }?>

                  <?php if(!empty($scenarii)){?> 

                    <div class="cap">Сценарій:</div>

                    <div class="desc"><?php echo $scenarii;?></div>

                  <?php }?>

                  <?php if(!empty($baxs)){?> 

                    <div class="cap">Бюджет:</div>

                    <div class="desc">$<?php echo $baxs;?></div>

                  <?php }?>

                   <?php if(!empty($minutes)){?> 

                    <div class="cap">Тривалість:</div>

                    <div class="desc"><?php echo $minutes;?> хв.</div>                    

                <?php }?>

              <?php if($category[0]->cat_ID==6){?> 
                    <?php if(!empty($startshow)){?> 
                    <?php $s = explode("-",$startshow);?>                
                        <div class="cap">Прем'єра:</div>
                        <div class="desc" style="color: red;"><?php echo $s[2].".".$s[1].".".$s[0];?> р.</div>                
                    <?php }?>
                <?php }?>
                <?php if(!empty($startshow) && !empty($endshow)){?> 
                    <?php $s = explode("-",$startshow);?>   
                    <?php $en = explode("-",$endshow);?>               
                        <div class="cap">Прокат:</div>
                        <div class="desc">з <?php echo $s[2].".".$s[1].".".$s[0];?> р. по <?php echo $en[2].".".$en[1].".".$en[0];?> р.</div>                
                    <?php }?>
                </div>

               

               <?php 

               if($category[0]->cat_ID==6){?> 

                <div class="nagaday"> 

                <?php //subscribe_to_film($post->ID,$category[0]->cat_ID,$showstart);?>

               <!--  <div class="remind-block">   

                             

                   

                        <span>Нагадати про вихід фільма на екрани</span>                                        

                        <input type="text" placeholder="Введіть свій e-mail"/>

                        <a href="#" class="button">Відправити</a>

                    

                </div>-->

                </div>

               <?php }elseif($category[0]->cat_ID==5){?>

                <div class="date-price">

              

                    <?php if(!empty($showstart)):?>

                    <?php $ds = explode("-",$showstart);?>

                    <?php $de = explode("-",$showend);?>

                    <div class="grafik_seansiv">Графік сеансів на поточний тиждень з 

                        <span class="date"><?php echo $ds[2].".".$ds[1].".".$ds[0];?></span> 

                        по 

                        <span class="date"><?php echo $de[2].".".$de[1].".".$de[0];?></span>

                    </div>

                   
                <div class="clear"></div> 

                     <div class="wrap-item">
                    <?php if(($select1 == "green" &&!empty($time1)) || 
                                ($select2 == "green" && !empty($time2)) || 
                                ($select3 == "green" && !empty($time3)) || 
                                ($select4 == "green" && !empty($time4)) ||
                                ( $select5 == "green" && !empty($time5))):?>
                    <div class="wrap-green">
                     <div class="one_block"><div class="green_zal"></div> - зелений зал</div> 
                    <?php if(!empty($select1) && $select1 == "green" && !empty($time1) && !empty($cast1)){?> 
                        <div class="item <?php echo $select1;?>">
                            <div class="item-time"><?php echo $time1;?></div>
                            <div class="item-price"><?php echo $cast1;?> грн.</div>
                        </div>
                    <?php }?>
                        <?php if(!empty($select2) && $select2 == "green" && !empty($time2) && !empty($cast2)){?> 
                        <div class="item <?php echo $select2;?>">
                            <div class="item-time"><?php echo $time2;?></div>
                            <div class="item-price"><?php echo $cast2;?> грн.</div>
                        </div>
                    <?php }?>
                         <?php if(!empty($select3) && $select3 == "green" && !empty($time3) && !empty($cast3)){?> 
                        <div class="item <?php echo $select3;?>">
                            <div class="item-time"><?php echo $time3;?></div>
                            <div class="item-price"><?php echo $cast3;?> грн.</div>
                        </div>
                    <?php }?>
                         <?php if(!empty($select4) && $select4 == "green" && !empty($time4) && !empty($cast4)){?> 
                        <div class="item <?php echo $select4;?>">
                            <div class="item-time"><?php echo $time4;?></div>
                            <div class="item-price"><?php echo $cast4;?> грн.</div>
                        </div>
                    <?php }?>
                         <?php if(!empty($select5) && $select5 == "green" && !empty($time5) && !empty($cast5)){?> 
                        <div class="item <?php echo $select5;?>">
                            <div class="item-time"><?php echo $time5;?></div>
                            <div class="item-price"><?php echo $cast5;?> грн.</div>
                        </div>
                    <?php }?> 
                    </div>
                    <?php endif;?>
                     <?php if(($select1 == "red" &&!empty($time1)) || 
                                ($select2 == "red" && !empty($time2)) || 
                                ($select3 == "red" && !empty($time3)) || 
                                ($select4 == "red" && !empty($time4)) ||
                                ( $select5 == "red" && !empty($time5))):?>
                    <div class="wrap-red">
                     <div class="two_block"><div class="red_zal"></div> - червоний зал</div> 
                    <?php if(!empty($select1) && $select1 == "red" && !empty($time1) && !empty($cast1)){?> 
                        <div class="item <?php echo $select1;?>">
                            <div class="item-time"><?php echo $time1;?></div>
                            <div class="item-price"><?php echo $cast1;?> грн.</div>
                        </div>
                    <?php }?>
                        <?php if(!empty($select2) && $select2 == "red" && !empty($time2) && !empty($cast2)){?> 
                        <div class="item <?php echo $select2;?>">
                            <div class="item-time"><?php echo $time2;?></div>
                            <div class="item-price"><?php echo $cast2;?> грн.</div>
                        </div>
                    <?php }?>
                         <?php if(!empty($select3) && $select3 == "red" && !empty($time3) && !empty($cast3)){?> 
                        <div class="item <?php echo $select3;?>">
                            <div class="item-time"><?php echo $time3;?></div>
                            <div class="item-price"><?php echo $cast3;?> грн.</div>
                        </div>
                    <?php }?>
                         <?php if(!empty($select4) && $select4 == "red" && !empty($time4) && !empty($cast4)){?> 
                        <div class="item <?php echo $select4;?>">
                            <div class="item-time"><?php echo $time4;?></div>
                            <div class="item-price"><?php echo $cast4;?> грн.</div>
                        </div>
                    <?php }?>
                         <?php if(!empty($select5) && $select5 == "red" && !empty($time5) && !empty($cast5)){?> 
                        <div class="item <?php echo $select5;?>">
                            <div class="item-time"><?php echo $time5;?></div>
                            <div class="item-price"><?php echo $cast5;?> грн.</div>
                        </div>
                    <?php }?> 
                    </div>
                    <?php endif;?>
                    
                    </div>
                    <?php endif;?>

                    

                </div>

                <?php }else{?>

                <div class="end_show">Завершено показ</div>

                <?php }?>

                <div class="clear"></div>

            </div>
           <?php if($category[0]->cat_ID==555555){?> 
<div class="vsi_na_kino"><span>Забронювати</span></div>

<div class="calendar_bronyi" style="display: none;"><span style="color: red;font-weight:bold;">Бронювання працює в тестовому режимі</span><br />
<?php for($i=1;$i<=25;$i++){
    $date = 'date'.$i;
    $select = 'select'.$i;
    $time = 'time'.$i;
    $cast = 'cast'.$i;
    $url = 'url'.$i;    
    if(!$$date){
        continue;
    }else{?>
          <?php if(!empty($$url) && !empty($$time) && !empty($$cast)){?> 
              <?php $date_param_bron = explode("-",$$date);
                    $time_param_bron = explode(":",$$time);
              ?>              
              <?php if(($date_param_bron[2]>=date("d")) || ($date_param_bron[2]==date("d") && time("h")-$time_param_bron[0]>=3)){ //)?>
                <div class="wrap-<?php echo $$select;?>"> 
                        <div class="item <?php echo $$select;?>">
                            <div class="item-date"><a href="<?php echo $$url;?>?date_b=<?php echo $date_param_bron[2].".".$date_param_bron[1].".".$date_param_bron[0]?>&time_b=<?php echo $time_param_bron[0].":".$time_param_bron[1];?>"><?php echo $date_param_bron[2].".".$date_param_bron[1].".".$date_param_bron[0];?></a></div>
                            <div class="item-time"><a href="<?php echo $$url;?>?date_b=<?php echo $date_param_bron[2].".".$date_param_bron[1].".".$date_param_bron[0]?>&time_b=<?php echo $time_param_bron[0].":".$time_param_bron[1];?>"><?php echo $$time;?></a></div>
                            <div class="item-price"><a href="<?php echo $$url;?>?date_b=<?php echo $date_param_bron[2].".".$date_param_bron[1].".".$date_param_bron[0]?>&time_b=<?php echo $time_param_bron[0].":".$time_param_bron[1];?>"><?php echo $$cast;?> грн.</a></div>
                        </div>                   
                </div>
             <?php }?>    
        <?php }?>
<?php }
}?>
</div>

<?php }?>
            <div class="about-film">

                <div class="caption">Про фільм</div>

                <div class="wrap">

              <?php the_content();?>  

                </div>

            </div>

        </div>

        <div class="clear"></div>

    </div>

    <div class="film-slide">

        <div class="main-img">

            <?php echo $videorolik;?>

        </div>        

    </div>

    <div class="clear"></div>

    <div class="hfooter"></div>

          <?php endwhile; ?> 

<?php get_footer();?>