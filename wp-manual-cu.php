<?php
/*
Plugin Name: WordPress Manual Content Units
Plugin URI: https://github.com/BenjaminMedia/wp-manual-cu
Description: Plugin that allows you to manually add Specific Content Units to WordPress
Author: Simon Sessingø (Frederik Rabøl & Alf Henderson er kærester)
Version: 1.0
Author URI: http://www.bonnier.dk
*/

$publicFolder = plugin_dir_url( __FILE__ ) . 'public';

const HOOK_DEFAULT_MIDDLE = 'alienship_post_after';
const HOOK_DEFAULT_HORSESHOE = 'genesis_before_header';
const HOOK_DEFAULT_FOOTER = 'wp_footer';

// Enable shortcodes in widget-text
add_filter('widget_text', 'do_shortcode');

//[foobar]
function insert_banner($attrs) {
    $a = shortcode_atts( array(
        'cu' => NULL,
        'sticky' => FALSE,
        'container' => ''
    ), $attrs );

    $cu = $a['cu'];
    $isSticky = ($a['sticky']) ? ' data-listen="sticky-banner" data-container="'. $a['container'] .'"' : '';

    if(!is_null($cu)) {
        $output = <<<HTML
<div class="bonnier-banner-container">
    <div class="banner"$isSticky>
        <script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$cu;cre=mu;js=y;pageviewid=;target=_blank'></script>
    </div>
</div>
HTML;
        return $output;
    }

    return '';
}
add_shortcode('banner', 'insert_banner');


// Add hooks
add_action('admin_menu', function() {
    // Add a new submenu under Settings:
    add_options_page('Manual Content Units', 'Manage Content Units', 'manage_options', 'mcu_settings', 'mcu_settings_page');
});

add_action(getOptionOrDefault('theme-hook-middle', HOOK_DEFAULT_MIDDLE), 'add_middle_banners');
add_action(getOptionOrDefault('theme-hook-horseshoe', HOOK_DEFAULT_HORSESHOE), 'add_horseshoe_banners');
add_action(getOptionOrDefault('theme-hook-footer', HOOK_DEFAULT_FOOTER), 'add_footer_banners');

/**
 * Get option from Wordpress or default value
 * @param $option
 * @param null $defaultValue
 * @return mixed|null|void
 */
function getOptionOrDefault($option, $defaultValue = NULL) {
    $themeHook = get_option('wp-manual-cu-' . $option, NULL );
    return (empty($themeHook)) ? $defaultValue : $themeHook;
}

// Add scripts and styles
add_action('wp_enqueue_scripts', function() {
    global $publicFolder;

    wp_enqueue_style('wa-manual-cu-css', $publicFolder . '/css/wa-manual-cu.css');
    wp_enqueue_script('EAS-fif', $publicFolder . '/js/EAS_fif.js');
    wp_enqueue_script('wa-manual-cu-js', $publicFolder . '/js/wa-manual-cu.js');
}, 999);



function add_footer_banners() {
    $footerMobile = getOptionOrDefault('desktop-footer');
    $footerTablet = getOptionOrDefault('tablet-footer');
    $footerDesktop = getOptionOrDefault('mobile-footer');

    $output = <<<HTML
<div class="bonnier-wrapper">
    <div class='banner visible-md visible-lg'>
        <script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$footerDesktop;cre=mu;js=y;pageviewid=;target=_blank'></script>
    </div>
    <div class='banner visible-sm'>
        <script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$footerTablet;cre=mu;js=y;pageviewid=;target=_blank'></script>
    </div>
    <div class='banner visible-xs'>
        <script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$footerMobile;cre=mu;js=y;pageviewid=;target=_blank'></script>
    </div>
</div>
HTML;

    echo $output;
}

