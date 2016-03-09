<?php

Class BannerGroup
{
    private $content_units = [];
    private $html_code;
    private $name;
    private $breakpoints;

    public function getHtmlCode(){
        return $this->html_code;
    }
    public function __construct($contentUnits,$name)
    {
        $this->content_units = $contentUnits;
        $this->html_code = '';
        foreach ($contentUnits as $breakpoint => $cu) {
            (isset($cu))?$this->html_code .= $this->createBannerCode($breakpoint,$cu):'';
        }
    }

    private $bannerBreakpoints = [
        'lg' => 'md-lg',
        'md' => 'md-lg',
        'sm' => 'sm',
        'xs' => 'xs',
    ];

    private $bannerTypes = [
        'banner',
        'sidebanner',
        'sidebanner_sticky',
        'banner_group',
        'wallpaper'
    ];

    private function createBannerCode($breakpoint, $cu){
        if(isset($breakpoint, $this->bannerBreakpoints)){
            return '<div class="banner visible-'.$this->bannerBreakpoints[$breakpoint].' gtm-banner" data-banner-'.$this->bannerBreakpoints[$breakpoint].'>
                    <div class="banner-min-height banner gtm-banner" data-banner-code='.$cu.' data-banner-target="true"></div>
                </div>';
        }
        return null;
    }
}