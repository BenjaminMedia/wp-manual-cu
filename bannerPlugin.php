<?php

namespace BonnierBannerPlugin;

use BonnierBannerGroup\BannerGroup;

class BannerPlugin{
    private $postCount = 0;

    public function __construct(){
        $this->addHooks();
    }

    private function addHooks(){
        // Add hooks & filters
        add_filter('widget_text', 'do_shortcode');
        add_shortcode('banner', array($this,'bannerShortcode'));
        add_action('admin_menu', function() {
            // Add a new submenu item under Settings:
            add_options_page('Manual Content Units', 'Manage Content Units', 'manage_options', 'mcu_settings', array($this,'settingsPage'));
        });
        add_action($this->getOptionOrDefault('horseshoe-theme-hook',$this->getOptionOrDefault('theme-hook-horseshoe', HOOK_DEFAULT_HORSESHOE)), array($this,'headerBanners'));
        add_action($this->getOptionOrDefault('theme-hook-middle', HOOK_DEFAULT_MIDDLE), array($this,'middleBanners'));
        add_action($this->getOptionOrDefault('theme-hook-footer', HOOK_DEFAULT_FOOTER), array($this,'footerBanners'));
        add_action('wp_enqueue_scripts', function() {

            wp_enqueue_style('wa-manual-cu-css', $this->getPublicFolder() . '/css/wa-manual-cu.css');
            if ($this->getOptionOrDefault('load-eas-functions', false)) {
                wp_enqueue_script('EAS-functions', $this->getPublicFolder() . '/js/emediate-functions.js');
            }
            wp_enqueue_script('EAS-fif', $this->getPublicFolder() . '/js/EAS_fif.js');
            wp_enqueue_script('wa-manual-cu-js', $this->getPublicFolder() . '/js/banners.js');
        }, 999);
    }

    /**
     * Get option from Wordpress or default value
     * @param $option
     * @param null $defaultValue
     * @return mixed|null|void
     */
    public function getOptionOrDefault($option, $defaultValue = NULL) {
        $newHookNamespace = 'ContentUnit-';
        $oldHookNamespace = 'wp-manual-cu-';
        $themeHook = NULL;
        if(NULL !==(get_option($newHookNamespace. $option, NULL ))){
            $themeHook = get_option($newHookNamespace . $option, NULL );
        }
        else{
            $themeHook = get_option($oldHookNamespace . $option, NULL );
        }
        if( NULL === $themeHook){
            return $defaultValue;
        }
        else{
            return $themeHook;
        }
    }

    public function getPublicFolder()
    {
        return plugin_dir_url( __FILE__ ) . 'public';
    }

    public function bannerShortcode($attrs) {
        $bannerShortCodeAttributes = shortcode_atts([
            'cu' => NULL,
            'breakpoint' => 'lg',
            'sticky' => FALSE,
            'offset' => NULL,
            'container' => ''
        ], $attrs );

        return Banner::htmlCodeFromProps($bannerShortCodeAttributes['cu'],$bannerShortCodeAttributes['breakpoint'],'banner',$bannerShortCodeAttributes['sticky'],$bannerShortCodeAttributes['offset']);
    }

