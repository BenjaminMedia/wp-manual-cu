var gulp = require('gulp');
var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.coffee([
    	'banner_loader.coffee',
    	'detect_breakpoints.coffee'
	],'public/js/banners.js');
});