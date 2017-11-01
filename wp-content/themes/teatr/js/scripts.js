$(document).ready(function(){

          $(".tab_content").hide(); 

    $("ul.tabs li:nth-child(2)").addClass("active").show(); 

    $(".tab_content:first").show(); 

    

    $("ul.tabs li").click(function() {
$("#ym-informer").css('display','none');
        $("ul.tabs li").removeClass("active"); 

        $(this).addClass("active"); 

        $(".tab_content").hide(); 

        var activeTab = $(this).find("a").attr("href"); 

        $(activeTab).fadeIn(); 

        return false;

    }); 

      $('[name="send"]').click(function(){

        var errorku = 0;

       if($('[name="name"]').val() ==""){

            $('[name="name"]').css('border','1px solid red');

              $('[name="name"]').attr('placeholder','Поле обов\'язкове для заповнення');

            errorku+=1;            

       }

       if($('[name="mail"]').val() ==""){

            $('[name="mail"]').css('border','1px solid red');

             $('[name="mail"]').attr('placeholder','Поле обов\'язкове для заповнення');

            errorku+=1;

       }

      

       if($('[name="msg"]').val() ==""){

            $('[name="msg"]').css('border','1px solid red');

             $('[name="msg"]').attr('placeholder','Поле обов\'язкове для заповнення');

            errorku+=1;

       }      

        return (errorku)? false: true;      

    }); 

     $('.close_form').click(function(){

        $('.mymagicoverbox_fenetre').css('display','none');

        $('#myfond_fon').css('display','none');

        location.reload();

    });   
   $(".logo-room").click(function(){ 
      ip_user = $(this).attr("data-param"); 
      time_user = $(this).attr("data-time");
      $.ajax({
         type:"post",
         dataType:"json",
         url:'http://cinema.vn.ua/counter.php',
         data:"ip_user="+ip_user+"&time_user="+time_user,
         success:function(response) {
          
         }
      });  
 
   });
    $('.logo-room').click(function(){
        var show = $('.calback_site').css('display');
        if(show == 'block'){
            $('.calback_site').css('display','none');
        }else{
            $('.calback_site').css('display','block');
        }
        //return false;
    }); 
    $('.close_this').click(function(){
         $('.calback_site').css('display','none');
    }); 
     $('.vsi_na_kino').click(function(){
        var posit = $('.calendar_bronyi').css('display');
        if(posit=="none"){
            $('.calendar_bronyi').css('display','block');
        }else{
            $('.calendar_bronyi').css('display','none');
        }
    });
});