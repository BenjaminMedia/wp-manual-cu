<?php

namespace Banner;

class Banner
{
    private $breakpoint;
    private $cu;
    private $type;
    private $code;

    private $bannerBreakpoints = [
        'lg' => 'md-lg',
        'md' => 'md-lg',
        'sm' => 'sm',
        'xs' => 'xs',
    ];

    private $bannerTypes = [
        'banner',
        'sidebar',
        'wallpaper'
    ];

    public function getCode()
    {
        return $this->code;
    }

    public function __construct($contentUnit,$breakpoint = null,$type,$sticky = false){
        if(isset($contentUnit)){
            $this->code = $this->createBannerCode($contentUnit,$breakpoint,$type,$sticky);
        }
    }

    private function createBannerCode($cu,$breakpoint,$type,$sticky){
        if(isset($type,$this->bannerTypes)){
            if($type == 'banner' && isset($breakpoint, $this->bannerBreakpoints)){
                return '<div class="banner visible-'.$this->bannerBreakpoints[$breakpoint].' gtm-banner" data-banner-'.$this->bannerBreakpoints[$breakpoint].'>
                        <div class="banner-min-height banner gtm-banner" data-banner-code='.$cu.' data-banner-target="true"></div>
                    </div>';
            }
            if($type == 'sidebanner'){
                $stickyAttr = ($sticky)?'class="fixed text-center static" data-listen="sticky-banner"':'class="absolute text-center"';
                $banner = <<<HTML
                        <div $stickyAttr>
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