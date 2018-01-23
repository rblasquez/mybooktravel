/*
//example use
imagine.comprimirImagenABase64({
	selector: 'img',
	status_attr: 'compressed',
	maxHeight: 1080,
	compressionLevel: 0.9,
	onfinish: function(){}
});
*/

var imagine = (function() {

	//this function has to be declared before the methods
	Number.prototype.between = function(a, b, inclusive) {
	  var min = Math.min(a, b),
		max = Math.max(a, b);
		return inclusive ? this >= min && this <= max : this > min && this < max;
	}

	//juan carlos estrada nieto
	//2017-09-04
	//juancarlosestradanieto@gmail.com
	//reduce the weight and modify the resolution of the images(img tag)
	//related to a selector, and overwrite its src attributes
	//to the result of the base64 conversion
	return {
		compressImagesToBase64:function(parameters) {

			var selector = parameters['selector'] ? parameters['selector'] : 'img';
			var status_attr = parameters['status_attr'] ? parameters['status_attr'] : 'compressed';
			var maxWidth = parameters['maxWidth'] ? parameters['maxWidth'] : 0;
			var maxHeight = parameters['maxHeight'] ? parameters['maxHeight'] : 0;
			var compressionLevel = parameters['compressionLevel'] ? parameters['compressionLevel'] : 1;//quality. 0: worst, 1: best
			var onfinish = parameters['onfinish'] ? parameters['onfinish'] : null;
			var outputFormat = typeof parameters['outputFormat'] !== 'undefined' ? parameters['outputFormat'] : 'webp';

			var elements = document.querySelectorAll(selector);
			var elements_amount = elements.length;
			// var elements_amount_real = 0;
			// console.log("elements_amount: "+elements_amount);

			for (var i = 0; i < elements_amount; i++)
			{
				var img = elements[i];

				// var file = dataURLtoFile(img.src);
				// var file_size_in_mb = file.size/1024/1024;
				// console.log("original filesize :"+file_size_in_mb);
				// file = null;

				var compression = compressImage( i, img,status_attr, maxWidth, maxHeight, compressionLevel, outputFormat);

				img.addEventListener("load",  compression );

			}

			if (onfinish != null)
			{
				action = onfinish(selector);
				condition = " document.querySelectorAll(\""+selector+"["+status_attr+"='1']"+"\").length == "+elements_amount;
				milliseconds = 10;

				doWhenEval(action,condition,milliseconds);

			}

		},

		rotateBase64Image90deg:function(parameters){

			var selector = typeof parameters['selector'] !== 'undefined' ? parameters['selector'] : 'img';
			var status_attr = typeof parameters['status_attr'] !== 'undefined' ? parameters['status_attr'] : 'rotated';
			var isClockwise = typeof parameters['isClockwise'] !== 'undefined' ? parameters['isClockwise'] : true;
			var onfinish = typeof parameters['onfinish'] !== 'undefined' ? parameters['onfinish'] : null;

			var elements = document.querySelectorAll(selector);
			var elements_amount = elements.length;

			for (var i = 0; i < elements_amount; i++)
			{
				var img = elements[i];
				img.setAttribute(status_attr,0);

				img.src = rotateImage(img.src, isClockwise);
			}

			if (onfinish != null)
			{
				action = onfinish(elements_amount);
				condition = " document.querySelectorAll(\""+selector+"["+status_attr+"='1']"+"\").length == "+elements_amount;
				milliseconds = 10;

				doWhenEval(action,condition,milliseconds);

			}

		},

		initializePreviewImageUpload:function(parameters)
		{
			//parameters
			var fileInputSelector = typeof parameters['fileInputSelector'] !== 'undefined' ? parameters['fileInputSelector'] : null;
			var previewContainerSelector = typeof parameters['previewContainerSelector'] !== 'undefined' ? parameters['previewContainerSelector'] : null;
			var previewTemplateId = typeof parameters['previewTemplateId'] !== 'undefined' ? parameters['previewTemplateId'] : null;
			var addButtonTemplateId = typeof parameters['addButtonTemplateId'] !== 'undefined' ? parameters['addButtonTemplateId'] : null;
			var qualityPercentage = typeof parameters['qualityPercentage'] !== 'undefined' ? parameters['qualityPercentage'] : 100;
			var sendOnRotated = typeof parameters['sendOnRotated'] !== 'undefined' ? parameters['sendOnRotated'] : false;
			var sendOnSelected = typeof parameters['sendOnSelected'] !== 'undefined' ? parameters['sendOnSelected'] : false;
			var onStartSendOnSelected = typeof parameters['onStartSendOnSelected'] !== 'undefined' ? parameters['onStartSendOnSelected'] : null;
			var onFinishSendOnSelected = typeof parameters['onFinishSendOnSelected'] !== 'undefined' ? parameters['onFinishSendOnSelected'] : null;
			var onFileInputChanged = typeof parameters['onFileInputChanged'] !== 'undefined' ? parameters['onFileInputChanged'] : null;
			var onFinishSingleImageCompression = typeof parameters['onFinishSingleImageCompression'] !== 'undefined' ? parameters['onFinishSingleImageCompression'] : null;
			var onFinishAllImagesCompression = typeof parameters['onFinishAllImagesCompression'] !== 'undefined' ? parameters['onFinishAllImagesCompression'] : null;
			var sendUrl = typeof parameters['sendUrl'] !== 'undefined' ? parameters['sendUrl'] : "";
			var maxWidth = typeof parameters['maxWidth'] !== 'undefined' ? parameters['maxWidth'] : 0;
			var maxHeight = typeof parameters['maxHeight'] !== 'undefined' ? parameters['maxHeight'] : 0;
			var initialPreviews = typeof parameters['initialPreviews'] !== 'undefined' ? parameters['initialPreviews'] : [];
			var compressInitialPreviews = typeof parameters['compressInitialPreviews'] !== 'undefined' ? parameters['compressInitialPreviews'] : false;
			var startPreviewRotators = typeof parameters['startPreviewRotators'] !== 'undefined' ? parameters['startPreviewRotators'] : false;
			var outputFormat = typeof parameters['outputFormat'] !== 'undefined' ? parameters['outputFormat'] : 'webp';
			var csrfToken = typeof parameters['csrfToken'] !== 'undefined' ? parameters['csrfToken'] : '';

			//variable derived from parameteres
			qualityPercentage = ( isPositiveInteger(qualityPercentage) && parseInt(qualityPercentage).between(1,100) ) ? qualityPercentage : 100;
			var selected_container = document.querySelector(previewContainerSelector);
			maxHeight = isPositiveInteger(maxHeight) ? maxHeight : 0;

			if(addButtonTemplateId != null)
			{
				var templateClone = document.querySelector("#"+addButtonTemplateId).cloneNode(true);
				templateClone.setAttribute("id","");
				selected_container.appendChild(templateClone);
			}

			if(fileInputSelector != null && previewContainerSelector != null)
			{
				if(initialPreviews.length >0)
				{

					for (var i = 0;i < initialPreviews.length; i++)
					{
						var current = initialPreviews[i];
						// console.log(current);

						var uniqueId = Date.now();
						// create an Image
						var domImage = new Image();
						domImage.classList.add('img-responsive');
						domImage.classList.add('preview_image');
						domImage.setAttribute('preview_id',uniqueId);
						domImage.setAttribute('id',current['id']);
						domImage.setAttribute('uploaded',"2");

						domImage.addEventListener("load",function(){

							var uniqueId = this.getAttribute('preview_id');

							//fake compression is in order to have the base64 image url
							var previewImageSelector = "img[preview_id='"+uniqueId+"']";
							if(compressInitialPreviews)compressImage(0,this,'compressed',0, 0, 1,outputFormat);

							if(startPreviewRotators)startRotators(previewContainerSelector,this, sendOnRotated, sendUrl,csrfToken);

						});


						// domImage.setAttribute('crossOrigin', 'anonymous');
						domImage.src = current['url'];
						addDomImageToPreviewContainer(domImage, previewTemplateId, uniqueId, selected_container);
					}
				}

				document.querySelector(fileInputSelector).addEventListener("change", function(event) {

					//console.log('cambio el input');
					if(onFileInputChanged != null)onFileInputChanged(event.target.files);

					//console.log(event.target.files.length);
					for(var i = 0; i<event.target.files.length; i++)
					{
						//getting blob data
						var blobImageData = event.target.files[i];

						var uniqueId = Date.now();

						//create and add the image dom element
						var domImage = document.createElement("IMG");
						domImage.classList.add('img-responsive');
						domImage.classList.add('preview_image');
						domImage.setAttribute('preview_id',uniqueId);
						domImage.setAttribute('compressed', qualityPercentage == 100 ? 1 : 0 );
						domImage.setAttribute('uploaded',"0");

						//when finishes loading
						domImage.addEventListener("load",function(){

							var previewId = $(this).parents('.preview_image_container').attr('preview_id');
							var previewImageSelector = ".preview_image_container[preview_id='"+previewId+"'] .preview_image[preview_id='"+previewId+"']";

							// compression
							if(qualityPercentage != 100 && this.getAttribute("compressed") == "0")
							{
								imagine.compressImagesToBase64({
									selector: previewImageSelector,
									maxWidth:maxWidth,
									maxHeight: maxHeight,
									compressionLevel: qualityPercentage/100,
									outputFormat:outputFormat,
									onfinish: function(selector){

										// console.log("compressed "+selector);
										if(onFinishSingleImageCompression != null)onFinishSingleImageCompression(selector);

										if(sendOnSelected)
										{
											sendImage(sendUrl,previewImageSelector,csrfToken,onStartSendOnSelected,onFinishSendOnSelected);
										}
									}
								});

							}
							else
							{
								if(sendOnSelected)
								{
									// console.log("try send 2");
									sendImage(sendUrl,previewImageSelector,csrfToken,onStartSendOnSelected,onFinishSendOnSelected);
								}
							}

							if(startPreviewRotators)startRotators(previewContainerSelector,this, sendOnRotated, sendUrl,csrfToken);

						});

						//convert blob data to base 64, and set the src attribute of the image
						blobDataToBase64DomImage(blobImageData, domImage);

						addDomImageToPreviewContainer(domImage, previewTemplateId, uniqueId,selected_container);

					}


					if(onFinishAllImagesCompression != null)
					{
						action = onFinishAllImagesCompression;
						condition = " comparePreviewsAndCompressed() == 0 ";
						// condition = " document.querySelectorAll(\".preview_image\").length == document.querySelectorAll(\".preview_image[compressed='1']\").length ";
						milliseconds = 10;
						doWhen(action,condition,milliseconds);
					}

				});
			}
		},

		ajax:function(parameters)
		{
			//solo soporta metodo post y envio de datos json 2017-10-13
			var type = typeof parameters['type'] !== 'undefined' ? parameters['type'] : 'POST';
			var url = typeof parameters['url'] !== 'undefined' ? parameters['url'] : '';
			var data = typeof parameters['data'] !== 'undefined' ? parameters['data'] : '';
			var onFinish = typeof parameters['onFinish'] !== 'undefined' ? parameters['onFinish'] : null;
			var csrfToken = typeof parameters['csrfToken'] !== 'undefined' ? parameters['csrfToken'] : '';

			if(url != "" && data != "")
			{
				if (window.XMLHttpRequest)
				{
					// code for modern browsers
					ajxObj = new XMLHttpRequest();
				}
				else
				{
					// code for old IE browsers
					ajxObj = new ActiveXObject("Microsoft.XMLHTTP");
				}

				ajxObj.onreadystatechange = function() {
					if (this.readyState == 4)
					{
						if(onFinish != null)
						{
							onFinish(this);
						}
					}
				};

				//post method
				ajxObj.open(type, url, true);
				ajxObj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				if(csrfToken != "")ajxObj.setRequestHeader('X-CSRF-Token', csrfToken);
				ajxObj.send(jsonToWwwFormUrlencoded(data));
			}

		}

	}

	function startRotators(previewContainerSelector, domImage, sendOnRotated, sendUrl, csrfToken)
	{

		var previewId = $(domImage).parents('.preview_image_container').attr('preview_id');
		var previewImageSelector = ".preview_image_container[preview_id='"+previewId+"'] .preview_image[preview_id='"+previewId+"']";
		// console.log(previewId);

		var rotators = document.querySelectorAll(".preview_image_container[preview_id='"+previewId+"'] .rotator");
		// console.log(rotators);

		for(var i = 0; i<rotators.length; i++)
		{
			var currentRotator = rotators[i];

			currentRotator.classList.remove('rotator');
			currentRotator.classList.add('rotator_initialized');
			currentRotator.addEventListener("click",function(){

				domImage.setAttribute("uploaded","0");

				var isClockwise = this.classList.contains('clockwise') ? true : ( this.classList.contains('counter_clockwise') ? false : null );
				// console.log("rotator started");

				if(isClockwise != null)
				{

					imagine.rotateBase64Image90deg({
						selector: previewImageSelector,
						isClockwise: isClockwise,
						onfinish:function(){
							// console.log('rotated');
							if(sendOnRotated)
							{
								sendImage(sendUrl,previewImageSelector,csrfToken,null,null);
							}
						}
					});

				}

			});

		}
	}

	function addDomImageToPreviewContainer(domImage, previewTemplateId, uniqueId, selected_container)
	{

		if(previewTemplateId != null)
		{
			var templateClone = document.querySelector("#"+previewTemplateId).cloneNode(true);
			templateClone.setAttribute("id","");
			templateClone.classList.remove('preview_image_template');
			var previewObject = templateClone.querySelector('preview_image');
			previewObject.appendChild(domImage);
		}
		else
		{
			templateClone = document.createElement("DIV");
			templateClone.appendChild(domImage);
		}

		templateClone.classList.add('preview_image_container');
		templateClone.setAttribute('preview_id',uniqueId);

		//insert at the beggining
		//selected_container.insertBefore(templateClone, selected_container.childNodes[0]);

		//before the add button template
		var addButtonTemplate = selected_container.querySelector('.add_button_template');
		selected_container.insertBefore(templateClone, addButtonTemplate);

		//insert at the end
		//selected_container.appendChild(templateClone);

	}

	function sendImage(sendUrl,previewImageSelector,csrfToken,onStartCallback,onFinishCallback)
	{
		var domImage = document.querySelector(previewImageSelector);

		if(domImage.getAttribute('uploaded') == "0")
		{
			domImage.setAttribute('uploaded',"1");

			if(onStartCallback != null)onStartCallback(domImage);

			console.log("envia: "+domImage.src);
			console.log("envia: "+domImage.getAttribute('unique_id'));
			console.log("envia: "+domImage.getAttribute('compressed'));

			imagine.ajax({
				type:'POST',
				url: sendUrl,
				data: {image:domImage.src},
				csrfToken: csrfToken,
				onFinish: function(response){
					// console.log("imgen enviada");
					domImage.setAttribute('uploaded',"2");
					if(onFinishCallback != null)onFinishCallback(response,domImage);
				}
			});

		}
	}

	function jsonToWwwFormUrlencoded(json)
	{
		var wwwFormUrlencoded = "";
		for (key in json) {
			if(wwwFormUrlencoded != "")wwwFormUrlencoded += "&";
			wwwFormUrlencoded += encodeURIComponent(key)+"="+encodeURIComponent(json[key]);
		}
		return wwwFormUrlencoded;
	}

	function isPositiveInteger(string)
	{
		var regex = /[^\d*]/;
		var positiveInteger = !regex.test(string);
		return positiveInteger;
	}

	function compressImage(i,img,status_attr, maxWidth, maxHeight, compressionLevel, outputFormat)
	{
		if(outputFormat == "")outputFormat = 'webp';

		var compressed = img.getAttribute(status_attr);

		if(compressed == null || compressed == 0)
		{

			var naturalWidth = img.naturalWidth;
			var naturalHeight = img.naturalHeight;

			var maxWidth = maxWidth ? maxWidth : 0;
			var maxHeight = maxHeight ? maxHeight : 0;

			var newHeight = naturalHeight;
			var newWidth = naturalWidth;

			if(maxWidth != 0 || maxHeight != 0)
			{

				var widthAndHeigtScaled = getWidthAndHeigtScaled({
					originalWidth: naturalWidth,
					originalHeight: naturalHeight,
					maxWidth: maxWidth,
					maxHeight: maxHeight
				});

				newWidth = widthAndHeigtScaled.newWidth;
				newHeight = widthAndHeigtScaled.newHeight;

			}

			var offScreenCanvas = document.createElement('canvas');
			offScreenCanvas.id = i;

			var offScreenCanvasCtx = offScreenCanvas.getContext('2d');
			offScreenCanvas.width=newWidth;
			offScreenCanvas.height=newHeight;
			offScreenCanvasCtx.drawImage(img, 0, 0, newWidth, newHeight);
			// document.body.appendChild(offScreenCanvas);

			var base64_src = offScreenCanvas.toDataURL("image/"+outputFormat, compressionLevel);
			console.log(base64_src);
			img.src = base64_src;

			img.setAttribute(status_attr,1);

			offScreenCanvas.remove();

		}

	}

	function getWidthAndHeigtScaled(parameters)
	{

		var originalWidth = parameters['originalWidth'];
		var originalHeight = parameters['originalHeight'];
		var maxWidth = parameters['maxWidth'];
		var maxHeight = parameters['maxHeight'];

		console.log('originalWidth '+originalWidth);
		console.log('originalHeight '+originalHeight);
		console.log('maxWidth '+maxWidth);
		console.log('maxHeight '+maxHeight);

		var ratio = 1;
		var widthRatio = 1;
		var heightRatio = 1;
		if(originalWidth > maxWidth)
		{
			widthRatio = originalWidth / maxWidth;
		}
		console.log('widthRatio '+widthRatio);
		if(originalHeight > maxHeight)
		{
			heightRatio = originalHeight / maxHeight;
		}
		console.log('heightRatio '+heightRatio);

		ratio = ratio/ Math.max(widthRatio, heightRatio);
		console.log('ratio '+ratio);

		var newHeight = originalHeight * ratio;
		var newWidth = originalWidth * ratio;

		console.log('newWidth '+newWidth);
		console.log('newHeight '+newHeight);

		return {newWidth: newWidth, newHeight:newHeight}

	}

	function rotateImage(base64Image, isClockwise)
	{
		// create an off-screen canvas
		var offScreenCanvas = document.createElement('canvas');
		offScreenCanvasCtx = offScreenCanvas.getContext('2d');

		// create an Image
		var img = new Image();
		img.src = base64Image;

		// set its dimension to rotated size
		offScreenCanvas.height = img.width;
		offScreenCanvas.width = img.height;

		// rotate and draw source image into the off-screen canvas:
		if (isClockwise)
		{
			offScreenCanvasCtx.rotate(90 * Math.PI / 180);
			offScreenCanvasCtx.translate(0, -offScreenCanvas.width);
		}
		else
		{
			offScreenCanvasCtx.rotate(-90 * Math.PI / 180);
			offScreenCanvasCtx.translate(-offScreenCanvas.height, 0);
		}

		offScreenCanvasCtx.drawImage(img, 0, 0);

		// encode image to data-uri with base64
		var base64ImageRotated = offScreenCanvas.toDataURL("image/png", 100);
		offScreenCanvas.remove();

		return base64ImageRotated;
	}

	function comparePreviewsAndCompressed()
	{
		var previews = document.querySelectorAll(".preview_image").length;
		var compressed = document.querySelectorAll(".preview_image[compressed='1']").length;
		var diferencia = previews - compressed;
		// console.log("previews "+previews);
		// console.log("compressed "+compressed);
		// console.log("diferencia "+diferencia);
		return diferencia ;
	}

	function doWhenEval(action,condition,milliseconds)
	{
		//executes an action only when a condition ocurrs
		var interval = setInterval(function(){
			var eval_sentence = "var occurred = ( "+condition+" ) ? true : false;";
			// console.log(eval_sentence);
			eval(eval_sentence);
			// console.log("occurred: "+occurred);
			// console.log(condition);
			if(occurred)
			{
				eval(action);
				clearInterval(interval);
			}
		},milliseconds);
	}

	function doWhen(action,condition,milliseconds)
	{
		//executes an action only when a condition ocurrs
		var interval = setInterval(function(){
			var eval_sentence = "var occurred = ( "+condition+" ) ? true : false;";
			// console.log(eval_sentence);
			eval(eval_sentence);
			// console.log("occurred: "+occurred);
			// console.log(condition);
			if(occurred)
			{
				action();
				clearInterval(interval);
			}
		},milliseconds);
	}

	function dataURLtoFile(dataurl, filename)
	{
		if(filename == null || filename == '')filename = 'file';

		var arr = dataurl.split(',');
		var mime = arr[0].match(/:(.*?);/)[1];
		var	bstr = atob(arr[1]);
		var n = bstr.length;
		var u8arr = new Uint8Array(n);

		while(n--)
		{
			u8arr[n] = bstr.charCodeAt(n);
		}
		return new File([u8arr], filename, {type:mime});
	}

	function blobDataToBase64DomImage(blobImageData,img)
	{
		var reader = new window.FileReader();
		reader.readAsDataURL(blobImageData);
		reader.onloadend = function () {
			base64data = reader.result;
			img.src = base64data;
		}
	}

}());
