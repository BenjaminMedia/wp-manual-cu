<?php

namespace BonnierBannerGroup;

use BonnierBannerPlugin\Banner;

Class BannerGroup
{
    private $html_code;
    private $type;
    private $bannerGroupTypes = [
        'banner_group',
        'horseshoe'
    ];

    public function __construct($name, $contentUnits, $type = 'banner_group', $sticky = false)
    {
        $this->html_code = '';
        $this->type = $type;
        $this->html_code .= $this->generateBannerCode($contentUnits, $type);
    }

    private function generateBannerCode($contentUnits, $type)
    {
        if (isset($type, $this->bannerGroupTypes)) {
            if ($type == 'horseshoe') {
                $horseshoe = '';
                $headerBanners = '';
                foreach ($contentUnits['banners'] as $breakpoint => $cu) {
                    $headerBanners .= Banner::htmlCodeFromProps($cu, $breakpoint, 'banner');
                }
                $left = Banner::htmlCodeFromProps($contentUnits['left']['side'], null, 'sidebanner', false);
                $leftSticky = Banner::htmlCodeFromProps($contentUnits['left']['sticky'], null, 'sidebanner', true);
                $right = Banner::htmlCodeFromProps($contentUnits['right']['side'], null, 'sidebanner', false);
                $rightSticky = Banner::htmlCodeFromProps($contentUnits['right']['sticky'], null, 'sidebanner', true);
                $wallpaper = Banner::htmlCodeFromProps($contentUnits['wallpaper'], 'lg', 'wallpaper', false);

                $horseshoe =
                    "
                    $wallpaper
                    <div class='horseshoe' data-banner-horseshoe>
                      <div class='horseshoe-container'>
                        <div class='side-banner banner-left visible-md-lg' data-banner-md-lg>
                          $left
                          $leftSticky
                        </div>

                        <div class='top-banner' data-top-banner>
                          $headerBanners
                        </div>

                        <div class='side-banner banner-right visible-md-lg' data-banner-md-lg>
                          $right
                          $rightSticky
                        </div>
                      </div>
                    </div>";
                return $horseshoe;
            }
            if ($type == 'banner_group') {
                $bannerCode = '';
                foreach ($contentUnits['banners'] as $breakpoint => $cu) {
                    (isset($cu)) ? $bannerCode .= Banner::htmlCodeFromProps($cu, $breakpoint, 'banner') : '';
                }
                return $bannerCode;
            }
        }
        return null;
    }

    public function getHtmlCode()
    {
        return $this->html_code;
    }

    public static function htmlCodeFromProps($name, $contentUnits, $type = 'banner_group', $sticky = false){
        $self = new self($name, $contentUnits, $type, $sticky);
        return $self->getHtmlCode();
    }
}