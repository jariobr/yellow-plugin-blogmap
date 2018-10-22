Blogmap plugin 0.7.4
====================
Blogmap for your website.

[See demo](https://jar.io/blogmap/).   
Blogmap: https://jar.io/blogmap/page:blogmap.xml

## How to install plugin

1. [Download and install Datenstrom Yellow](https://github.com/datenstrom/yellow/).
2. [Download plugin](https://github.com/datenstrom/yellow-plugins/raw/master/zip/blogmap.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy `blogmap.zip` into your `system/plugins` folder.

To uninstall delete the [plugin files](update.ini).

## How to use a blogmap

The blogmap is available as `http://website/blogmap/` and `http://website/blogmap/page:blogmap.xml`. It's an overview of the entire website, only visible pages are included. You can add a link to the blogmap somewhere on your website. See example below.

## How to configure a blogmap

The following settings can be configured in file `system/config/config.ini`:

`BlogmapLocation` = blogmap location  
`BlogmapFileXml` = blogmap file name with XML information  
`BlogmapPaginationLimit` = number of entries to show per page 

Example:

```
BlogmapLocation: /blogmap/   
BlogmapFileXml: blogmap.xml   
BlogmapFilter: blog     
BlogmapPaginationLimit: 100    
```

## Developer

Datenstrom. [Get support](https://developers.datenstrom.se/help/support).
https://github.com/jariobr