    public function headerBanners(){
        $sidebannerLeft = $this->getOptionOrDefault('sidebanner-left',$this->getOptionOrDefault('sidebanner-left'));
        $sidebannerRight = $this->getOptionOrDefault('sidebanner-right',$this->getOptionOrDefault('sidebanner-right'));
        $stickyLeft = $this->getOptionOrDefault('sticky-left',$this->getOptionOrDefault('left-sticky'));
        $stickyRight = $this->getOptionOrDefault('sticky-right',$this->getOptionOrDefault('right-sticky'));

        $desktopTop = $this->getOptionOrDefault('top-desktop',$this->getOptionOrDefault('desktop-top'));
        $tabletTop = $this->getOptionOrDefault('top-tablet',$this->getOptionOrDefault('tablet-top'));
        $mobileTop = $this->getOptionOrDefault('top-mobile',$this->getOptionOrDefault('mobile-top'));
        $wallpaperTop = $this->getOptionOrDefault('wallpaper-takeover-cu');

        $horseshoeBanner = BannerGroup::htmlCodeFromProps('Horseshoe Banners',[
            'banners' => [
                'lg'=>$desktopTop,
                'sm'=>$tabletTop,
                'xs'=>$mobileTop,
            ],
            'left' => [
                'side' => $sidebannerLeft,
                'sticky' => $stickyLeft
            ],
            'right' => [
                'side' => $sidebannerRight,
                'sticky' => $stickyRight
            ],
            'wallpaper' => $wallpaperTop
        ], 'horseshoe');
        echo $horseshoeBanner;
    }

    public function middleBanners(){
        $desktopMiddle = $this->getOptionOrDefault('desktop-middle');
        $tabletMiddle = $this->getOptionOrDefault('tablet-middle');
        $mobileMiddle = $this->getOptionOrDefault('mobile-middle');
        $postsBetweenBanners = $this->getOptionOrDefault('posts-between-banners', 1);
        $postsBeforeBanners = $this->getOptionOrDefault('posts-before-banners', 0);

        $maxPostsPerPage = get_option('posts_per_page');
        
        $this->postCount++;
        if($this->postCount >= $postsBeforeBanners){
            if( (($this->postCount % $postsBetweenBanners++) == 0) && ($maxPostsPerPage > $this->postCount)) {
                echo BannerGroup::htmlCodeFromProps('Middle Banners',
                    [
                        'banners' => [
                            'lg'=>$desktopMiddle,
                            'sm'=>$tabletMiddle,
                            'xs'=>$mobileMiddle,
                        ]
                    ],'banner_group');
            }
        }
    }

    public function footerBanners(){
    $footerDesktop = $this->getOptionOrDefault('desktop-footer');
    $footerTablet = $this->getOptionOrDefault('tablet-footer');
    $footerMobile = $this->getOptionOrDefault('mobile-footer');

    $footerBannerGroup = BannerGroup::htmlCodeFromProps('Footer Banners',
        [
            'banners' => [
                'lg'=>$footerDesktop,
                'sm'=>$footerTablet,
                'xs'=>$footerMobile,
            ]
        ],'banner_group');

    $output =
        "<div class='row' id='footer-banners'>
            <div class='col-sm-12'>
                $footerBannerGroup
                <div class='clearfix'></div>
            </div>
        </div>";

    echo $output;
    }

