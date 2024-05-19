# Custom Page Text

## Purpose
This file is a Shopify Liquid template for displaying custom truncated text from a page. It allows for a short version of the text to be displayed with the option to expand to the full content. It also includes customizable button text and handles different ways of truncating the content.

## Key Features
- **Dynamic Text Truncation:** Truncates text based on settings, including the number of words and custom truncation text.
- **Expandable Text:** Provides an option to show the full content of the page with a button to toggle the display.
- **Customizable Button Text:** Allows setting custom text for the expand/collapse button.
- **Stylesheet and Script Inclusion:** Includes the `custom-page-text.css` stylesheet and `custom-page-text.js` script for styling and functionality.

## Important Sections
- **Dynamic Variable Assignment:**
  ```liquid
  {%- liquid 
      if section.settings.number > 0
          assign truncater = section.settings.number
      else
          assign truncater = 55
      endif
      if section.settings.short_text != blank
          assign short_text = section.settings.short_text
      elsif section.settings.page != blank and section.settings.splitter != blank and section.settings.page.content contains section.settings.splitter
          assign short_text = section.settings.page.content | split: section.settings.splitter | first | append: section.settings.truncate_text
      elsif section.settings.page != blank
          assign short_text = section.settings.page.content | truncatewords: truncater, section.settings.truncate_text
      endif
      assign pagearr = section.settings.page.content | split: ' '
      assign size = pagearr.size | times: 1
      if section.settings.btn_text != blank
          assign btn_text = section.settings.btn_text
          if section.settings.btn_text_secondary != blank
              assign btn_second_text = section.settings.btn_text_secondary
          else
              assign btn_second_text = section.settings.btn_text
          endif
      endif
  -%}
