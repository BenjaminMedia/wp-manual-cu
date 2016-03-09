'use strict'
$ = jQuery

class Banners
  constructor: ->
    lazyLoadSetting        = $('meta[name="banner-lazyload"]').attr('content')
    @bannerReloadFrequency = parseInt($('meta[name="banner-reload-frequency"]').attr('content'))
    @countSlideChange      = 0
    @startTime             = Date.now()
    @savedTime             = @startTime
    @adBlockIsChecked      = false

    if lazyLoadSetting? then @lazyLoad = JSON.parse(lazyLoadSetting) else @lazyLoad = false

    @init()

  init: ->
    $(window).load =>
      @$bannerLarge      = $('[data-banner-md-lg]')
      @$bannerSmall      = $('[data-banner-sm]')
      @$bannerExtraSmall = $('[data-banner-xs]')
      @$gallery          = $('[data-init="gallery-horizontal"]')
      @uuid              = EAS_uuid() # Emediate function to get unique page id
      console.log('UUID: '+@uuid)
      @cleanDuplicatedCodes()

    if @lazyLoad
      pageReady = false

      $(window).load =>
        if $.breakpoints() is 'md' or $.breakpoints() is 'lg'
          @$gallery.find('[data-banner-target]').attr 'data-banner-target', false  # Remove gallery banners from flow

        @insertInView() # inital insertion
        pageReady = true

      $(document).on 'interval-scroll', => @insertInView() if pageReady
      $(document).on 'horizontal-gallery-slide-change', => @lazyLoadGallery() if pageReady

    else
      $(window).load => @insertAll()

  cleanDuplicatedCodes: ->
    self = @

    @findBanners().each ->
      code    = JSON.stringify $(this).data('bannerCode')
      $target = $("[data-banner-code='#{code}']")
      console.log(code)

      if $target.length > 1 and code.indexOf(',') < 0
        self.addUnderscoreIdsToDuplicates($target, code)

  addUnderscoreIdsToDuplicates: ($target, code) ->
    $target.each (index) ->
      id = index + 1
      $(this).attr 'data-banner-code', code + '_' + id

  insertInView: ->
    self = @
    scrollDistance = $(window).scrollTop() + $(window).height() + 800

    try @findBanners().each ->
      $target = $(this)

      if $target.offset().top < scrollDistance # check if banner is in view
        self.prepareBanner $target
    catch e then console.error "Unable to find any banner positions"

  insertAll: ->
    self = @

    try @findBanners().each ->
      self.prepareBanner $(this)
    catch e then console.error "Unable to find any banner positions"

  findBanners: ->
    # Goes through all banners and return banner-positions not already used
    if $.breakpoints() is 'md' or $.breakpoints() is 'lg'
      return @$bannerLarge.find('[data-banner-target]').not('[data-banner-target="false"]')
    else if $.breakpoints() is 'sm'
      return @$bannerSmall.find('[data-banner-target]').not('[data-banner-target="false"]')
    else if $.breakpoints() is 'xs'
      return @$bannerExtraSmall.find('[data-banner-target]').not('[data-banner-target="false"]')

  prepareBanner: ($target) ->
    code       = $target.data('banner-code') # get code from data attribute on banner position
    console.log(code)
    codeArray  = code.toString().split(',') # codes may be comma separated, therefore convert to array

    $target.attr 'data-banner-target', false # set taget to false to avoid being picked up again by findbanners()

    @placeIframeBanner($target, codeArray[0])
    @shiftCodeArray(codeArray)

  generateParameters: ->
    cxenseParams   = eas.hlp.getCxProfileCookieData() # Cxense params to get segmented banners
    category       = $('meta[name="banner-category"]').attr('content') # get category from meta tag (mainly for external blogs)
    url            = window.location.protocol + "//" + window.location.host + window.location.pathname

    if category? then categoryParams = "&cat=#{category}" else categoryParams = ''

    return "cre=mu&js=y&target=_blank&url=#{url}&pageviewid=#{@uuid}" + categoryParams + cxenseParams

  placeIframeBanner: ($target, code) ->
    id = "banner-#{Math.floor((Math.random() * 999999999) + 1)}"
    $target
      .attr('id', id)
      .empty() # Clear position if banner is updated
      .parent().addClass 'text-center'

    if $target.parent().data('wallpaper-banner')?
      $('body').removeAttr('style') # Clear body background image if target is wallpaper

    if code
      EAS_load_fif(id, "/emediate/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=#{code}&#{@generateParameters()}", 0, 0)
    else
      $target.hide()

    @checkIframeStatus($target, code)

  checkIframeStatus: ($target, code) ->
    $iframe  = $target.find('iframe').eq(0)

    $iframe.load =>
      $content = $iframe.contents()

      # checks if loaded banner iframe has any visible content
      if $content.find('img, a, div, canvas, object, iframe, embed')[0] or $target.children().length > 1
        $target.parent().siblings('[data-continue-reading]').show()

      else
        $target.hide()

      # Check if ad content was blocked
      unless @adBlockIsChecked
        @adBlockIsChecked = true
        if $content.find("body").html().length then @adBlockDetection(true) else @adBlockDetection(false)

  shiftCodeArray: (codeArray) ->
    # Shift code array and apply it to positions with same codes to avoid duplicates
    $target = $("[data-banner-code='#{codeArray}']")
    codeArray.shift()
    $target.attr 'data-banner-code', codeArray.join(",")

  lazyLoadGallery: ->
    @uuid = EAS_uuid() # Refresh uuid
    @$gallery.find('[data-active-slide=true] [data-banner-target]').attr 'data-banner-target', true # set gallery banner target to true on the banner inside current slide
    @insertInView() # Recheck for unloaded banner positions in view
    @updateGalleryHorseshoe()

  updateGalleryHorseshoe: ->
    if @bannerReloadFrequency
      @countSlideChange++

      # When countSlideChange matches frequency (optional in CMS): refresh banners in the horseshoe
      if @countSlideChange % @bannerReloadFrequency is 0 and @coolDown() is true and ($.breakpoints() is 'md' or $.breakpoints() is 'lg')
        @uuid = EAS_uuid() # Refresh uuid
        $('[data-banner-md-lg] [data-banner-target]').attr 'data-banner-target', true
        $('[data-top-banner] [data-banner-target]').attr 'data-banner-target', true
        $('[data-active-slide] [data-banner-target]').attr 'data-banner-target', false
        @countSlideChange = 0
        $.delay 0, => @insertInView() # pull to end of call-queue

  coolDown: ->
    # Avoid banner overheat if users click through gallery quickly
    if Date.now() - 5000 > @savedTime
      @savedTime = Date.now()
      return true

  adBlockDetection: (adsAreLoaded) ->
    if adsAreLoaded
      dataLayer.push
        'event' : 'ads-are-loaded'
        'top-banner-load-time' : Date.now() - @startTime

      console.info "Ads are loaded", Date.now() - @startTime
    else
      dataLayer.push({ 'event' : 'ads-are-blocked' })
      console.error "Ads are blocked"

window.Banners = new Banners()