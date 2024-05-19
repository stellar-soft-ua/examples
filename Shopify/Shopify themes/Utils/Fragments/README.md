# GraphQL Fragments

## Purpose
This JavaScript module provides GraphQL fragments for querying Shopify data. These fragments are used to retrieve detailed information about cart lines, carts, variants, and products.

## Key Fragments

### `cartLine`
Defines the fields to be retrieved for a cart line.

**Fields:**
- `id`: The ID of the cart line.
- `quantity`: The quantity of the item.
- `attributes`: Custom attributes of the cart line.
    - `key`: The attribute key.
    - `value`: The attribute value.
- `cost`: The total cost of the cart line.
    - `totalAmount`: The total amount.
        - `amount`: The monetary amount.
        - `currencyCode`: The currency code.
- `merchandise`: The merchandise details.
    - `id`: The ID of the product variant.
    - `quantityAvailable`: The available quantity of the variant.
    - `product`: The product details.
        - `title`: The product title.
        - `handle`: The product handle.

### `cart`
Defines the fields to be retrieved for a cart.

**Fields:**
- `checkoutUrl`: The checkout URL for the cart.
- `id`: The ID of the cart.
- `totalQuantity`: The total quantity of items in the cart.
- `cost`: The subtotal cost of the cart.
    - `subtotalAmount`: The subtotal amount.
        - `amount`: The monetary amount.
        - `currencyCode`: The currency code.
- `lines(first: 50)`: The first 50 cart lines.
    - `edges`: The edges of the cart lines.
        - `node`: The cart line node containing the fields defined in `cartLine`.

### `variant`
Defines the fields to be retrieved for a product variant.

**Fields:**
- `availableForSale`: Whether the variant is available for sale.
- `id`: The ID of the variant.
- `price`: The price of the variant.
    - `amount`: The monetary amount.
    - `currencyCode`: The currency code.
- `compareAtPrice`: The compare at price of the variant.
    - `amount`: The monetary amount.
    - `currencyCode`: The currency code.
- `selectedOptions`: The selected options for the variant.
    - `name`: The name of the option.
    - `value`: The value of the option.

### `product`
Defines the fields to be retrieved for a product.

**Fields:**
- `availableForSale`: Whether the product is available for sale.
- `handle`: The handle of the product.
- `id`: The ID of the product.
- `title`: The title of the product.
- `images(first: 50)`: The first 50 images of the product.
    - `edges`: The edges of the images.
        - `node`: The image node.
            - `alt`: The alt text of the image.
            - `height`: The height of the image.
            - `id`: The ID of the image.
            - `src`: The URL of the image.
            - `width`: The width of the image.
- `options`: The options for the product.
    - `id`: The ID of the option.
    - `name`: The name of the option.
    - `values`: The values of the option.
- `priceRange`: The price range of the product.
    - `minVariantPrice`: The minimum price of the variants.
        - `amount`: The monetary amount.
        - `currencyCode`: The currency code.
- `compareAtPriceRange`: The compare at price range of the product.
    - `minVariantPrice`: The minimum compare at price of the variants.
        - `amount`: The monetary amount.
        - `currencyCode`: The currency code.
- `variants(first: 100)`: The first 100 variants of the product.
    - `edges`: The edges of the variants.
        - `node`: The variant node containing the fields defined in `variant`.

## Example Usage
```javascript
import {
  cartLine,
  cart,
  variant,
  product
} from './path/to/graphql-fragments';

// Example query using the fragments
const GET_CART = `
  query {
    cart(id: "gid://shopify/Cart/1234567890") {
      ${cart}
    }
  }
`;

const GET_PRODUCT = `
  query {
    product(handle: "example-product") {
      ${product}
    }
  }
`;
