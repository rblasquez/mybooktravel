"use strict";var Imagenes=function(){var e=function(){return{start:function(){$(document).ready(function(){setInterval(function(){$(".preview_image_container .delete").each(function(e,a){var i=$(a).attr("onclick"),n="Imagenes.edit.eliminar($(this).parents('.preview_image_container').find('.preview_image').attr('id'))";i!=n&&($(a).attr("onclick",""),$(a).attr("onclick",n))})},100),Imagine.previewer.start({containerSelector:"#contenedor_imagenes_galeria",maxFiles:20,maxFilesOnSelect:5,onSelect:function(e){console.log("seleccionaron archivos"),abrir_modal_espera()},onFinishSelect:function(e){console.log("previsualizó todas"),Imagine.compressor.start({containerSelector:"#contenedor_imagenes_galeria",compressionLevel:.6,maxWidth:1920,maxHeight:1080,onFinishEveryImage:function(e){},onfinishAllImages:function(e){console.log("comprimió todas"),Imagine.sender.send({containerSelector:"#contenedor_imagenes_galeria",url:$(".agregarImagen").attr("href"),csrfToken:$("[name=_token]").val(),onFinishEveryImage:function(e,a){console.log("imgen enviada"),1==JSON.parse(e.responseText).success?($(a).attr("id",JSON.parse(e.responseText).id_imagen),Imagenes.edit.startSelectorPrimaria(),Imagenes.edit.startRotators(),Imagenes.edit.verificarCantidades()):($(a).parents(".preview_image_container").remove(),swal.close())},onfinishAllImages:function(){console.log("envió todas"),swal.close()}})}})}});var e=JSON.parse($("#initial_previews").val());Imagine.previewer.setInitialPreviews({containerSelector:"#contenedor_imagenes_galeria",initialPreviews:e}),Imagenes.edit.startSelectorPrimaria(),Imagenes.edit.startRotators(),Imagenes.edit.verificarCantidades();var a=$("#id_imagen_primaria").val();if(0!=a){var i=$(".preview_image#"+a).parents(".preview_image_container");if(i.length>0){var n=$(i).find(".main_image_input");n.length>0&&(n[0].checked=!0)}}})},eliminar:function(e){var a=$(".eliminarImagen").attr("href"),i=$("input[name=_token]").val();abrir_modal_espera(),$.ajax(a,{type:"post",headers:{"X-CSRF-TOKEN":i},data:{id_imagen:e},dataType:"json",success:function(a){$(".preview_image[id="+e+"]").parents(".preview_image_container").remove(),swal.close(),Imagenes.edit.verificarCantidades()},error:function(e,a,i){swal.close()}})},startSelectorPrimaria:function(){$(".make_main_image").on("click",function(){if(""==$(this).attr("for")){var e=Date.now(),a=$(this).parents(".preview_image_header");$(a).find(".main_image_input").attr("id",e),$(this).attr("for",e)}var i=$(this).parents(".preview_image_container").find(".preview_image").attr("id"),n=$(".asignarImagenPrimaria").attr("href"),t=$("input[name=_token]").val();abrir_modal_espera(),$.ajax(n,{type:"post",headers:{"X-CSRF-TOKEN":t},data:{id_imagen:i},dataType:"json",success:function(e){swal.close()},error:function(e,a,i){swal.close()}})})},startRotators:function(){$(".rotator").unbind("click"),$(".rotator").on("click",function(){var e="";e=$(this).hasClass("clockwise")?"derecha":"izquierda";var a=$(this).parents(".preview_image_container"),i=$(a).find(".preview_image"),n=$(i).attr("id"),t=$(".rotarImagen").attr("href"),r=$("input[name=_token]").val();abrir_modal_espera(),$.ajax(t,{type:"post",headers:{"X-CSRF-TOKEN":r},data:{id_imagen:n,sentido:e},dataType:"json",success:function(e){$(i).attr("id",e.imagen.id),$(i).attr("src",e.imagen.url),swal.close(),Imagenes.edit.eliminar(n)},error:function(e,a,i){swal.close()}})})},verificarCantidades:function(){var e=$(".preview_image_container").length;$("#imagenes_guardadas").val(e),e>=$("#cantidad_maxima_imagenes").val()?$(".add_button_template").hide():$(".add_button_template").show()}}}();return{edit:e}}();