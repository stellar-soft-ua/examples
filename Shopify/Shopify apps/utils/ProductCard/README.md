# ProductCard Component

## Purpose
The `ProductCard` component is a React (Preact) functional component that displays product information, including images, prices, swatches, and badges. It supports various product types, including outfits, and provides quick view functionality.

## Key Features
- **Product Display:** Shows product images, prices, and titles.
- **Quick View:** Allows quick view of product details through a modal.
- **Swatches and Fits:** Displays product color swatches and available fits.
- **Badges:** Shows product badges and discounts.
- **Wishlist and Cart:** Integrates with wishlist and cart functionalities.

## Props
- `product` (object): Initial product data.
- `className` (string): Additional class names for the component.
- `imageSlider` (boolean): Enables image slider for product images.
- `placement` (string): Determines the placement context (e.g., cart).

## Example Usage
```javascript
import React from 'react';
import ProductCard from './path/to/ProductCard';

const ExampleComponent = () => {
  const product = {
    id: '123',
    handle: 'example-product',
    title: 'Example Product',
    productType: 'Clothing',
    priceRange: {
      minVariantPrice: {
        amount: '29.99',
      },
    },
    variants: [
      {
        id: '1234',
        availableForSale: true,
        selectedOptions: [
          {
            name: 'Color',
            value: 'Red',
          },
          {
            name: 'Size',
            value: 'M',
          },
        ],
      },
    ],
    options: [
      {
        name: 'Color',
        values: ['Red', 'Blue'],
      },
      {
        name: 'Size',
        values: ['S', 'M', 'L'],
      },
    ],
    images: [
      {
        src: 'path/to/image.jpg',
      },
    ],
  };

  return (
    <ProductCard product={product} className="custom-class" />
  );
};

export default ExampleComponent;
