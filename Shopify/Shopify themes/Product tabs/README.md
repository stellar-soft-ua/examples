# Product Tabs

## Purpose
This file is a Shopify Liquid template for displaying product tabs on product pages. It dynamically creates tabs based on product descriptions, metafields, and app integrations like Judge.me.

## Key Features
- **Product Upsell:** Allows setting a product for upselling within the tabs section.
- **Dynamic Tabs:** Generates tabs based on section blocks and product metafields.
- **Script Inclusion:** Includes the `product-tabs.js` script for tab functionality.
- **Responsive Design:** Ensures the tabs are responsive and adapt to different screen sizes.
- **Customizable Margins:** Allows setting custom margins for both desktop and mobile views.

## Important Sections
- **Product Upsell Assignment:**
  ```liquid
  {% if section.settings.product_upsell != blank %}
      {% assign product_upsell = section.settings.product_upsell %}
  {% else %}
      {% assign product_upsell = product %}
  {% endif %}
