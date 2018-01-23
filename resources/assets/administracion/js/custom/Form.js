var Form = (function () {

	//private methods
	var start = (function () {
		return {
			asignarUniqueId:function(form)
			{
				var unique_id = $(form).attr("unique_id");
				if(typeof unique_id == 'undefined' || unique_id == "")
				{
					unique_id = Date.now();
					$(form).attr("unique_id",unique_id);
				}

				return {unique_id:unique_id,form_selector:"form[unique_id="+unique_id+"]"};

			},
			sender:function()
			{

				$("form").on("submit", function(event){
					// alert("hizo el submit");
					event.preventDefault();
					var form = $(this);

					var unique_id = (Form.start.asignarUniqueId(form)).unique_id;
					var form_selector = (Form.start.asignarUniqueId(form)).form_selector;

					//console.log(Form.start.asignarUniqueId(form));
					//console.log(unique_id);
					//console.log(form_selector);

					var data = form.serialize();

					var prevenir_envio = $(form).attr("prevenir_envio");
					var modal_confirm = $(form).attr("modal_confirm") ? $(form).attr("modal_confirm") : 0 ;

					if(prevenir_envio != 1)
					{
						$(form).attr("prevenir_envio","1");
						// console.log (data);

						Modal.wait({});

						var callback = form.attr("callback");

						$.ajax({
							type: form.attr("method"),
							url: form.attr("action"),
							data: data,
							success: function(result,status)
							{

								setTimeout(function(){ $(form).attr("prevenir_envio","0"); }, 3000);

								if(status == 'success')
								{
									/*
									//console.log(1);
									//success_callback aplica cuando se guarda o actualiza un modelo
									var success_callback = $( form).attr('success_callback') ;
									if( success_callback != null && success_callback != "")
									{
										console.log("se debe ejecutar el callback "+success_callback);
										eval("var successCallback = "+success_callback+"");
										successCallback(result.modelo);
									}
									*/

									var ruta_index = $(form).attr('ruta_index');
									var redirect = "";

									//alert(document.location);
									if( ruta_index != "")
									{
										if($(form).attr('redirect_target') == "index" )
										{
											redirect = ruta_index;
										}

										if($(form).attr('redirect_target') == "edit" )
										{
											redirect = ruta_index+"/"+result.modelo.id+"/edit"+document.location.search;
										}
										if(redirect != "")redirect = "document.location ='"+redirect+"'";

									}

									//console.log("redirect");
									//console.log(redirect);

									if(modal_confirm == 1)
									{
										Modal.success({
											callback:callback+";"+redirect,
											result:result
										});
									}
									else
									{
										//swal.close();
										Modal.close();
										eval(callback);
										eval(redirect);
									}

								}

							},
							error: function(result,status)
							{

								if(status == 'error')
								{
									if(result.status = 422)
									{
										//console.log(form_selector);
										Form.reset.validator(form_selector);

										//var errores_originales = result.responseJSON.errors;//L 5.5
										var errores_originales = result.responseJSON;//L 5.4
										//console.log(errores_originales);
										var errores_formateados = Form.format.request(errores_originales);
										var validator = $(form).validate();
										validator.showErrors(errores_formateados);

										var html = "<p>Verifique los siguientes datos</p>:<ul>";
										$.each(errores_formateados, function (index, item) {

											var text = index.split("_").join(" ");

											var result = (((text).split(" ")).map(function(currentText){
												return currentText.substr(0, 1).toUpperCase() + currentText.substr(1);
											})).join(" ");

											html += "<li>" +result+": "+ item + "</li>";

										});
										html += "</ul>";

										$(form).find(".contenedor_errores").empty().append(html);


									}
								}


								setTimeout(function(){ $(form).attr("prevenir_envio","0"); }, 3000);

								if(modal_confirm == 1)
								{
									Modal.error({
										callback:callback,
										result:result
									});
								}
								else
								{
									//swal.close();
									Modal.close();

									if(callback!="")
									{
										eval(callback);
									}
								}

							}
						});


					}

				});

			}
		}
	}());

	var reset = (function () {
		return {
			validator:function(selector)
			{
				var validator = $(selector).validate();
				validator.resetForm();
				$(selector).find(".form-group").removeClass("has-error");
			}
		}
	}());

	var populate = (function () {
		return {
			container:function(fieldsContainerSelector, data)
			{
				$.each(data, function(key, value){
					$('[name='+key+']', fieldsContainerSelector).val(value);
				});
			}
		}
	}());

	var format = (function () {
		return {
			request:function(errores)
			{
				var new_json_errors = {};
				$.each(errores, function(key, value){
					var new_key = key;
					var key_parts = key.split('.');
					if(key_parts.length > 1)
					{
						var new_key = key_parts[0];
						for(var i = 1; i < key_parts.length; i++)
						{
							new_key += "["+key_parts[i]+"]";
						};
					}
					// console.log(value);
					for(var i = 0; i < value.length; i++)
					{
						new_json_errors[new_key] = value[i];
					}

				});
				return new_json_errors;
			}
		}
	}());

	//public methods
	return {
		start:start,
		reset:reset,
		populate:populate,
		format:format
	}
}());
