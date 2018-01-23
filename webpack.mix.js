const mix = require('laravel-mix');
const fs = require('fs');
const fsx = require('fs-extra');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');


// Se borran las carpetas del public
fsx.removeSync('public/css/*');
fsx.removeSync('public/fonts');
fsx.removeSync('public/img');
fsx.removeSync('public/js');


// ================================================================= CSS

// Esencial: Archivos de terceros que se requieren para dibujar Home
mix.styles([
		'resources/assets/css/esencial/bootstrap.css',
		'resources/assets/css/esencial/animate.css',
		'resources/assets/css/esencial/aos.css',
		'resources/assets/css/esencial/daterangepicker.min.css',
		'resources/assets/css/esencial/font-awesome.css',
		'resources/assets/css/esencial/slick.css',
	], 'public/css/esencial.css')
	.options({
		processCssUrls: true
	});

// Vendor: Archivos de terceros
mix.styles([
		'resources/assets/css/vendor/simpleLightbox.css',
		'resources/assets/css/vendor/cropper.css',
		'resources/assets/css/vendor/jquery.steps.css',
		'resources/assets/css/vendor/bootstrap-toggle.min.css',
		'resources/assets/css/vendor/bootstrap-slider.min.css',
		'resources/assets/css/vendor/fullcalendar.css',
	], 'public/css/vendor.css')
	.options({
		processCssUrls: true
	});

//printer-friendly css, use the media='print' attribute of the <link> tag
mix.styles([
		'resources/assets/css/vendor/fullcalendar.print.css',
	], 'public/css/vendor.print.css')
	.options({
		processCssUrls: true
	});

// custom.css
// Combinar todos los CSS propios en un único archivo
mix.styles([
		'resources/assets/css/custom/app.css',
		'resources/assets/css/custom/queries.css',
		'resources/assets/css/custom/mbt_estail.css',
		'resources/assets/css/custom/fonts.css',
		'resources/assets/css/custom/cards.css',
	], 'public/css/custom.css')
	.options({
		processCssUrls: true
	});


// ================================================================= JS

// Muchos scripts dependen de jQuery, es necesario especificar el orden
// Esencial: Archivos de terceros que se requieren para dibujar Home
mix.scripts([
	'resources/assets/js/esencial/jquery-3.2.1.min.js',
	'resources/assets/js/esencial/jquery-migrate-1.4.1.js',
	'resources/assets/js/esencial/twitter-bootstrap.js',
	'resources/assets/js/esencial/moment.js',
	'resources/assets/js/esencial/moment_es.js',
	'resources/assets/js/esencial/moment_pt-br.js',
	'resources/assets/js/esencial/jquery.daterangepicker.min.js',
	'resources/assets/js/esencial/aos.js',
	'resources/assets/js/esencial/parallax-background.js',
	'resources/assets/js/esencial/slick.js',
	'resources/assets/js/esencial/blazy.js',
	'resources/assets/js/esencial/sweetalert.min.js',
], 'public/js/esencial.js');

// Vendor: Archivos de terceros
// Blueimp es requerido para otro script
mix.scripts([
	'resources/assets/js/vendor/readmore.js',
	'resources/assets/js/vendor/jquery.mask.js',
	'resources/assets/js/vendor/simpleLightbox.js',
	'resources/assets/js/vendor/jquery.focuspoint.js',
	'resources/assets/js/vendor/cropper.js',
	'resources/assets/js/vendor/jquery.blockUI.js',
	'resources/assets/js/vendor/jquery.steps.js',
	'resources/assets/js/vendor/bootstrap-slider.min.js',
	'resources/assets/js/vendor/bootstrap-toggle.min.js',
	'resources/assets/js/vendor/bootstrap-maxlength.js',
	'resources/assets/js/vendor/tooltipsy.source.js'
], 'public/js/vendor.js');


// Combinar archivos con lo obligatorio y lo específico
var archivos = [
	'index',
	'login',
	'perfil-edit',
	'propiedades-create',
	'propiedades-edit',
	'Imagenes',
	'perfil-img',
	'register',
	'calendario',
	'Imagine',
];

