# Media Component

## Purpose
The `Media` component is a React (Preact) functional component that renders different types of media content (image, video, external video). It supports lazy loading, click handling, and different video sources including Vimeo.

## Key Features
- **Dynamic Media Rendering:** Renders images, videos, and external videos based on the `mediaContentType` prop.
- **Lazy Loading:** Supports lazy loading for images and videos to improve performance.
- **Click Handling:** Provides customizable click handling for media elements.
- **Responsive Video Controls:** Includes play/pause controls for videos.

## Props
- `mediaContentType` (string): Type of media content (`IMAGE`, `VIDEO`, `EXTERNAL_VIDEO`).
- `previewImage` (object): Preview image data for the media.
- `sources` (array): Array of source objects for videos.
- `srcWidths` (array): Array of source widths for responsive images.
- `className` (string): Additional class names for the media element.
- `parentClass` (string): Additional class names for the parent element.
- `controlClass` (string): Additional class names for video control buttons.
- `host` (string): Host of the external video (`VIMEO`).
- `onClick` (function): Click handler function for the media element.
- `lazyLoad` (boolean): Enables lazy loading for the media.
- `forceLazyLoad` (boolean): Forces lazy loading for the media.

## Example Usage
```javascript
import React from 'react';
import Media from './path/to/Media';

const ExampleComponent = () => {
  const imageProps = {
    mediaContentType: 'IMAGE',
    previewImage: { url: 'path/to/image.jpg' },
    srcWidths: [320, 640, 1280],
    className: 'custom-image-class',
    lazyLoad: true,
  };

  const videoProps = {
    mediaContentType: 'VIDEO',
    previewImage: { url: 'path/to/preview.jpg' },
    sources: [{ url: 'path/to/video.mp4', format: 'mp4' }],
    className: 'custom-video-class',
    lazyLoad: true,
  };

  const externalVideoProps = {
    mediaContentType: 'EXTERNAL_VIDEO',
    host: 'VIMEO',
    originUrl: 'https://vimeo.com/123456',
    previewImage: { url: 'path/to/preview.jpg' },
    lazyLoad: true,
  };

  return (
    <div>
      <Media {...imageProps} />
      <Media {...videoProps} />
      <Media {...externalVideoProps} />
    </div>
  );
};

export default ExampleComponent;
