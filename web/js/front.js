window.loaderStyle = $('#loader').attr('style');

$(window).load(function() {



    if($('#preloaderfullpage'))
    {
	     $('#preloaderfullpage').fadeOut('slow',function(){
            $(this).remove();
            $('body').css({'overflow':'visible'});
        });

    }

    $.fn.imgLoadAlive();
    $(window).scroll(function () {
      $.fn.imgLoadAlive();
    });
    $(document).ajaxComplete(function () {
        $.fn.imgLoadAlive();
    });

    if(isMobile())
    {
        $(".tel1").attr('href',"tel:"+$(".tel1").eq(0).text());
    }

});

$(document).ready(function(){
    
    $("#up").hide();
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 200) {
                $('#up').fadeIn();
            } else {
                $('#up').fadeOut();
            }
        });
        $('#up a').click(function (e) {
            e.preventDefault();
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });


    $(".hide_render_debug").click(function(e){
        e.preventDefault();
        $(this).parent().next('.content_render_debug').slideToggle()

    });
    $(".close_render_debug").click(function(e){
        e.preventDefault();
        $(this).parent().parent().remove()

    });



    $("#debug .pestanas .pestana a").click(function(e){
        e.preventDefault();
        $("#content-detalle-debug div").hide();
        $($(this).attr("href")).show();
        $("#content-detalle-debug").show();
   });




   $("form[name=users],form[name=frmContacto]").find("[placeholder]").each(function(index){

        $(this).newplaceholder();
    });

    $("form[name=users],form[name=frmContacto]").find("[placeholder]").keyup(function(){  $(this).newplaceholder();});






});