# Index Video Banner

## Purpose
This file is a Shopify Liquid template for displaying a video banner on the index page. It supports both desktop and mobile video configurations, including YouTube, Vimeo, and HTML5 video formats.

## Key Features
- **Stylesheet Inclusion:** The `index__video-banner.css` stylesheet is included to style the video banner.
- **Video Type and ID Assignment:** Determines the type and ID of the video based on section settings.
- **Vimeo Player API:** Includes the Vimeo player API if a Vimeo video is used.
- **Responsive Video Display:** Supports different videos for desktop and mobile, with optional cover images for both.
- **Play Button:** Displays a play button over the video, which can be an image or SVG.
- **Title and Subtitle:** Displays a title and subtitle over the video.
- **Customizable Margins:** Allows setting custom margins for both desktop and mobile views.

## Important Sections
- **Stylesheet Tag:** `{{ 'index__video-banner.css' | asset_url | stylesheet_tag }}`
- **Video Type and ID Assignment:**
  ```liquid
  if section.settings.video != blank
      assign video_type = section.settings.video.type
      assign video_id = section.settings.video.id
  elsif section.settings.video_url != blank 
      assign video_type = 'html_video'
  endif
