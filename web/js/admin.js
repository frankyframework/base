
$.fn.htmlDataDum = function(data,fail)
{
    var data = JSON.parse(JSON.stringify(data));
    var html = $(this).html();
    var parent = $(this).parent();
    var id=''
    $(this).hide();
    $(fail).hide();

    if(data.length > 0)
    {
        $.each( data, function( key, _data ) {
            var fila = html;
            $.each( _data, function( _key, _value ) {
                if(_key == 'id')
                {
                    id= _value;
                }
              if(_value == ''){ _value = '&nbsp;';  }

               fila = fila.replace(RegExp("{{_data."+_key+"}}", "g"), _value);
            });

            fila = fila.replace(RegExp("{{_data.callback}}", "g"), encodeURIComponent($(location).attr('href')));

            parent.append("<div class='copia_fila'  id='cat_"+id+"'>"+fila+"<div>");

        });

        $(".btn_adm_eliminar").each(function( key, value) {

            if($(this).attr("href").replace("#","") == "activar")
            {

                $(this).html("<i class='icon  icon-c-encender'> </i>");
            }
            else if($(this).attr("href").replace("#","") == "desactivar")
            {
                $(this).html("<i class='icon  icon-r-eliminar'> </i>");
            }
            else
            {
                $(this).parent().append("&nbsp;");
                $(this).remove();
            }

        });

        $(document).trigger("load-grid-admin", [ "Custom", "Event" ]);


       // $(this).remove()
       // $(this).show();
    }
    else
    {
         $(fail).show();
    }

    return true;
}

$(document).ready(function(){
    $("._btn_collapse_panel").click(function(){
        $(this).toggleClass( "active" );
        $('._left_menu').toggleClass( "active" );
        $('._panel_content').toggleClass( "active" );

        if($('._left_menu').attr('class').search('active') > -1)
        {
            setCookie('menu_panel', 'active', 30)
        }
        else
        {
            setCookie('menu_panel', 'inactive', 30)
        }
    });
    if($("._btn_collapse_panel").length > 0)
    {
        if(getCookie('menu_panel') == 'active')
        {
            $("._btn_collapse_panel").click();
        }
    }


    if(!isMobile())
    {
      $(function() {
          $( "input[name=rango_inicial].filtros_panel").datepicker({
              defaultDate: "+1w",
              changeMonth: false,
              numberOfMonths: 3,
              dateFormat:"yy-mm-dd",
              maxDate: "+0D",
              onClose: function( selectedDate ) {
              $("input[name=rango_final].filtros_panel").datepicker( "option", "minDate", selectedDate );
              }
          });
          $( "input[name=rango_final].filtros_panel").datepicker({
              defaultDate: "+1w",
              changeMonth: false,
              numberOfMonths: 3,
              dateFormat:"yy-mm-dd",
              maxDate: "+0D",
              onClose: function( selectedDate ) {
              $( "input[name=rango_inicial].filtros_panel").datepicker( "option", "maxDate", selectedDate );
              }
          });
      });
    }

});


$(window).load(function() {


    $('.contenedor_columnas div').textToIcon();
    if( $(".contenedor_columnas_info").length > 0 && window.admingrid)
    {
        $(".contenedor_columnas_info").htmlDataDum(window.admingrid,".no_hay_datos");
    }
    
    $(".switch").change(function()
    {
            if($(this).is(":checked"))
            {
                $(this).addClass('switchOn');
            }
            else
            {
                $(this).removeClass('switchOn');
            }
    });
    $(".switch").trigger('change');
});