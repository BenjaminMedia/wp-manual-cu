<?php 
/*
Plugin Name: WordPress Manual Content Units
Plugin URI: https://github.com/BenjaminMedia/wp-manual-cu
Description: a plugin that allows you to manually add Specific Content Units to WordPress
Author: Frederik Rabøl & Alf Henderson
Version: 0.5
Author URI: http://rabol.co
*/

// Hook for adding admin menus
add_action('admin_menu', 'mcu_add_pages');
//add_action('wp_footer', 'mcu_add_footer_scripts');

add_action(get_option( 'wp-manual-cu-theme-hook', 'alienship_post_after'), 'mcu_add_banner_scripts');


function mcu_add_banner_scripts() {


	$desktopMiddle = get_option( 'wp-manual-cu-desktop-middle', true );
	$tabletMiddle = get_option( 'wp-manual-cu-tablet-middle', true );
	$mobileMiddle = get_option( 'wp-manual-cu-mobile-middle', true );


			

	$output =" 
			<div class='col-xs-12'>
				<div class='banner visible-md visible-lg'>
				<script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$desktopMiddle;cre=mu;js=y;pageviewid=;target=_blank'></script>
					</div>
					<div class='banner visible-sm'>
				<script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$tabletMiddle;cre=mu;js=y;pageviewid=;target=_blank'></script>
					</div>
					<div class='banner visible-xs'>
				<script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$mobileMiddle;cre=mu;js=y;pageviewid=;target=_blank'></script>
					</div>
					<div class='clearfix'></div>
				</div>
			</div>
	";

	echo $output;
}

// action function for above hook
function mcu_add_pages() {
    // Add a new submenu under Settings:
	add_options_page('Manual Content Units', 'Manage Content Units', 'manage_options', 'mcu_settings', 'mcu_settings_page');


}

//settings page
function mcu_settings_page() {


	if (count($_POST) >= 1) {
		echo"<div class='updated'> <p>Updated settings</p></div>"; 
		
	}

	foreach ($_POST as $key => $value) {
		if ($key != 'submit'){
			update_option('wp-manual-cu-'.$key, $value, TRUE);
		}

	}


	$themeHook = get_option( 'wp-manual-cu-theme-hook', true );
	$desktopMiddle = get_option( 'wp-manual-cu-desktop-middle', true );

	$tabletMiddle = get_option( 'wp-manual-cu-tablet-middle', true );

	$mobileMiddle = get_option( 'wp-manual-cu-mobile-middle', true );

	wp_enqueue_style( 'AdminBootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array(), '', 'all' );
	
		$form = "
	<div class='container'>
		<div class='row'>
			<div class='col-xs-12'>
				<h2>Manage Content Units</h2>
			</div>
			<form method='post' action=''> 
				<label for='theme-hook'>Wrapper Theme hook</label>
				<br /> 
				<input type='text' class='form-control form-group' placeholder='leave blank if you don/'t know what this is' value='$themeHook' name='theme-hook' />
				<label for='theme-hook'>Middle Content Units (between each blog post)</label>
				<br />
				<label for='dekstop-middle'>Desktop Middle (930x180_Top)</label>
				<input type='text' class='form-control form-group' placeholder='Desktop (930x180) Midt' value='$desktopMiddle' name='desktop-middle' />
				<label for='tablet-middle'>Tablet Middle (930x180_midt)</label>
				<input type='text' class='form-control form-group' placeholder='Tablet (728x90) Midt' value='$tabletMiddle' name='tablet-middle' />
				<label for='mobile-middle'>Mobile Middle (320x300_midt)</label>
				<input type='text' class='form-control' placeholder='Mobile (320x300) Midt' value='$mobileMiddle' name='mobile-middle' />			
				<hr />
				<input type='submit' name='submit' value='Save' class='btn btn-primary pull-right' />
			</form>
		</div>
	</div>
	";

	echo $form;
	//echo get_option( 'wp-manual-cu-desktop-top', true );
}

/*
function manual_cu_admin_actions() {
    add_options_page('manage_content_units',"Manual Content Units", "manage_content_units", "manual_cu_admin");
}

function manual_cu_admin(){
	//silence is golden
}

function wp_manual_cu_init()
{
	$desktop_middle = 29787;
	$tablet_middle = 33221;
	$mobile_middle = 33218;
	$html = '<div class="col-sm-12">
		<div class="banner visible-md-lg">
	<!-- "Blog_Acie_930x180_Midt" (section "Stylista.dk - Bloggere") -->
	<script type="text/javascript" src="http://eas4.emediate.eu/eas?cu='.$desktop_middle.';cre=mu;js=y;pageviewid=;target=_blank"></script>
		</div>
		<div class="banner visible-sm">
	<!-- "Blog_Acie_tablet_728x90_midt" (section "Stylista.dk - Bloggere") -->
	<script type="text/javascript" src="http://eas4.emediate.eu/eas?cu='.$tablet_middle.';cre=mu;js=y;pageviewid=;target=_blank"></script>
		</div>
		<div class="banner visible-xs">
	<!-- "Blog_Acie_mobil_320x300_midt" (section "Stylista.dk - Bloggere") -->
	<script type="text/javascript" src="http://eas4.emediate.eu/eas?cu='.$mobile_middle.';cre=mu;js=y;pageviewid=;target=_blank"></script>
		</div>
		<div class="clearfix"></div>
	</div>';
	echo $html;

}

add_action('admin_menu', 'manual_cu_admin_actions');
add_action('wp_head','wp_manual_cu_init');

*/
