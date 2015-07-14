# wp-manual-cu
a plugin that allows you to manually add Specific Content Units to WordPress

##Customization

change the width of the container (width between the banners)

```css
.bonnier-banner-container.sticky {
width: 930px;
}
```

change offset from the top:

```css
.bonnier-banner-container.sticky .banner {
top: 700px;
}
```

To only change offset on the left/right:

```css
.bonnier-banner-container.sticky .left .banner {
   top: 200px;
}
```

##Shortcode
If you want to manually add a banners somewhere, you can use the shortcode.

```html
[banner sticky="true" cu="xxxxxx" offset="" parent-container=""]
```
sticky = (bool) If set to true, the banner will remain on screen while scrolling
cu = Content Unit number
offset = top Offset in pixels where the banner will start to be sticky (default = calculates the offset itself)
parent-container = container which the sticky banner will scroll inside
