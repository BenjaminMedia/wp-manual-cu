<?php 
/*
Plugin Name: WordPress Manual Content Units
Plugin URI: https://github.com/BenjaminMedia/wp-manual-cu
Description: a plugin that allows you to manually add Specific Content Units to WordPress
Author: Frederik Rabøl
Version: 0.5
Author URI: http://rabol.co
*/

// Hook for adding admin menus
add_action('admin_menu', 'mcu_add_pages');

// action function for above hook
function mcu_add_pages() {
    // Add a new submenu under Settings:
	add_options_page('Manual Content Units', 'Manage Content Units', 'manage_options', 'mcu_settings', 'mcu_settings_page');


}
//settings page
function mcu_settings_page() {


	//var_dump($_POST);

	foreach ($_POST as $key => $value) {
		if ($key != 'submit'){
			update_option('wp-manual-cu-'.$key, $value, TRUE);
		}

	}


	$desktopTop = get_option( 'wp-manual-cu-desktop-top', true );
	$desktopMiddle = get_option( 'wp-manual-cu-desktop-middle', true );
	$desktopBottom = get_option( 'wp-manual-cu-desktop-bottom', true );

	$tabletTop = get_option( 'wp-manual-cu-tablet-top', true );
	$tabletMiddle = get_option( 'wp-manual-cu-tablet-middle', true );
	$tabletBottom = get_option( 'wp-manual-cu-tablet-bottom', true );

	$mobileTop = get_option( 'wp-manual-cu-mobile-top', true );
	$mobileMiddle = get_option( 'wp-manual-cu-mobile-middle', true );
	$mobileBottom = get_option( 'wp-manual-cu-mobile-bottom', true );

	wp_enqueue_style( 'AdminBootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array(), '', 'all' );
	
		$form = "
	<div class='container'>
		<div class='row'>
			<div class='col-xs-12'>
				<h2>Manage Content Units</h2>
			</div>
			<form method='post' action=''> 
			<div class='col-sm-4'>
				<label>Top Content Units</label>
				<br /> 
				<input type='text' class='form-control form-group' placeholder='Desktop (930x180) Top' value='$desktopTop' name='desktop-top' />
				<input type='text' class='form-control form-group' placeholder='Tablet (728x90) Top' value='$tabletTop' name='tablet-top' />
				<input type='text' class='form-control form-group' placeholder='Mobile (320x300) Top' value='$mobileTop' name='mobile-top' />
			</div>
			<div class='col-sm-4'>
				<label>Middle Content Units</label>
				<br />
				<input type='text' class='form-control form-group' placeholder='Desktop (930x180) Midt' value='$desktopMiddle' name='desktop-middle' />
				<input type='text' class='form-control form-group' placeholder='Tablet (728x90) Midt' value='$tabletMiddle' name='tablet-middle' />
				<input type='text' class='form-control' placeholder='Mobile (320x300) Midt' value='$mobileMiddle' name='mobile-middle' />
			</div>
			<div class='col-sm-4'>
				<label>Bottom Content Units</label>
				<br />
				<input type='text' class='form-control form-group' placeholder='Desktop (930x180) Bottom' value='$desktopBottom' name='desktop-bottom'  />
				<input type='text' class='form-control form-group' placeholder='Tablet (728x90) Bottom' value='$tabletBottom' name='tablet-bottom' />
				<input type='text' class='form-control form-group' placeholder='Mobile (320x300) Bottom' value='$mobileBottom' name='mobile-bottom' />
			</div>
			<div class='col-xs-12'>
				
				<hr />
				<input type='submit' name='submit' value='Save' />
				 
			</div>
			</form>
		</div>
	</div>
	";

	echo $form;
	echo get_option( 'wp-manual-cu-desktop-top', true );
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
