<?php
/*
Plugin Name: WordPress Manual Content Units
Plugin URI: https://github.com/BenjaminMedia/wp-manual-cu
Description: Plugin that allows you to manually add Specific Content Units to WordPress
Author: Frederik Rabøl & Alf Henderson
Version: 2.0
Author URI: http://www.bonnierpublications.com
*/

include_once('bannerPlugin.php');
include_once('BannerGroup.php');
include_once('Banner.php');

const HOOK_DEFAULT_MIDDLE = 'headway_after_entry_content';
const HOOK_DEFAULT_HORSESHOE = 'headway_page_start';
const HOOK_DEFAULT_FOOTER = 'headway_footer_close';

$initPlugin = new \BonnierBannerPlugin\BannerPlugin();