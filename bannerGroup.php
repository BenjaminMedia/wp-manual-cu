<?php

namespace BannerGroup;

use Banner\Banner;

Class BannerGroup
{
    private $html_code;
    private $name;
    private $breakpoints;
    private $type;

    public function getHtmlCode(){
        return $this->html_code;
    }
    public function __construct($name,$contentUnits,$type = 'banner_group',$sticky = false)
    {
        $this->html_code = '';
        $this->type= $type;
        $this->html_code .= $this->generateBannerCode($contentUnits,$type);
    }
    private $bannerGroupTypes = [
        'banner_group',
        'horseshoe',
        'wallpaper'
    ];

    private function generateBannerCode($contentUnits,$type){
        if(isset($type,$this->bannerGroupTypes)){
            if($type == 'horseshoe'){
                $horseshoe = '';
                $headerBanners = '';
                foreach($contentUnits['banners'] as $breakpoint => $cu){
                    $banner = new Banner($cu,$breakpoint,'banner');
                    $headerBanners .= $banner->getCode();
                }

                $left = (new Banner($contentUnits['left']['side'],null,'sidebanner',false))->getCode();
                $leftSticky = (new Banner($contentUnits['left']['sticky'],null,'sidebanner',true))->getCode();
                $right = (new Banner($contentUnits['right']['side'],null,'sidebanner',false))->getCode();
                $rightSticky = (new Banner($contentUnits['right']['sticky'],null,'sidebanner',true))->getCode();

                $horseshoe = <<<HTML
                    <div class="horseshoe" data-banner-horseshoe>
                      <div class="horseshoe-container">
                        <div class="side-banner banner-left visible-md-lg" data-banner-md-lg>
                          $left
                          $leftSticky
                        </div>

                        <div class="top-banner" data-top-banner>
                          $headerBanners
                        </div>

                        <div class="side-banner banner-right visible-md-lg" data-banner-md-lg>
                          $right
                          $rightSticky
                        </div>
                      </div>
                    </div>
HTML;
                return $horseshoe;
            }
            if($type == 'banner_group'){
                $bannerCode ='';
                foreach ($contentUnits['banners'] as $breakpoint => $cu) {
                    (isset($cu))?$this->$bannerCode .= $this->generateBannerCode($type,$breakpoint,$cu):'';
                }
                return $bannerCode;
            }
        }
        return null;
    }
}