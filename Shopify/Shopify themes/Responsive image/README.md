# Responsive Image Snippet

## Purpose
This file is a Shopify Liquid snippet designed to display responsive images. It handles both desktop and mobile image sources, generating appropriate `srcset` and `sizes` attributes for responsive image loading.

## Key Features
- **Dynamic Image Assignment:** Supports both desktop and mobile images.
- **Responsive `srcset` and `sizes`:** Generates `srcset` and `sizes` attributes for responsive images.
- **Fallback Defaults:** Uses default values for various attributes if not provided.
- **Picture Element:** Utilizes the `<picture>` element for handling different image sources based on screen size.

## Important Sections
- **Dynamic Variable Assignment:**
  ```liquid
  {% liquid
    assign image = image
    assign image_mobile = image_mobile

    assign width = width | default: image.width
    assign height = height | default: image.height

    assign alt_text = alt_text | default: image.alt

    assign aria_label = aria_label
    assign fetchpriority = fetchpriority | default: "auto"
    assign loading = loading
    assign class = class | default: ""
    assign container_minus_paddings = settings.page_width | minus: 32
    assign container_plus_space = settings.page_width | plus: 32
    assign default_sizes = "(max-width: SIMPLE_CONTAINERpx) calc(100vw - 32px), (min-width: CONTAINERpx) CONTAINERwPADDINGSpx, CONTAINERwPADDINGSpx" | replace: "SIMPLE_CONTAINER", settings.page_width | replace: "CONTAINERwPADDINGS", container_minus_paddings | replace: "CONTAINER", container_plus_space
    assign sizes = sizes | default: default_sizes

    assign srcset = srcset | default: "320, 480, 576, 768, 992, 1024, 1220, 1440, 1680, 1920, 2000, 2180"
    assign srcset_mobile = srcset_mobile | default: "320, 480, 576, 768"

    assign srcset_array = srcset | split: ","
    assign srcset_mobile_array = srcset_mobile | split: ","
    assign srcset_string = ""
    assign srcset_mobile_string = ""
  %}