function add_middle_banners() {
    $desktopMiddle = getOptionOrDefault('desktop-middle');
    $tabletMiddle = getOptionOrDefault('tablet-middle');
    $mobileMiddle = getOptionOrDefault('mobile-middle');

    $output = <<<HTML
<div class="bonnier-wrapper">
    <div class='banner visible-md visible-lg'>
        <script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$desktopMiddle;cre=mu;js=y;pageviewid=;target=_blank'></script>
    </div>
    <div class='banner visible-sm'>
        <script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$tabletMiddle;cre=mu;js=y;pageviewid=;target=_blank'></script>
    </div>
    <div class='banner visible-xs'>
        <script type='text/javascript' src='http://eas4.emediate.eu/eas?cu=$mobileMiddle;cre=mu;js=y;pageviewid=;target=_blank'></script>
    </div>
</div>
HTML;

    echo $output;
}

function add_horseshoe_banners() {
    global $publicFolder;

    $sidebannerLeft = getOptionOrDefault('sidebanner-left');
    $sidebannerRight = getOptionOrDefault('sidebanner-right');

    $desktopTop = getOptionOrDefault('desktop-top');
    $tabletTop = getOptionOrDefault('tablet-top');
    $mobileTop = getOptionOrDefault('mobile-top');

    $output = <<<HTML
<div class="bonnier-wrapper">
    <div class="horseshoe" data-banner-horseshoe>
        <div class="horseshoe-container">
            <div class="side-banner banner-left visible-md-lg" data-banner-md-lg>
                <div id="EAS_fif_$sidebannerLeft"></div>
                <script>
                    EAS_load_fif("EAS_fif_$sidebannerLeft", "$publicFolder/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=$sidebannerLeft;cre=mu;js=y;pageviewid=;target=_blank", 240, 600);
                </script>
            </div>

            <div class="top-banner" data-top-banner>
                <div class="banner visible-md-lg gtm-banner" data-banner-md-lg>
                    <div id="EAS_fif_$desktopTop"></div>
                    <script>
                        EAS_load_fif("EAS_fif_$desktopTop", "$publicFolder/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=$desktopTop;cre=mu;js=y;pageviewid=;target=_blank", 980, 150);
                    </script>
                </div>
                <div class="banner visible-sm gtm-banner" data-banner-sm>
                    <div id="EAS_fif_$tabletTop"></div>
                    <script>
                        EAS_load_fif("EAS_fif_$tabletTop", "$publicFolder/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=$tabletTop;cre=mu;js=y;pageviewid=;target=_blank", 728, 150);
                    </script>
                </div>
                <div class="banner visible-xs gtm-banner" data-banner-xs>
                    <div id="EAS_fif_$mobileTop"></div>
                    <script>
                        EAS_load_fif("EAS_fif_$mobileTop", "$publicFolder/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=$mobileTop;cre=mu;js=y;pageviewid=;target=_blank", 320, 150);
                    </script>
                </div>
            </div>

            <div class="side-banner banner-right visible-md-lg gtm-banner" data-banner-md-lg>
                <div id="EAS_fif_$sidebannerRight"></div>
                <script>
                    EAS_load_fif("EAS_fif_$sidebannerRight", "$publicFolder/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=$sidebannerRight;cre=mu;js=y;pageviewid=;target=_blank", 240, 600);
                </script>
            </div>
        </div>
    </div>
</div>
HTML;

    echo $output;
}

