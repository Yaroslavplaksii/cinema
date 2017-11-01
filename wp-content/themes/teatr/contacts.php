<?php 

/*

Template name:Contacts

*/

?>

<?php session_start();?>

<?php get_header();?>

    <div class="container wrap-side">

        <div class="contact">

            <div class="title">Контакти</div>

            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                <div class="address-block">
                    <div class="capitan_amerika"><a href="http://cci.vn.ua" target="_blank">Вінницька торгово-промислова палата</a></div>
                    <div class="cap">Наша адреса:</div>

                    <div class="adr-info">м.Вінниця, вул.Соборна, 68</div>

                    <div class="cap">Тел. автовідповідача:</div>

                    <div class="adr-info">(0432) 52-59-78</div>

                    <div class="cap">Тел. бронювання:</div>

                    <div class="adr-info">(0432) 52-59-76</div>

                </div>

                <?php contact_form()?>

            </div>

            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 wrap-map">

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2605.2604798066286!2d28.464118215687776!3d49.23355047932608!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x472d5b7ca70a13f3%3A0x24a03ba8ed455c4!2z0JrQuNC90L7RgtC10LDRgtGAINC40LwuINCcLiDQmtC-0YbRjtCx0LjQvdGB0LrQvtCz0L4!5e0!3m2!1sru!2sua!4v1449232223873" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

            </div>

            <div class="reservations-block">

                <div class="cap col-md-3 col-lg-3 col-sm-12 col-xs-12">Правила бронювання</div>

                <div class="block col-md-3 col-lg-3 col-sm-6 col-xs-6">

                    <div class="day">Понеділок — П’ятниця</div>

                    <div class="time">з 9:30 до 15:00</div>

                    <span>(бронювання день у день)</span>

                </div>

                <div class="block col-md-3 col-lg-3 col-sm-6 col-xs-6">

                    <div class="day">П’ятниця</div>

                    <div class="time">з 16:00 до 20:00</div>

                    <span>(бронювання на суботу та неділю) </span>

                </div>

                <div class="cap col-md-3 col-lg-3 col-sm-12 col-xs-12">У вихідні дні<br/>бронювання немає</div>

            </div>

            <div class="about">

                <div class="cap">Про нас</div>

                <div class="wrap">

                    <?php while ( have_posts() ) : the_post(); ?>                             

                            <?php the_content();?>

                        <?php endwhile; ?>    

                </div>                

            </div>

        </div>

        <div class="clear"></div>

    </div>

    <div class="hfooter"></div>

    <?php if(isset($_SESSION['respon'])){

echo <<<lab

            <div id='myfond_fon'></div>

           

            <div id='box_1' class='mymagicoverbox_fenetre  esheclass2' style='left:-225px; width:450px;display:block'>

                    <a class='close_form'>X</a>

                    <span class='zagolovok'>Форма зворотнього зв'язку!</span>

                    <div class='mymagicoverbox_fenetreinterieur' style='height:150px;'>                         

                            <table width='350' height='150' align='center'>

                                 <tr>

                                     <td class='warning_table' width='150' align='center' valign='middle'>                                        

                                         <div align='center' class='warning_font_big'><span class='wau'>Дякуємо!</span></div>

                                         <div align='center' class='warning_font' align='left'><span class='wau'>Ваше повідомлення відправлено!</span></div>

                                     </td>

                                 </tr>

                             </table>

                    </div> 

            </div>

lab;

            unset($_SESSION['respon']);

        }elseif($_SESSION['errorka']){

             echo "

        <div id='myfond_fon'></div>

            <div id='box_1' class='mymagicoverbox_fenetre esheclass2' style='left:-225px; width:450px;display:block'>

                    <a class='close_form'>X</a>

                    <span class='zagolovok'>Форма обратной связи!</span>

                    <div class='mymagicoverbox_fenetreinterieur' style='height:150px;'>       

         <table width='350' height='150' align='center'>

             <tr>

                 <td class='warning_table' width='150' align='center' valign='middle'>             

                    

                     <div align='center' class='warning_font_big'><span class='otblya'>Помилка!!!</span></div>

                     <div align='center' class='warning_font' align='left'><span class='otblya'>Ваше повідомлення не відправлено! Спробуйте ще раз!</span></div>             

                 </td>

             </tr>

         </table>

          </div> 

            </div>";

             unset($_SESSION['errorka']);

        }elseif(isset($_SESSION['facking_send'])){

             echo "

        <div id='myfond_fon'></div>

            <div id='box_1' class='mymagicoverbox_fenetre esheclass2' style='left:-225px; width:450px;display:block'>

                    <a class='close_form'>X</a>

                    <span class='zagolovok'>Форма обратной связи!</span>

                    <div class='mymagicoverbox_fenetreinterieur' style='height:150px;'>       

         <table width='350' height='150' align='center'>

             <tr>

                 <td class='warning_table' width='150' align='center' valign='middle'>            

                    

                     <div align='center' class='warning_font_big'><span class='otblya'>Помилка!!!</span></div>

                     <div align='center' class='warning_font' align='left'><span class='otblya'>Ваше повідомлення не відправлено! Заповніть всі поля!</span></div>             

                 </td>

             </tr>

         </table>

          </div> 

            </div>";

             unset($_SESSION['facking_send']);

        }?>

<?php get_footer();?>