function registrarEmail()
{
    var email = $("input[name=mailing]").val();

   
    var var_query = {
        "function": "registrarEmail",
        "vars_ajax":[email]
    };


    pasarelaAjax('GET', var_query, "registrarEmailHTML", "");

}


function registrarEmailHTML(response)
{

    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);

        if (respuesta["result"] == "success")
        {
             $("#msg_mailing").css("display","").children("span").addClass("success").html(respuesta["message"]);
             $("input[name=mailing]").val("");
            return true;
        }
        else if (respuesta["result"] == "error")
        {
             $("#msg_mailing").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }
        else if (respuesta["result"] == "bad")
        {
             $("#msg_mailing").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }
        else if (respuesta["result"] == "duplicate")
        {
             $("#msg_mailing").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }
        else if (respuesta["result"] == "empty")
        {
             $("#msg_mailing").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }

    }
    $("#msg_mailing").css("display","").children("span").addClass("error").html(respuesta["message"]);
    return false;
}

function registrarEmailCuerpo()
{
    var email = $("input[name=mailing_cuerpo]").val();

 
    var var_query = {
        "function": "registrarEmail",
        "vars_ajax":[email]
    };

    pasarelaAjax('GET', var_query, "registrarEmailCuerpoHTML", "");

}


function registrarEmailCuerpoHTML(response)
{

    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);

        if (respuesta["result"] == "success")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("success").html(respuesta["message"]);
             $("input[name=mailing_cuerpo]").val("");
            return true;
        }
        else if (respuesta["result"] == "error")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }
        else if (respuesta["result"] == "bad")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }
        else if (respuesta["result"] == "duplicate")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }
        else if (respuesta["result"] == "empty")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html(respuesta["message"]);
                return true;
        }

    }
    $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html(respuesta["message"]);
    return false;
}

function setExplorador()
{
    var var_query = {
          "function": "setExplorador"
    };

    pasarelaAjax('GET', var_query, "setExploradorHTML", "");
}

function setExploradorHTML(response)
{
    return true;
}



function showResponseHTML(response,id)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);
        if(respuesta.html)
        {
          //console.log(id);
          $(id).html(respuesta.html);
        }

    }

}
