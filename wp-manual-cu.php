<?php
/*
Plugin Name: WordPress Manual Content Units
Plugin URI: https://github.com/BenjaminMedia/wp-manual-cu
Description: Plugin that allows you to manually add Specific Content Units to WordPress
Author: Frederik Rabøl & Alf Henderson
Version: 0.5
Author URI: http://rabol.co
*/

$publicFolder = plugin_dir_url( __FILE__ ) . 'public';

const HOOK_DEFAULT_MIDDLE = 'alienship_post_after';
const HOOK_DEFAULT_TOP_STICKY = 'genesis_before_header';

function getOptionOrDefault($option, $defaultValue = NULL) {
    $themeHook = get_option('wp-manual-cu-' . $option, NULL );
    return (empty($themeHook)) ? $defaultValue : $themeHook;
}

function add_middle_banners() {
    $desktopMiddle = get_option('wp-manual-cu-desktop-middle', NULL);
    $tabletMiddle = get_option('wp-manual-cu-tablet-middle', NULL);
    $mobileMiddle = get_option('wp-manual-cu-mobile-middle', NULL);

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
	";

    echo $output;
}

function add_sticky_top_banners() {

    global $publicFolder;

    $sidebannerLeft = getOptionOrDefault('sidebanner-left');
    $sidebannerRight = getOptionOrDefault('sidebanner-right');

    $stickyLeft = getOptionOrDefault('sticky-left');
    $stickyRight = getOptionOrDefault('sticky-right');

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

                <div class="static fixed" data-listen="sticky-banner">
                    <div class="banner-min-height banner gtm-banner">
                        <div id="EAS_fif_$stickyLeft"></div>
                        <script>
                            EAS_load_fif("EAS_fif_$stickyLeft", "$publicFolder/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=$stickyLeft;cre=mu;js=y;pageviewid=;target=_blank", 320, 150);
                        </script>
                    </div>
                </div>
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
                <div class="static fixed" data-listen="sticky-banner">
                    <div class="banner-min-height banner gtm-banner">
                        <div id="EAS_fif_$stickyRight"></div>
                        <script>
                            EAS_load_fif("EAS_fif_$stickyRight", "$publicFolder/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=$stickyRight;cre=mu;js=y;pageviewid=;target=_blank", 320, 150);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;

    echo $output;
}

// Add hooks
add_action('admin_menu', 'mcu_add_pages');
add_action(getOptionOrDefault('theme-hook-middle', HOOK_DEFAULT_MIDDLE), 'add_middle_banners');
add_action(getOptionOrDefault('theme-hook-sticky-top', HOOK_DEFAULT_TOP_STICKY), 'add_sticky_top_banners');


add_action('wp_enqueue_scripts', function() {
    global $publicFolder;

    wp_enqueue_style('wa-manual-cu-css', $publicFolder . '/css/wa-manual-cu.css');

    wp_enqueue_script('EAS-fif', $publicFolder . '/js/EAS_fif.js');
    //wp_enqueue_script('sticky-banners', $publicFolder . '/js/cu-sticky-banner.js');
    wp_enqueue_script('wa-manual-cu-js', $publicFolder . '/js/wa-manual-cu.js');
}, 999);

// action function for above hook
function mcu_add_pages() {
    // Add a new submenu under Settings:
	add_options_page('Manual Content Units', 'Manage Content Units', 'manage_options', 'mcu_settings', 'mcu_settings_page');
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
    $stickyTopHook = getOptionOrDefault('theme-hook-sticky-top', HOOK_DEFAULT_TOP_STICKY);


	$desktopMiddle = get_option( 'wp-manual-cu-desktop-middle', NULL );
	$tabletMiddle = get_option( 'wp-manual-cu-tablet-middle', NULL );
	$mobileMiddle = get_option( 'wp-manual-cu-mobile-middle', NULL );

    $desktopTop = get_option( 'wp-manual-cu-desktop-top', NULL );
    $tabletTop = get_option( 'wp-manual-cu-tablet-top', NULL );
    $mobileTop = get_option( 'wp-manual-cu-mobile-top', NULL );

    $sidebannerLeft = get_option( 'wp-manual-cu-sidebanner-left', NULL );
    $sidebannerRight = get_option( 'wp-manual-cu-sidebanner-right', NULL );

    $stickyRight = get_option( 'wp-manual-cu-sticky-right', NULL );
    $stickyLeft = get_option( 'wp-manual-cu-sticky-left', NULL );

	wp_enqueue_style( 'AdminBootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array(), '', 'all' );

    $form = <<< HTML
	<div class="container">
		<div class="row">
		    <div class="col-xs-12">
            <h2>Manage Content Units</h2>

			<form method="post" action=''>
			    <h3>Middle banners</h3>
			    <p>
			        Middle Content Units (between each blog post)
			    </p>

				<label for="theme-hook">Hook</label>

				<input type="text" class="form-control form-group" placeholder="Leave blank if you don't know what this is" value="$middleHook" name="theme-hook-middle" />

				<label for='dekstop-middle'>Desktop middle (930x180_Top)</label>
				<input type='text' class='form-control form-group' placeholder='Desktop (930x180) Midt' value='$desktopMiddle' name='desktop-middle' />
				<label for='tablet-middle'>Tablet middle (930x180_midt)</label>
				<input type='text' class='form-control form-group' placeholder='Tablet (728x90) Midt' value='$tabletMiddle' name='tablet-middle' />
				<label for='mobile-middle'>Mobile middle (320x300_midt)</label>
				<input type='text' class='form-control form-group' placeholder='Mobile (320x300) Midt' value='$mobileMiddle' name='mobile-middle' />

				<h3>Horseshoe banners</h3>

				<p>
			        Sticky/top banners description
			    </p>

                <label for="theme-hook">Hook</label>
				<input type="text" class="form-control form-group" placeholder="Hook for executing sticky/top banners" value="$stickyTopHook" name="theme-hook-sticky-top" />

				<label for='mobile-middle'>Desktop top (930x180_top)</label>
				<input type='text' class='form-control form-group' placeholder='Desktop (320x300) top' value='$desktopTop' name='desktop-top' />

				<label for='mobile-middle'>Tablet top (930x180_top)</label>
				<input type='text' class='form-control form-group' placeholder='Tablet (930x180) top' value='$tabletTop' name='tablet-top' />

				<label for='mobile-middle'>Mobile top (320x300_top)</label>
				<input type='text' class='form-control form-group' placeholder='Desktop (320x300) top' value='$mobileTop' name='mobile-top' />

				<label for='mobile-middle'>Left (160x600)</label>
				<input type='text' class='form-control form-group' placeholder='Sidebanner left (160x600) Venstre' value='$sidebannerLeft' name='sidebanner-left' />

                <label for='mobile-middle'>Right (160x600)</label>
				<input type='text' class='form-control form-group' placeholder='Sidebanner right (160x600) Venstre' value='$sidebannerRight' name='sidebanner-right' />

                <label for='mobile-middle'>Sticky left (160x600)</label>
				<input type='text' class='form-control form-group' placeholder='Sticky (160x600) Højre' value='$stickyLeft' name='sticky-left' />

				<label for='mobile-middle'>Sticky right (160x600)</label>
				<input type='text' class='form-control form-group' placeholder='Sticky (160x600) Højre' value='$stickyRight' name='sticky-right' />

				<hr />
				<input type='submit' name='submit' value='Save' class='btn btn-primary pull-right' />
			</form>
			</div>
		</div>
	</div>
HTML;

	echo $form;
}
