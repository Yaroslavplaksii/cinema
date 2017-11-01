</div>

<footer id="cinema">
    <div class="snowflake-two"></div>
    <div class="bot-bg"></div>

    <div class="container">

        <div class="vk-like"><!--<img src="/wp-content/themes/teatr/images/vk_like.png" alt=""/>--></div>

        <a href="http://cci.vn.ua/" target="_blank" class="logo-tpp">тпп</a><div class="vintpp"><a href="http://cci.vn.ua/" target="_blank">Вінницька<br /> торгово-промислова палата</a></div>

       <div class="copy">Всі права захищені. © Кінотеатр ім.М.Коцюбинського</div>
        
<!--
<div style="margin-top: 6px;" align="center"><a href="https://metrika.yandex.ru/stat/?id=34242400&amp;from=informer"
target="_blank" rel="nofollow"><img src="//informer.yandex.ru/informer/34242400/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:34242400,lang:'ru'});return false}catch(e){}"/></a></div>

<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter34242400 = new Ya.Metrika({id:34242400,
                    webvisor:true,
                    clickmap:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/34242400" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
-->
       <a href="http://itroom.ua" class="logo-room" target="_blank">ItRoom</a>

    </div>

</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/wp-content/themes/teatr/js/scripts.js"></script>
<script>
$(document).ready(function(){
    $('.vk_block').click(function(){
          var pos = $(this).css('right');                      
            if(pos == "0px"){
                $(this).animate({right:"-221px"});
            }else{
                 $(this).animate({right:"0px"});
            }
      });
});</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<?php wp_footer(); ?>
</body>
</html>