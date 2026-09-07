
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


var getGridParams = function(param) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

$.fn.GridAdmin = function(config)
{
    var parent = $(this);
    if(config.search) {
        var filtroUrlString = getGridParams('filters');
        var initPostData = { groupOp: "AND", rules: [] };
        var initFilters = false;

        if (filtroUrlString) {
            try {
                // Parseamos el string JSON para verificar que sea válido
                initPostData = JSON.parse(filtroUrlString);
                if (initPostData.rules && initPostData.rules.length > 0) {
                    initFilters = true;
                }
            } catch (e) {
                console.error("El JSON de la URL no es válido", e);
            }
        }
    }
    var page = getGridParams('page');
    var rows = getGridParams('rows');
    if(!page) {
        page = 1;
    }
    if(!rows) {
        rows = 12;
    }

    $(this).jqGrid({
        url: config.pathData+'?callback=?&qwery='+config.entity,
        mtype: "GET",
        datatype: "jsonp",
        colModel: config.colModel,
        page: page,
        height: 250,
        rowNum: rows,
        rowList:[12,24,50,100],
        scrollPopUp:true,
        viewrecords: true,
        emptyrecords: config.error,
        pager: config.gridPager,
        subGrid: config.subGrid,
        subGridRowExpanded: config.subGridRowExpanded,
        onSelectRow: function(id, status, event) {
            if(config.redirectOnSelectRow) {
                if (event && ($(event.target).is('img') || $(event.target).is('span') || $(event.target).is('a'))) {
                    return; 
                }
                var callback  = $(this).find('#' + id + ' td[aria-describedby$="_callback"]').text();
                callback = $.trim(callback);
                var datosFilaLocal = $(this).jqGrid('getLocalRow', id);
               
                window.location.href =  config.redirectPath+'?id=' + id + '&callback='+callback;
            }
        },
        rowattr: function (rowObject) {
            return {"style":"float:none;"};
        },
        gridComplete: function() {
            if(config.deleteFunction && config.deleteFunction.length > 0) {
                $(".btn_adm_eliminar").click(function(event){
                    event.preventDefault();
                    var nuevo_estado = ($(this).attr("href").replace("#","") == "activar" ? 1 : 0);
                    EliminarRegistro(config.deleteFunction,$(this).attr("data-id"),nuevo_estado)
                });
            }
           
           
            $(config.gridPager).find("label, input").css("display", "inline");

            //$("#miGrid").trigger("reloadGrid", [{ current: true }]);
        },
        loadui: 'disable', 
        beforeRequest: function() {
            var loader = $('<div class="preloaderfullpage_grid_'+config.gridPager.replace('#','')+'" style="'+window.loaderStyle.replace('absolute','relative')+'">&nbsp;</div>');
            $('.ui-jqgrid').prepend(loader);
        },
        loadComplete: function(data) {
            if($('.preloaderfullpage_grid_'+config.gridPager.replace('#','')))
            {
                $('.preloaderfullpage_grid_'+config.gridPager.replace('#','')).fadeOut('slow',function(){
                    $(this).remove();
                    $('.ui-jqgrid').css({'overflow':'visible'});
                });
            }
            if (initFilters && initPostData.rules) {
                
                $.each(initPostData.rules, function (index, regla) {
                    
                    var $inputFiltro = $("#gs_" + regla.field);
                    if ($inputFiltro.length > 0) {
                        
                        $inputFiltro.val(regla.data);
                    }
                });
                initFilters = false; 
                
            }
            $.fn.buttonDelete('a.btn_adm_eliminar_product_mp_switch')

            if(config.callbackFuncion && config.callbackFuncion.length > 0) {
                window[config.callbackFuncion].apply(this, []);
            }
            if(config.removeUrlTop != false) {
                var urlLimpia = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({ path: urlLimpia }, '', urlLimpia);
            }
         
        },
        loadError: function(xhr, status, error) {
            if($('#preloaderfullpage_grid_'+config.gridPager.replace('#','')))
            {
                $('#preloaderfullpage_grid_'+config.gridPager.replace('#','')).fadeOut('slow',function(){
                    $(this).remove();
                    $('.ui-jqgrid').css({'overflow':'visible'});
                    alert("Error al cargar los datos: " + error);
                });
            }
        },
        postData: {
            filters: initFilters ? JSON.stringify(initPostData) : "",
            _search: initFilters
        },
        width: ($(window).width() <= 767 ? 750 : (config.width ? config.width : parseInt($('body.admin .content').css('max-width')))),
        shrinkToFit: false, // Vital para habilitar el scroll horizontal real
        autowidth: false,
        
    });
    if(config.search) {
        $(this).jqGrid("filterToolbar", {
        stringResult: true,
        searchOnEnter: true,
        defaultSearch: "cn",
        afterSearch: function () {
            var postData = $(this).jqGrid("getGridParam", "postData");
            if (postData && postData.filters) {
                var filtersObj = JSON.parse(postData.filters);
                if (filtersObj.rules.length === 0) {
                    $(this).jqGrid("setGridParam", { search: false });
                }
            }
        } 
        });

        $(config.btnSearch).on("click", function (e) {
            e.preventDefault();
            var $grid = parent;
            var colModel = $grid.jqGrid('getGridParam', 'colModel');
            var postData = $grid.jqGrid('getGridParam', 'postData');
        
            var objetoFiltros = {
                groupOp: "AND",
                rules: []
            };
        
            $.each(colModel, function (index, col) {
                var nombreCol = col.name;
                var $inputFiltro = $("#gs_" + nombreCol); // Input físico del DOM

                if ($inputFiltro.length > 0) {
                    var valorActual = $.trim($inputFiltro.val());

                    if (valorActual !== "") {
                        objetoFiltros.rules.push({
                            field: nombreCol,
                            op: "cn",
                            data: valorActual
                        });
                    } else {
                        delete postData[nombreCol];
                    }
                }
            });

            if (objetoFiltros.rules.length > 0) {
                postData.filters = JSON.stringify(objetoFiltros);
                postData._search = true;
                $grid.jqGrid('setGridParam', { search: true });
            } else {
                postData.filters = "";
                postData._search = false;
                $grid.jqGrid('setGridParam', { search: false });
            }
            $grid.trigger("reloadGrid", [{ page: 1 }]);
        }); 
    }
}




$(window).load(function() {


    $('.contenedor_columnas div').textToIcon();
    if( $(".contenedor_columnas_info").length > 0 && window.admingrid)
    {
        $(".contenedor_columnas_info").htmlDataDum(window.admingrid,".no_hay_datos");
    }
    
    $("input.switch").change(function()
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
    $("input.switch").trigger('change');
});