//settings page
function mcu_settings_page() {
	if (count($_POST) >= 1) {
		echo"<div class='updated'> <p>Updated settings</p></div>";

        foreach ($_POST as $key => $value) {
            if ($key != 'submit'){
                update_option('wp-manual-cu-'.$key, $value, TRUE);
            }
        }
	}

    $middleHook = getOptionOrDefault('theme-hook-middle', HOOK_DEFAULT_MIDDLE);
    $horseshoeHook = getOptionOrDefault('theme-hook-horseshoe', HOOK_DEFAULT_HORSESHOE);
    $footerHook = getOptionOrDefault('theme-hook-footer', HOOK_DEFAULT_FOOTER);


	$desktopMiddle = getOptionOrDefault('desktop-middle', NULL);
	$tabletMiddle = getOptionOrDefault('tablet-middle', NULL);
	$mobileMiddle = getOptionOrDefault('mobile-middle', NULL);

    $desktopTop = getOptionOrDefault('desktop-top', NULL);
    $tabletTop = getOptionOrDefault('tablet-top', NULL);
    $mobileTop = getOptionOrDefault('mobile-top', NULL);

    $sidebannerLeft = getOptionOrDefault('sidebanner-left', NULL);
    $sidebannerRight = getOptionOrDefault('sidebanner-right', NULL);

    $desktopFooter = getOptionOrDefault('desktop-footer', NULL);
    $tabletFooter = getOptionOrDefault('tablet-footer', NULL);
    $mobileFooter = getOptionOrDefault('mobile-footer', NULL);

	wp_enqueue_style( 'AdminBootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array(), '', 'all' );

    $form = <<< HTML
    <style>
        html { background-color: #FFF;}
        .padding-t { padding-top: 30px; }
        .padding-b { padding-bottom: 20px; }
    </style>
	<div class="container">
		<div class="row">
		    <div class="col-xs-12">
            <!--<h2>Manage Content Units</h2> -->

			<form method="post" action=''>
				<h3 class="padding-t">Horseshoe banners</h3>

				<p class="padding-b">
			        Content units that will be displayed in the horseshoe (top of the page).
			    </p>

                <label for="theme-hook">Hook</label>
				<input type="text" class="form-control form-group" placeholder="Hook for outputting the horseshoe" value="$horseshoeHook" name="theme-hook-horseshoe" />

				<label for="mobile-middle" class="padding-t">Desktop top</label>
				<input type="text" class="form-control form-group" placeholder="Desktop" value="$desktopTop" name="desktop-top" />

				<label for="mobile-middle">Tablet top</label>
				<input type="text" class="form-control form-group" placeholder="Tablet" value='$tabletTop' name="tablet-top" />

				<label for='mobile-middle'>Mobile top</label>
				<input type='text' class='form-control form-group' placeholder='Mobile' value='$mobileTop' name='mobile-top' />

				<label for='mobile-middle' class="padding-t">Left</label>
				<input type='text' class='form-control form-group' placeholder='Sidebanner left' value='$sidebannerLeft' name='sidebanner-left' />

                <label for='mobile-middle'>Right</label>
				<input type='text' class='form-control form-group' placeholder='Sidebanner right' value='$sidebannerRight' name='sidebanner-right' />

                <h3 style="padding-top:30px;">Middle banners</h3>
			    <p style="padding-bottom:20px;">
			        Content units that will be displayed between each post.
			    </p>

				<label for="theme-hook">Hook</label>

				<input type="text" class="form-control form-group" placeholder="Hook for executing middle bannerts" value="$middleHook" name="theme-hook-middle" />

				<label for='dekstop-middle' class=padding-t>Desktop middle</label>
				<input type='text' class='form-control form-group' placeholder='Desktop' value='$desktopMiddle' name='desktop-middle' />
				<label for='tablet-middle'>Tablet middle</label>
				<input type='text' class='form-control form-group' placeholder='Tablet' value='$tabletMiddle' name='tablet-middle' />
				<label for='mobile-middle'>Mobile middle</label>
				<input type='text' class='form-control form-group' placeholder='Mobile' value='$mobileMiddle' name='mobile-middle' />

                <h3 class="padding-t">Footer banners</h3>

				<p class="padding-b">
			        Content units that will be displayed in the footer
			    </p>

			    <label for="theme-hook">Hook</label>
				<input type="text" class="form-control form-group" placeholder="Hook for executing footer banners" value="$footerHook" name="theme-hook-footer" />

                <label for="mobile-middle" class="padding-t">Desktop</label>
				<input type='text' class='form-control form-group' placeholder='Desktop' value='$desktopFooter' name='desktop-footer' />

				<label for="mobile-middle">Tablet</label>
				<input type='text' class="form-control form-group" placeholder="Tablet" value="$tabletFooter" name="tablet-footer" />

				<label for="mobile-middle">Mobile top</label>
				<input type="text" class="form-control form-group" placeholder="Mobile" value="$mobileFooter" name="mobile-footer" />


				<input type='submit' name='submit' value='Save' class='btn btn-primary' style="margin-top: 30px;" />
			</form>
			</div>
		</div>
	</div>
HTML;

	echo $form;
}
