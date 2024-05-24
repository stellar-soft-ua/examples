# Product Size Guide

## Purpose
This file is a Shopify Liquid template for displaying a size guide on product pages. It supports different size guides for underwear and bras, dynamically pulling data from Shopify metafields.

## Key Features
- **Stylesheet and Script Inclusion:** Includes the `product-size-guide.min.css` stylesheet and `size-guide.js` script for styling and functionality.
- **Metafield Data Assignment:** Retrieves size guide data from Shopify metafields.
- **Dynamic Content Generation:** Creates size guide tables based on metafield data for underwear and bras.
- **Responsive Design:** Ensures the size guide is responsive and adapts to different screen sizes.
- **Interactive Tabs:** Allows users to switch between underwear and bra size guides.

## Important Sections
- **Stylesheet and Script Tags:**
  ```liquid
  {{ 'product-size-guide.min.css' | asset_url | stylesheet_tag }}
  <script src="{{ 'size-guide.js' | asset_url }}" defer="defer"></script>
