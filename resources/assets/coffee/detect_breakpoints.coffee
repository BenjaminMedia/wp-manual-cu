(($) ->

  Breakpoint = (element, options) ->
    # make the options variables available globally within the module
    @options = $.extend({}, Breakpoint.DEFAULTS, options)
    @bindEvent()
    return

  #Plugin defaults
  Breakpoint.DEFAULTS =
    xs: 480
    sm: 768
    md: 1025
    lg: 1200

  Breakpoint::bindEvent = ->
    #Use var self if necessary to manage this-references
    self = this
    breakpoint = 'xs'
    breakpoint = self.detect($(window).width())
    breakpoint

  Breakpoint::detect = (width) ->
    o = @options
    if o.lg <= width
      return 'lg'
    if o.md <= width and o.lg >= width
      return 'md'
    if o.sm <= width and o.md > width
      return 'sm'
    if o.sm > width
      return 'xs'
    return

  #Omits fn so that the function doesn't need to be applied to an object

  $.breakpoints = (data) ->
    $object = new Breakpoint(this)
    $object.bindEvent data

  return
) jQuery