# Data Formatting Utilities

## Purpose
This JavaScript module provides a set of utility functions to format various types of Shopify data, including products, variants, cart lines, and bundles. It also includes a money formatting utility.

## Key Functions

### `edgesToNodes(resource, type)`
Converts GraphQL edges to nodes and formats them based on the specified type.

**Parameters:**
- `resource` (object): The resource containing edges.
- `type` (string): The type of resource to format (e.g., 'cartline', 'image', 'product', 'variant').

**Returns:**
- An array of formatted nodes.

### `formatBundle(prods)`
Formats a bundle of products, calculating the total value and available variants.

**Parameters:**
- `prods` (object): The products to be formatted.

**Returns:**
- An object containing formatted products, active variants, availability, and total value.

### `formatCart(cart)`
Formats a cart object, including subtotal and formatted cart lines.

**Parameters:**
- `cart` (object): The cart to be formatted.

**Returns:**
- A formatted cart object.

### `formatCartLine(line)`
Formats a single cart line.

**Parameters:**
- `line` (object): The cart line to be formatted.

**Returns:**
- A formatted cart line object.

### `formatCartLines(lines)`
Formats multiple cart lines, handling bundle items and regular items separately.

**Parameters:**
- `lines` (array): The cart lines to be formatted.

**Returns:**
- An array of formatted cart lines.

### `formatCartLinesAjax(lines)`
Formats multiple cart lines for Ajax requests, handling bundle items and regular items separately.

**Parameters:**
- `lines` (array): The cart lines to be formatted.

**Returns:**
- An array of formatted cart lines.

### `formatImage(image)`
Formats an image object.

**Parameters:**
- `image` (object): The image to be formatted.

**Returns:**
- A formatted image object.

### `formatProduct(product)`
Formats a product object, including its variants and images.

**Parameters:**
- `product` (object): The product to be formatted.

**Returns:**
- A formatted product object.

### `formatVariant(variant)`
Formats a variant object.

**Parameters:**
- `variant` (object): The variant to be formatted.

**Returns:**
- A formatted variant object.

### `formatMoney({ amount, currencyCode = 'USD' }, cents = false)`
Formats a monetary amount into a specified currency format.

**Parameters:**
- `amount` (number): The monetary amount to be formatted.
- `currencyCode` (string): The currency code (default: 'USD').
- `cents` (boolean): Whether the amount is in cents (default: false).

**Returns:**
- A formatted currency string.

**Usage:**
```javascript
const formattedAmount = formatMoney({ amount: 123456, currencyCode: 'EUR' }, true);
console.log(formattedAmount); // Outputs: €1,234.56
