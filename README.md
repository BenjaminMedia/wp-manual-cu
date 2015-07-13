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
[banner cu="xxxxxx" offset=""]
```
cu = Content Unit number
offset = top Offset on the banner in pixels