archivos.forEach(function(item) {
	mix.babel(['resources/assets/js/custom/' + item + '.js'], 'public/js/' + item + '.js');
});

var archivos = [
	'propiedades-detalles',
];

archivos.forEach(function(item) {
	mix.copy(['resources/assets/js/custom/' + item + '.js'], 'public/js/' + item + '.js');
});

mix.babel([
	'resources/assets/js/custom/ux.js',
	'resources/assets/js/custom/map.js',
	'resources/assets/js/custom/app.js'
], 'public/js/custom.js');

// ==================================================== Crear y editar propiedades
mix.scripts([
	//'resources/assets/js/generate/jquery.mask.js',
	'resources/assets/js/generate/jquery.inputmask.bundle.js',
	'resources/assets/js/generate/phone.js',
	'resources/assets/js/generate/phone-be.js',
	'resources/assets/js/generate/phone-ru.js',
	'resources/assets/js/generate/jquery.repeater.js',
	'resources/assets/js/generate/jquery.number.js',
	'resources/assets/js/vendor/fullcalendar.js',
], 'public/js/generate.js');

// Copiar fuentes
mix.copyDirectory('resources/assets/fonts', 'public/fonts');

mix.babel(['resources/assets/js/custom/prueba.js'], 'public/js/prueba.js');

// Optimizar imagenes con MozJPG (progresivo)
mix.webpackConfig({
	plugins: [
		new CopyWebpackPlugin([{
			from: 'resources/assets/img',
			to: 'img',
		}]),
		new ImageminPlugin({
			test: /\.(jpe?g|png|gif|svg)$/i,
			plugins: [
				imageminMozjpeg({
					quality: 80,
				})
			]
		})
	]
});

mix.options({
	uglify: {
		compress: {
			drop_console: false,
		}
	},
});

//se guarda la hora de la ultima actualizacion
var fileContent = Number(new Date());

// The absolute path of the new file with its name
var filepath = "public/last_mix_update.txt";

fs.writeFile(filepath, fileContent, (err) => {
	if (err) throw err;
	console.log("\n La hora de compresión ha sido actualizada con éxito!");
});



//ADMINISTRACION: INICIO


/*
fsx.removeSync('public/administracion');

//css
mix.styles([
		'resources/assets/administracion/css/vendor/font-awesome.css',
		'resources/assets/administracion/css/vendor/bootstrap.css',
		'resources/assets/administracion/css/vendor/jquery-ui.css',
		'resources/assets/administracion/css/custom/app.css',
	], 'public/administracion/app.css')
	.options({
		processCssUrls: true
	});


//js
mix.scripts([

	'resources/assets/administracion/js/vendor/jquery-3.2.1.js',
	'resources/assets/administracion/js/vendor/tether.js',
	'resources/assets/administracion/js/vendor/popper.js',
	'resources/assets/administracion/js/vendor/bootstrap.js',
	'resources/assets/administracion/js/vendor/jquery-ui.js',
	'resources/assets/administracion/js/vendor/sweetalert.min.js',
	'resources/assets/administracion/js/vendor/jquery.repeater.js',

	'public/vendor/jsvalidation/js/jsvalidation.js',
	'resources/assets/administracion/js/custom/Form.js',
	'resources/assets/administracion/js/custom/Fecha.js',
	'resources/assets/administracion/js/custom/Modal.js',
	'resources/assets/administracion/js/custom/Validador.js',
	'resources/assets/administracion/js/custom/JMap.js',
	'resources/assets/administracion/js/custom/CuponDescuento.js',

	'resources/assets/administracion/js/custom/app.js',

], 'public/administracion/app.js');



// Optimizar imagenes con MozJPG (progresivo)
mix.webpackConfig({
	plugins: [
		new CopyWebpackPlugin([{
			from: 'resources/assets/administracion/img',
			to: 'administracion/img',
		}]),
		new ImageminPlugin({
			test: /\.(jpe?g|png|gif|svg)$/i,
			plugins: [
				imageminMozjpeg({
					quality: 80,
				})
			]
		})
	]
});

*/

//ADMINISTRACION: FIN
