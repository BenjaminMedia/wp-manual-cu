<?php

namespace Banner;

class Banner
{
    private $breakpoint;
    private $cu;
    private $type;
    private $code;


    public static function getBannerBreakpoints() {
        return [
        'lg' => 'md-lg',
        'md' => 'md-lg',
        'sm' => 'sm',
        'xs' => 'xs',
        ];
    }
    private $bannerBreakpoints;

    private $bannerTypes = [
        'banner',
        'sidebar',
        'basic',
        'wallpaper'
    ];

    public function getCode()
    {
        return $this->code;
    }

    public function __construct($contentUnit,$breakpoint = null,$type,$sticky = false){
        $this->bannerBreakpoints = self::getBannerBreakpoints();
        if(isset($contentUnit)){
            $this->code = $this->createBannerCode($contentUnit,$breakpoint,$type,$sticky);
        }
    }

    private function createBannerCode($cu,$breakpoint,$type,$sticky,$offset = 0){
        $wallpaperBanner = ($type == 'wallpaper')?'data-wallpaper-banner':'';
        if(isset($type,$this->bannerTypes)){
            if(($type == ('banner' || 'wallpaper')) && isset($breakpoint, $this->bannerBreakpoints)){
                return '<div class="banner visible-'.$this->bannerBreakpoints[$breakpoint].' gtm-banner" data-banner-'.$this->bannerBreakpoints[$breakpoint].' '.$wallpaperBanner.'>
                        <div class="banner-min-height banner gtm-banner" data-banner-code='.$cu.' data-banner-target="true"></div>
                    </div>';
            }
            if($type == 'sidebanner'){
                $stickyAttr = ($sticky)?'class="fixed text-center static" data-listen="sticky-banner"':'class="absolute text-center"';
                $offset = 'data-offset="'.$offset.'"';
                $banner = <<<HTML
                        <div $stickyAttr $offset>
                            <div class="banner-min-height banner gtm-banner" data-banner-code="$cu" data-banner-target="true" id="banner-$cu"></div>
                        </div>
HTML;
                ;
                return $banner;
            }
            if($type == 'basic'){
                return '<div class="" data-banner-code='.$cu.' data-banner-target="true"></div>';
            }
        }
        return null;
    }
}