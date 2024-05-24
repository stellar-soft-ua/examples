# Blog Articles Display

## Purpose
This file is a Shopify Liquid template responsible for rendering blog articles on a Shopify store. It handles the display of article metadata, images, content, and various blog-related functionalities such as pagination, comments, and social sharing.

## Key Features
- **Stylesheet Inclusion:** The `section-blog-post.css` stylesheet is included to style the blog section.
- **JSON Data Generation:** A script generates a JSON object containing article data, which includes:
    - Article URL, creation date, tags, summary, image, title, and ID.
    - Meta fields such as custom read time if available.
- **Article Display:** The main article content is displayed within a structured layout, including:
    - Featured image with responsive sizes.
    - Title with optional publication date and author.
    - Main content and social sharing options.
    - Back to blog link and comment section if comments are enabled.
- **Sidebar:** Includes various sidebar components such as categories, search, and archive.
- **SEO and Structured Data:** JSON-LD structured data is included for SEO purposes, defining the article as a `BlogPosting` for search engines.
- **Responsive Video Embedding:** Ensures embedded YouTube videos are responsive.

## Important Sections
- **Stylesheet Tag:** `{{ 'section-blog-post.css' | asset_url | stylesheet_tag }}`
- **JSON Data Script:** Generates a JSON object with article data for dynamic content loading.
- **Article Blocks:** Handles different types of article content blocks such as featured image, title, content, social share, and signup form.
- **Comment Form:** Includes a form for posting comments, with validation and error handling.
- **Structured Data Script:** Provides SEO metadata using JSON-LD.