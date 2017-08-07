outer/edge Magento Page Module
============================================


[![Build Status](https://travis-ci.org/outeredge/magento-page-module.svg?branch=master)](https://travis-ci.org/outeredge/magento-page-module)


Advice is to override the core Magento `cms_page_view.xml` in the following location.

`app/design/frontend/[Vendor_Theme]/Magento_Cms/layout/override/base/cms_page_view.xml`

```
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="OuterEdge\Page\Block\Page" name="cms_page" template="content.phtml"/>
        </referenceContainer>
    </body>
</page>
```

http://devdocs.magento.com/guides/v2.0/frontend-dev-guide/layouts/layout-override.html