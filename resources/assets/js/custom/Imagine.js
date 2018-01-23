var Imagine = (function () {

	// var imagineObject = this;

	//templates
	var inputTemplate = `<input type="file" class='file_input' multiple="multiple" accept=".png, .jpg, .jpeg" style="display:none;visibility:hidden;" >`;

  	var addImageTemplate = `
		<div class=" add_button col-xs-6 col-md-2 col-sm-3" >
			<button type="button" class="add_image"  >
				<i class="fa fa-plus" ></i>
				Agregar imágenes
			</button>
		</div>
		`;

  	var imagePreviewTemplate = `
		<div class="col-md-2 col-sm-4 col-xs-6 preview_image_container" id="unique_id"  >
			<div class="panel panel-default">
				<div class="panel-heading mbt_pt-0 mbt_pb-0 preview_image_header">
					<input type="radio" id="" class="main_image_input" name="main_image" >
					<label for="" class="make_main_image main_image_label mbt_mt-20" >Portada</label>
				</div>
				<div class="panel-body img_container preview_image_body">
					<figure>
						<preview_image ></preview_image>
					</figure>
				</div>
				<div class="panel-footer preview_image_footer">
					<div class="row">
						<div class="col-xs-4">
							<button type="button" class="btn btn-xs btn-default rotator counter_clockwise " title="Girar a la izquierda"><i class="fa fa-rotate-left"></i></button>
						</div>
						<div class="col-xs-4">
							<button type="button" class="btn btn-xs btn-default delete" title="Eliminar archivo"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></button>
						</div>
						<div class="col-xs-4">
							<button type="button" class="btn btn-xs btn-default rotator clockwise " title="Girar a la derecha"><i class="fa fa-rotate-right"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		`;


	//methods
	var previewer = (function () {
		return {
			start:function(parameters)
			{
				// console.log(imagineObject.Imagine.parameters);
				// imagineObject.Imagine.parameters = parameters;

				var containerSelector = typeof parameters['containerSelector'] !== 'undefined' ? parameters['containerSelector'] : 'body';
				var fileInputSelector = typeof parameters['fileInputSelector'] !== 'undefined' ? parameters['fileInputSelector'] : "input[type='file']";
				var onSelect = typeof parameters['onSelect'] !== 'undefined' ? parameters['onSelect'] : null;
				var onFinishSelect = typeof parameters['onFinishSelect'] !== 'undefined' ? parameters['onFinishSelect'] : null;
				var maxFiles = typeof parameters['maxFiles'] !== 'undefined' ? parameters['maxFiles'] : 1;
				var maxFilesOnSelect = typeof parameters['maxFilesOnSelect'] !== 'undefined' ? parameters['maxFilesOnSelect'] : null;
				var initialPreviews = typeof parameters['initialPreviews'] !== 'undefined' ? parameters['initialPreviews'] : null;

				var container = document.querySelector(containerSelector);
				container.insertAdjacentHTML('beforeend', inputTemplate);
				var fileInput = container.querySelector('.file_input');
				container.insertAdjacentHTML('beforeend', addImageTemplate);
				var addButton = container.querySelector('.add_button');
				addButton.addEventListener("click", function(event) {
					// console.log(fileInput);
					fileInput.click();
				});

				container.querySelector(fileInputSelector).addEventListener("change", function(event) {

					if(onSelect != null)onSelect(event.target.files);

					var numberOfFilesSelected = container.querySelectorAll('.preview_image').length;
					// console.log(numberOfFilesSelected);
					var numberOfFilesAvailable = maxFiles - numberOfFilesSelected;

					var numberOfFiles = maxFilesOnSelect == null ? event.target.files.length : Math.min(maxFilesOnSelect, event.target.files.length);
					numberOfFiles = Math.min(numberOfFiles,numberOfFilesAvailable);

					for(var i = 0; i < numberOfFiles ; i++)
					{

						var domImage = Imagine.previewer.createNewPreview({containerSelector:containerSelector});

						//when load every image
						domImage.addEventListener("load",function(numberOfFiles){
							if(this.getAttribute('loaded') != 1)
							{
								this.setAttribute('loaded',0);
								// console.log('Image loaded: '+this.getAttribute('preview_id'));

								//console.log(event.target.files.length);
								//console.log(container.querySelectorAll(".preview_image[loaded='0']").length);
								if( numberOfFiles == container.querySelectorAll(".preview_image[loaded='0']").length)
								{

									var newPreviews = container.querySelectorAll(".preview_image[loaded='0']");
									for( var j = 0;j < newPreviews.length ;j++ )
									{
										var current = newPreviews[j];
										current.setAttribute('loaded',1);
									}

									//when finishes loading all images selected
									if(onFinishSelect!=null)onFinishSelect();

								}
							}
						}.bind(domImage,numberOfFiles));

						var blobImageData = event.target.files[i];

						Imagine.previewer.blobImageDataToBase64SrcDomImage({
							blobImageData:blobImageData,
							domImage:domImage,
							onFinish:function(domImage){
								// console.log('base64 generated: '+domImage.getAttribute('preview_id'));
							}
						});

					}

				});

				// return imagineObject.Imagine;

			},
			blobImageDataToBase64SrcDomImage(parameters)
			{
				var blobImageData = parameters['blobImageData'];
				var domImage = parameters['domImage'];
				var onFinish = parameters['onFinish'];

				var reader = new window.FileReader();
				reader.readAsDataURL(blobImageData);
				reader.onloadend = function () {
					var base64data = reader.result;
					domImage.src = base64data;
					domImage.setAttribute('encoded',1);
					onFinish(domImage);
				}
			},
			createNewPreview(parameters)
			{
				var containerSelector = typeof parameters['containerSelector'] !== 'undefined' ? parameters['containerSelector'] : 'body';
				var imgAttributes = parameters['imgAttributes'] ? parameters['imgAttributes'] : null ;

				var container = document.querySelector(containerSelector);

				var uniqueId = Date.now();
				var domImage = document.createElement("IMG");
				console.log(domImage);//no quitar este console log, por que las imagenes no precargaran
				domImage.setAttribute('preview_id',uniqueId);
				domImage.classList.add('img-responsive');
				domImage.classList.add('preview_image');
				if(imgAttributes != null)
				{
					for (var attribute in imgAttributes) {
						domImage.setAttribute(attribute,imgAttributes[attribute]);
					}
				}

				var previewTemplate = imagePreviewTemplate.replace(/unique_id/g, uniqueId);
				var addButton = container.querySelector(containerSelector+' .add_button');
				addButton.insertAdjacentHTML('beforebegin', previewTemplate);

				var currentPreviewSelector = ".preview_image_container[id='"+uniqueId+"']";
				var preview = container.querySelector(currentPreviewSelector);

				preview.querySelector("preview_image").appendChild(domImage);

				// Imagine.helper.doWhen({
				// 	condition: function (container,currentPreviewSelector){
				//
				// 		var result = container.querySelectorAll(currentPreviewSelector).length == 1;
				// 		return result;
				//
				// 	}.bind({},container,currentPreviewSelector),
				// 	action:function(container,currentPreviewSelector,domImage, imgAttributes){
				//
				//
				//
				// 	}.bind({},container,currentPreviewSelector,domImage, imgAttributes),
				// 	milliseconds:10
				// });


				return domImage;
			},
			setInitialPreviews(parameters)
			{
				// console.log(imagineObject.Imagine.parameters);
				var containerSelector = typeof parameters['containerSelector'] !== 'undefined' ? parameters['containerSelector'] : 'body';
				var initialPreviews = parameters['initialPreviews'] ? parameters['initialPreviews'] : null ;

				var container = document.querySelector(containerSelector);

				for(var i=0; i<initialPreviews.length;i++)
				{
					var currentPreview = initialPreviews[i];
					currentPreview.loaded = 1;
					currentPreview.encoded = 1;
					currentPreview.compressed = 1;
					currentPreview.uploaded = 2;
					// console.log(currentPreview);

					var domImage = Imagine.previewer.createNewPreview({
						containerSelector:containerSelector,
						imgAttributes: currentPreview
					});

					domImage.setAttribute('previewed',1);

				}

			}
		}
	}());

	var compressor = (function () {
		return {
			start:function(parameters)
			{

				var containerSelector = typeof parameters['containerSelector'] !== 'undefined' ? parameters['containerSelector'] : 'body';
				var compressionLevel = typeof parameters['compressionLevel'] !== 'undefined' ? parameters['compressionLevel'] : 1;//quality. 0: worst, 1: best
				var maxWidth = parameters['maxWidth'] ? parameters['maxWidth'] : 0;
				var maxHeight = parameters['maxHeight'] ? parameters['maxHeight'] : 0;
				var newSrcTarget = typeof parameters['newSrcTarget'] !== 'undefined' ? parameters['newSrcTarget'] : 'src';
				var onfinishAllImages = parameters['onfinishAllImages'] ? parameters['onfinishAllImages'] : null;
				var onFinishEveryImage = parameters['onFinishEveryImage'] ? parameters['onFinishEveryImage'] : null;
				var outputFormat = typeof parameters['outputFormat'] !== 'undefined' ? parameters['outputFormat'] : 'png';
				var selector = parameters['selector'] ? parameters['selector'] : '.preview_image';
				var statusAttr = parameters['statusAttr'] ? parameters['statusAttr'] : 'compressed';

				var container = document.querySelector(containerSelector);

				var elements = container.querySelectorAll(selector);
				var elements_amount = elements.length;
				// var elements_amount_real = 0;
				// console.log("elements_amount: "+elements_amount);

				for (var i = 0; i < elements_amount; i++)
				{
					var img = elements[i];
					var currentImageSelector = ".preview_image[preview_id='"+img.getAttribute('preview_id')+"']";

					var lastImageSelector = '';
					if(i > 0 )
					{
						var lastImg = elements[i-1];
						lastImageSelector =  ".preview_image[preview_id='"+lastImg.getAttribute('preview_id')+"']";

					}
					// console.log(i);
					// console.log(lastImageSelector);
					var compresionParameters = {
						compressionLevel: compressionLevel,
						maxWidth: maxWidth,
						maxHeight: maxHeight,
						newSrcTarget:newSrcTarget,
						onFinish:onFinishEveryImage,
						outputFormat: outputFormat,
						selector: currentImageSelector
					};

					Imagine.helper.doWhen({
						condition: function (i,lastImageSelector){

							var result = ( i == 0 || ( lastImageSelector != '' && container.querySelector(lastImageSelector).getAttribute('compressed') == 1) );
							return result;

						}.bind({},i,lastImageSelector),
						action:function(compresionParameters){

							var compression = Imagine.compressor.compress(compresionParameters);

						}.bind({},compresionParameters),
						milliseconds:10
					});

					// img.addEventListener("load",  compression );
				}

				if (onfinishAllImages != null)
				{

					Imagine.helper.doWhen({
						condition: function (){
							return container.querySelectorAll(selector+"["+statusAttr+"='1']").length == elements_amount;
						},
						action:function(){
							onfinishAllImages(selector);
						}
					});

				}

			},
			compress:function(parameters)
			{

				var compressionLevel = typeof parameters['compressionLevel'] !== 'undefined' ? parameters['compressionLevel'] : 1;//quality. 0: worst, 1: best
				var maxWidth = parameters['maxWidth'] ? parameters['maxWidth'] : 0;
				var maxHeight = parameters['maxHeight'] ? parameters['maxHeight'] : 0;
				var newSrcTarget = typeof parameters['newSrcTarget'] !== 'undefined' ? parameters['newSrcTarget'] : 'src';
				var onFinish = typeof parameters['onFinish'] !== 'undefined' ? parameters['onFinish'] : null;
				var outputFormat = typeof parameters['outputFormat'] !== 'undefined' ? parameters['outputFormat'] : 'png';
				var selector = parameters['selector'] ? parameters['selector'] : 'img';
				var statusAttr = parameters['statusAttr'] ? parameters['statusAttr'] : 'compressed';

				var img = document.querySelector(selector);
				var compressed = img.getAttribute(statusAttr);

				img.addEventListener("load",function(){
					if(this.getAttribute(statusAttr) != 1)
					{
						this.setAttribute(statusAttr,1);
						// console.log('Image compressed: '+this.getAttribute('preview_id'));
						// console.log('especificar evento despues de comprimir cada imagen');

						//when finishes image compression
						if(onFinish!=null)onFinish(this);
					}
				});

				if(compressed == null || compressed == 0)
				{

					var naturalWidth = img.naturalWidth;
					var naturalHeight = img.naturalHeight;

					// var maxWidth = maxWidth ? maxWidth : 0;
					// var maxHeight = maxHeight ? maxHeight : 0;

					var newHeight = naturalHeight;
					var newWidth = naturalWidth;

					if(maxWidth != 0 || maxHeight != 0)
					{

						var widthAndHeigtScaled = Imagine.compressor.getWidthAndHeigtScaled({
							originalWidth: naturalWidth,
							originalHeight: naturalHeight,
							maxWidth: maxWidth,
							maxHeight: maxHeight
						});

						newWidth = widthAndHeigtScaled.newWidth;
						newHeight = widthAndHeigtScaled.newHeight;

					}

					var offScreenCanvas = document.createElement('canvas');
					//offScreenCanvas.id = i;

					var offScreenCanvasCtx = offScreenCanvas.getContext('2d');
					offScreenCanvas.width=newWidth;
					offScreenCanvas.height=newHeight;
					offScreenCanvasCtx.drawImage(img, 0, 0, newWidth, newHeight);
					// document.body.appendChild(offScreenCanvas);
					// console.log(compressionLevel);
					var base64_src = offScreenCanvas.toDataURL("image/"+outputFormat, compressionLevel);
					// console.log(base64_src);
					img.setAttribute(newSrcTarget,base64_src);

					// img.setAttribute(statusAttr,1);

					offScreenCanvas.remove();

				}

			},
			getWidthAndHeigtScaled:function(parameters)
			{

				var originalWidth = parameters['originalWidth'];
				var originalHeight = parameters['originalHeight'];
				var maxWidth = parameters['maxWidth'];
				var maxHeight = parameters['maxHeight'];

				//console.log('originalWidth '+originalWidth);
				//console.log('originalHeight '+originalHeight);
				//console.log('maxWidth '+maxWidth);
				//console.log('maxHeight '+maxHeight);

				var ratio = 1;
				var widthRatio = 1;
				var heightRatio = 1;
				if(originalWidth > maxWidth)
				{
					widthRatio = originalWidth / maxWidth;
				}
				//console.log('widthRatio '+widthRatio);
				if(originalHeight > maxHeight)
				{
					heightRatio = originalHeight / maxHeight;
				}
				//console.log('heightRatio '+heightRatio);

				ratio = ratio/ Math.max(widthRatio, heightRatio);
				//console.log('ratio '+ratio);

				var newHeight = originalHeight * ratio;
				var newWidth = originalWidth * ratio;

				//console.log('newWidth '+newWidth);
				//console.log('newHeight '+newHeight);

				return {newWidth: newWidth, newHeight:newHeight}


			}

		}
	}());

	var sender = (function () {
		return {
			send:function(parameters)
			{

				var containerSelector = typeof parameters['containerSelector'] !== 'undefined' ? parameters['containerSelector'] : 'body';
				var csrfToken = typeof parameters['csrfToken'] !== 'undefined' ? parameters['csrfToken'] : '';
				var onStart = typeof parameters['onStart'] !== 'undefined' ? parameters['onStart'] : null;
				var onFinishEveryImage = typeof parameters['onFinishEveryImage'] !== 'undefined' ? parameters['onFinishEveryImage'] : null;
				var onfinishAllImages = typeof parameters['onfinishAllImages'] !== 'undefined' ? parameters['onfinishAllImages'] : null;
				var selector = typeof parameters['selector'] !== 'undefined' ? parameters['selector'] : '.preview_image';
				var url = typeof parameters['url'] !== 'undefined' ? parameters['url'] : '';

				var container = document.querySelector(containerSelector);

				var elements = container.querySelectorAll(selector+":not([uploaded='1']):not([uploaded='2'])");
				var elements_amount = elements.length;
				// console.log(elements);

				for(var i = 0; i < elements_amount; i++)
				{

					var domImage = elements[i];
					domImage.setAttribute('uploaded',1);

					var currentImageSelector = ".preview_image[preview_id='"+domImage.getAttribute('preview_id')+"']";

				  var lastImageSelector = '';
				  if(i > 0 )
				  {
				    var lastImg = elements[i-1];
				    lastImageSelector =  ".preview_image[preview_id='"+lastImg.getAttribute('preview_id')+"']";

				  }

					var sendingParameters = {
						type:'POST',
						url: url,
						data: {image:domImage.src},
						csrfToken: csrfToken,
						onStart:function(){
							// console.log("empezo a enviar");
						},
						onFinish: function(response){
							var domImage = this;
							// console.log(response);
							// console.log(this);
							domImage.setAttribute('uploaded',"2");
							if(onFinishEveryImage != null)onFinishEveryImage(response,domImage);
						}.bind(domImage)
					};

					Imagine.helper.doWhen({
				    condition: function (i,lastImageSelector){

				      var result = ( i == 0 || ( lastImageSelector != '' && container.querySelector(lastImageSelector).getAttribute('uploaded') == 2) );
							// console.log("result: "+result);
				      return result;

				    }.bind({},i,lastImageSelector),
				    action:function(sendingParameters){
							// console.log('paso por aqui');
				      var sending = Imagine.sender.ajax(sendingParameters);

				    }.bind({},sendingParameters),
				    milliseconds:10
				  });

				}

				//when all images are sent
				var numberOfFiles = document.querySelectorAll('.preview_image').length;

				Imagine.helper.doWhen({
					condition: function (){

						var numberOfFiles = container.querySelectorAll('.preview_image').length;
						var numberOfFilesUploaded = container.querySelectorAll(".preview_image[uploaded='2']").length;
						var result = numberOfFiles == numberOfFilesUploaded ? true : false;
						// console.log("verify all sent: "+result);

						return result;

					},
					action:function(){

						if(onfinishAllImages != null)onfinishAllImages();

					},
					milliseconds:10
				});

			},
			ajax:function(parameters)
			{
				//only suppor post method and send json data type 2017-10-13
				var type = typeof parameters['type'] !== 'undefined' ? parameters['type'] : 'POST';
				var url = typeof parameters['url'] !== 'undefined' ? parameters['url'] : '';
				var data = typeof parameters['data'] !== 'undefined' ? parameters['data'] : '';
				var onStart = typeof parameters['onStart'] !== 'undefined' ? parameters['onStart'] : null;
				var onFinish = typeof parameters['onFinish'] !== 'undefined' ? parameters['onFinish'] : null;
				var csrfToken = typeof parameters['csrfToken'] !== 'undefined' ? parameters['csrfToken'] : '';

				if(onStart != null)onStart();

				if(url != "" && data != "")
				{
					var ajxObj  = null;
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
					ajxObj.send(Imagine.helper.jsonToWwwFormUrlencoded({data:data}));
				}
			}
		}
	}());

	var helper = (function () {
		return {
			jsonToWwwFormUrlencoded:function(parameters)
			{
				var data = parameters['data'];

				var wwwFormUrlencoded = "";
				for (var key in data) {
					if(wwwFormUrlencoded != "")wwwFormUrlencoded += "&";
					wwwFormUrlencoded += encodeURIComponent(key)+"="+encodeURIComponent(data[key]);
				}
				return wwwFormUrlencoded;
			},
			doWhen:function(parameters)
			{
				// action,condition,milliseconds
				var action = parameters["action"];
				var condition = parameters["condition"];
				var milliseconds = typeof parameters["milliseconds"] != 'undefined' ? parameters["milliseconds"] : 10 ;

				//executes an action only when a condition ocurrs
				var occurred = false;
				var interval = setInterval(function(){
					occurred = condition();
					// console.log("occurred: "+occurred);
					if(occurred)
					{
						action();
						clearInterval(interval);
					}
				},milliseconds);
			}
		}
	}());

	//revealing methods
	return {
		previewer: previewer,
		compressor: compressor,
		helper: helper,
		sender: sender,
	};

})();
