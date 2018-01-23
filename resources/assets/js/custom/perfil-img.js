(function (factory) {
		if (typeof define === 'function' && define.amd) {
			define(['jquery'], factory);
		} else if (typeof exports === 'object') {
			factory(require('jquery'));
		} else {
			factory(jQuery);
		}
	})(function ($) {
		'use strict';

		$(function () {
			return new CropAvatar($('#crop-avatar'));
		});

		var console = window.console || { log: function () {} };

		function CropAvatar($element) {
			this.$container     = $element;
			this.$avatarView    = this.$container.find('.avatar-view');
			this.$avatar        = this.$avatarView.find('img');
			this.$avatarModal   = this.$container.find('#avatar-modal');
			this.$loading       = this.$container.find('.loading');
			this.$avatarForm    = this.$avatarModal.find('.avatar-form');
			this.$avatarUpload  = this.$avatarForm.find('.avatar-upload');
			this.$mensajes  	= this.$avatarForm.find('.avatar-mensajes');
			this.$avatarSrc     = this.$avatarForm.find('.avatar-src');
			this.$avatarData    = this.$avatarForm.find('.avatar-data');
			this.$avatarInput   = this.$avatarForm.find('.inputfile');
			this.$avatarSave    = this.$avatarForm.find('.avatar-save');
			this.$avatarBtns    = this.$avatarForm.find('.avatar-botones');
			this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');

			this.$imageCanvas   = this.$avatarModal.find('#miCanvas');
			this.init();
		}

		CropAvatar.prototype = {
			constructor: CropAvatar,
			support: {
				fileList: !!$('<input type="file">').prop('files'),
				blobURLs: !!window.URL && URL.createObjectURL,
				formData: !!window.FormData
			},
			init: function () {
				this.support.datauri = this.support.fileList && this.support.blobURLs;
				if (!this.support.formData) {
					this.initIframe();
				}
				this.initTooltip();
				this.addListener();
			},
			addListener: function () {
				this.$avatarView.on('click', $.proxy(this.click, this));
				this.$avatarInput.on('change', $.proxy(this.change, this));
				this.$avatarForm.on('submit', $.proxy(this.submit, this));
				this.$avatarBtns.on('click', $.proxy(this.rotate, this));
			},
			initTooltip: function () {
				this.$avatarView.tooltip({
					placement: 'bottom'
				});
			},
			initPreview: function () {
				var url = this.$avatar.attr('src');
				//console.log(url);
				//this.$avatarPreview.html('<img src="' + url + '">');
			},
			initIframe: function () {
				var target = 'upload-iframe-' + (new Date()).getTime();
				var $iframe = $('<iframe>').attr({
					name: target,
					src: ''
				});
				var _this = this;
				$iframe.one('load', function () {
					$iframe.on('load', function () {
						var data;
						try {
							data = $(this).contents().find('body').text();
						} catch (e) {
							console.log(e.message);
						}
						if (data) {
							try {
								data = $.parseJSON(data);
							} catch (e) {
								console.log(e.message);
							}
							_this.submitDone(data);
						} else {
							_this.submitFail('Image upload failed!');
						}
						_this.submitEnd();
					});
				});
				this.$iframe = $iframe;
				this.$avatarForm.attr('target', target).after($iframe.hide());
			},
			click: function () {
				this.$avatarModal.modal('show');
				this.initPreview();
			},
			change: function () {
				var files;
				var file;
				this.$avatarSave.removeClass('hide')
				if (this.support.datauri) {
					files = this.$avatarInput.prop('files');
					if (files.length > 0) {
						file = files[0];
						if (this.isImageFile(file)) {
							if (this.url) {
								URL.revokeObjectURL(this.url);
							}
							this.url = URL.createObjectURL(file);
							this.startCropper();
						}
					}
				} else {
					file = this.$avatarInput.val();
					if (this.isImageFile(file)) {
						this.syncUpload();
					}
				}
			},
			submit: function () {
				if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
					return false;
				}
				if (this.support.formData) {
					this.ajaxUpload();
					return false;
				}
			},
			rotate: function (e) {
				var data;
				if (this.active) {
					data = $(e.target).data();
					if (data.method) {
						this.$img.cropper(data.method, data.option);
					}
				}
			},
			isImageFile: function (file) {
				if (file.type) {
					return /^image\/\w+$/.test(file.type);
				} else {
					return /\.(jpg|jpeg|png)$/.test(file);
				}
			},
			startCropper: function () {
				var _this = this;
				if (this.active) {
					this.$img.cropper('replace', this.url);
				} else {
					this.$img = $('<img src="' + this.url + '">');
					this.$avatarWrapper.empty().html(this.$img);
					this.$img.cropper({
						aspectRatio: 1,
						guides: false,
						rotatable: true,
						scalable: true,
						zoomOnTouch: false,
						viewMode: 2,
						background: false,
						checkOrientation: true,
						responsive: true,
						crop: function (e) {
							var json = [
							'{"x":' + e.x,
							'"y":' + e.y,
							'"height":' + e.height,
							'"width":' + e.width,
							'"rotate":' + e.rotate + '}'
							].join();
							var srcResized = $(this).cropper('getCroppedCanvas', {
								height: 200,
							});

							/*
							var canvas = srcResized.toDataURL("image/png");
							this.canvas = canvas;
							$('#miCanvas').html(srcResized);
							*/
							_this.$avatarData.val(json);

						},
						ready: function () {

						},
					});
					this.active = true;
				}
				this.$avatarModal.one('hidden.bs.modal', function () {
					_this.stopCropper();
				});
			},
			stopCropper: function () {
				if (this.active) {
					this.$img.cropper('destroy');
					this.$img.remove();
					this.active = false;
				}
			},
			ajaxUpload: function () {
				var _this = this;
				var url = this.$avatarForm.attr('action');
				var data = new FormData(this.$avatarForm[0]);
				
				var srcResized = this.$img.cropper('getCroppedCanvas', {
								height: 200,
							});
				//$('#miCanvas').html(srcResized);
				var canvas = srcResized.toDataURL("image/png");

				data.append('canvas', canvas)
				
				var _this = this;
				$.ajax(url, {
					type: 'post',
					data: data,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						_this.submitStart();
					},
					success: function (data) {
						_this.submitDone(data);
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						_this.submitFail(textStatus || errorThrown);
					},
					complete: function () {
						_this.submitEnd();
					}
				});
			},
			syncUpload: function () {
				this.$avatarSave.click();
			},
			submitStart: function () {
				this.$loading.fadeIn();
			},
			submitDone: function (data) {
				$('#userAvatar').attr('src', data);
				//$('#userAvatar').attr('src', data + '?' + new Date().getTime());
				this.$avatarModal.modal('hide');
				this.uploaded = true;
				this.startCropper();
			},
			submitFail: function (msg) {
				this.alert(msg);
			},
			submitEnd: function () {
				this.$loading.fadeOut();
			},
			cropDone: function () {
				this.$avatarForm.get(0).reset();
				this.$avatar.attr('src', this.url);
				this.stopCropper();
				this.$avatarModal.modal('hide');
			},
			alert: function (msg) {
				var $alert = [
				'<div class="clearfix"></div>',
				'<div class="alert alert-danger avatar-alert alert-dismissable">',
				'<button type="button" class="close" data-dismiss="alert" style="width: auto;">&times;</button>',
				'Ha ocurrido un error en la carga de tu imagen, por favor intenta nuevamente.',
				'</div>'
				].join('');
				this.$mensajes.html($alert);
			}
		};
	});