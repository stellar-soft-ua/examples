class SizedImage extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });

    const style = document.createElement('style');
    style.textContent = `
      img {
        display: block;
        max-width: 100%;
        height: auto;
      }
    `;

    this.shadowRoot.append(style);
  }

  connectedCallback() {
    const alt = this.getAttribute('alt') || '';
    const src = this.getAttribute('src') || '';
    const srcWidths = this.parseWidths(this.getAttribute('src-widths'));
    const height = this.getAttribute('height') || 'auto';
    const width = this.getAttribute('width') || 'auto';
    const classes = this.getAttribute('classes') || '';

    const img = document.createElement('img');
    img.className = `image ${classes}`;
    img.setAttribute('src', src);
    img.setAttribute('alt', alt);
    img.setAttribute('height', height);
    img.setAttribute('width', width);
    img.setAttribute('loading', 'lazy');

    const { srcset, sizes } = this.calculateSrcSetAndSizes(src, srcWidths);
    img.setAttribute('srcset', srcset);
    img.setAttribute('sizes', sizes);

    this.shadowRoot.append(img);
  }

  parseWidths(widths) {
    return widths ? JSON.parse(widths) : {};
  }

  getSizedImageUrl(src, size) {
    if (size === null) return src;
    const match = src.match(/\.(jpg|jpeg|gif|png|bmp|bitmap|tiff|tif|jpg.webp|gif.webp)(\?v=\d+)?$/i);
    if (!match) return null;
    const prefix = src.split(match[0])[0];
    const suffix = match[0];
    return `${prefix}_${size}x${suffix}`.replace(/http(s)?:/, '');
  }

  calculateSrcSetAndSizes(src, srcWidths) {
    const bps = { sm: 640, md: 768, lg: 1024, xl: 1280, '2xl': 1536 };
    const widths = srcWidths;

    // Remove undefined breakpoints
    Object.keys(bps).forEach(key => widths[key] === undefined && delete bps[key]);
    Object.keys(widths).forEach(key => bps[key] === undefined && delete widths[key]);

    // Reduce to values arrays
    const srcWidthsReduced = Object.values(widths);
    const sizeWidthsReduced = Object.values(bps);

    // Convert to srcset and sizes values
    const srcset = srcWidthsReduced.map(w => `${this.getSizedImageUrl(src, w)} ${w}w`).join(',');
    const sizes = `${srcWidthsReduced.map((w, i) => `(max-width: ${sizeWidthsReduced[i]}px) ${w}px`).slice(0, srcWidthsReduced.length - 1).join(',')}, ${srcWidthsReduced[srcWidthsReduced.length - 1]}px`;

    return { srcset, sizes };
  }
}

window.customElements.define('sized-image', SizedImage);
