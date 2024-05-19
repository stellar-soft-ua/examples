# SizedImage Custom Element

## Purpose
The `SizedImage` custom element provides a way to render responsive images with dynamically calculated `srcset` and `sizes` attributes for optimized image loading based on different screen sizes.

## Key Features
- **Responsive Images:** Automatically generates `srcset` and `sizes` attributes for responsive image loading.
- **Shadow DOM:** Uses Shadow DOM to encapsulate styles and markup.
- **Custom Attributes:** Supports custom attributes for image source, alternative text, dimensions, and additional classes.
- **Lazy Loading:** Images are loaded lazily to improve page performance.

## Attributes
- `src` (string): The source URL of the image.
- `alt` (string): The alternative text for the image.
- `src-widths` (JSON string): A JSON string representing an object with breakpoint keys and width values.
- `height` (string): The height of the image.
- `width` (string): The width of the image.
- `classes` (string): Additional CSS classes to apply to the image element.

## Example Usage
```html
<sized-image
  src="https://example.com/image.jpg"
  alt="A descriptive alt text"
  src-widths='{"sm": 320, "md": 640, "lg": 960}'
  height="auto"
  width="100%"
  classes="custom-class"
></sized-image>