    public function settingsPage(){
        if (count($_POST) >= 1) {
            echo"<div class='updated'> <p>Updated settings</p></div>";

            foreach ($_POST as $key => $value) {
                if ($key != 'submit'){
                    update_option('ContentUnit-'.$key, $value, TRUE);
                }
            }
        }

        $HorseshoeForm = $this->generateOptionPanel('Horseshoe',[
            'title' => 'Horseshoe',
            'forms' => [
                self::generateBannerGroupForm('Horseshoe Hook','Horseshoe',[
                    'theme-hook' => 'code-fork',
                ]),
                self::generateBannerGroupForm('Horseshoe Banner Group','Top',[
                    'Desktop' => 'desktop',
                    'Tablet' => 'tablet',
                    'Mobile' => 'mobile'
                ]),
                self::generateBannerGroupForm('Side Banners','Sidebanner',[
                    'Left' => 'caret-square-o-left',
                    'Right' => 'caret-square-o-right',
                ]),
                self::generateBannerGroupForm('Sticky Banners','Sticky',[
                    'Left' => 'caret-square-o-left',
                    'Right' => 'caret-square-o-right',
                ]),
                self::generateBannerGroupForm('Wallpaper / Takeover Content Unit','Wallpaper',[
                    'takeover-cu' => 'columns',
                ])
            ]
        ]);

        $middleForm = $this->generateOptionPanel('Between Content Banners (aka. Middle)', [
            'title' => 'Middle',
            'forms' => [
                self::generateBannerGroupForm('Middle Banner Hook','middle',[
                    'theme-hook' => 'code-fork',
                ]),
                self::generateBannerGroupForm('Middle Banner Group','middle',[
                    'Desktop' => 'desktop',
                    'Tablet' => 'tablet',
                    'Mobile' => 'mobile'
                ])
            ]
        ]);

        $footerForm = $this->generateOptionPanel('Footer Banners', [
            'title' => 'Footer',
            'forms' => [
                self::generateBannerGroupForm('Footer Banner Hook','Footer',[
                    'theme-hook' => 'code-fork',
                ]),
                self::generateBannerGroupForm('Footer Banner Group','Footer',[
                    'Desktop' => 'desktop',
                    'Tablet' => 'tablet',
                    'Mobile' => 'mobile'
                ])
            ]
        ]);

        $metaForm = $this->generateOptionPanel('General Settings', [
            'title' => 'General',
            'forms' => [
                self::generateBannerGroupForm('is this site using Shell?','load',[
                    'eas-functions' => 'columns',
                ]),
                self::generateBannerGroupForm('Posts Before first Banner','posts',[
                    'before-banners' => 'bars',
                ]),
                self::generateBannerGroupForm('Posts Between Banners','posts',[
                    'between-banners' => 'bars',
                ])
            ]
        ]);


        wp_enqueue_style( 'AdminBootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array(), '', 'all' );
        wp_enqueue_style('AdminFA','//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',array(),'');

        $form = <<< HTML
    <style>
        .padding-t { padding-top: 30px; }
        .padding-b { padding-bottom: 20px; }
        #wpwrap {background-color: #FFF;}
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Manage Content Units</h2>
            </div>
            <div class="col-xs-12">


            <form method="post" action=''>
                $HorseshoeForm
                
                $middleForm

                $footerForm

                $metaForm

                <input type='submit' name='submit' value='Save' class='btn btn-primary pull-right' style="margin-top: 30px;" />
            </form>
            </div>
        </div>
    </div>
HTML;

        echo $form;
    }

    private function generateOptionPanel($title,$array){
        $inputForms = '';
        foreach($array['forms'] as $form){
            $inputForms .= $form;
        }
        $htmlPanel =
            "<div class='panel panel-info'>
                <div class='panel-heading'>
                    <h3 class='panel-title'>'.$title.'</h3>
                </div>
                <div class='panel-body'>
                $inputForms
                </div>
            </div>";

        return $htmlPanel;
    }

    private function generateBannerGroupForm($title,$namespace,$array){

        $htmlForm = '
        <div class="col-xs-12">
            <div class="col-xs-6 col-sm-4">
                <label>'.$title.'</label>
            </div>
            <div class="col-xs-12 col-sm-8">
                <div class="form-group">'.$this->generateBannerGroupInputs($namespace,$array).'</div>
            </div>
        </div>
        ';

        return $htmlForm;
    }

    private function generateBannerGroupInputs($namespace,$array){
        $htmlDropdown = '<div class="input-group">';
        foreach($array as $key => $value){
            $htmlDropdown .= '
                <span class="input-group-addon">
                    <i class="fa fa-'.strtolower($value).'"></i>
                </span>

                <input class="form-control" name="'.strtolower($namespace).'-'.strtolower($key).'" placeholder="'.$namespace.' '.$key.'" value="'.$this->getOptionOrDefault(strtolower($namespace).'-'.strtolower($key),$this->getOptionOrDefault(strtolower($key).'-'.strtolower($namespace),NULL)).'" type="text">';
        }
        $htmlDropdown .= '</div>';

        return $htmlDropdown;
    }
}