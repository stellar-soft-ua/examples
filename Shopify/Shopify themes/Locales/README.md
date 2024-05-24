# Locales Snippet

## Purpose
This snippet is used to define and expose localized strings for various sections of the Shopify store. It allows the JavaScript code to access translated strings, making the store adaptable to different languages.

## Key Features
- **Global Namespace Creation:** Ensures that the `window.SS` namespace exists.
- **Localized Strings Definition:** Defines localized strings for bundles, cart actions, product actions, and error messages. These strings are pulled from the Shopify translation files using the `{{ 'key' | t }}` Liquid filter.

## Localized Sections
- **Bundle:**
  - `value`: The value of the bundle (`{{ 'product.bundle.value' | t }}`).

- **Cart:**
  - `add`: Text for adding an item to the cart (`{{ 'cart.general.add' | t }}`).
  - `cart`: Text for the cart itself (`{{ 'cart.general.cart' | t }}`).
  - `checkout`: Text for the checkout button (`{{ 'cart.general.checkout' | t }}`).
  - `close`: Text for closing the cart (`{{ 'cart.general.close' | t }}`).
  - `remove`: Text for removing an item from the cart (`{{ 'cart.general.remove' | t }}`).
  - `subtract`: Text for subtracting an item quantity (`{{ 'cart.general.subtract' | t }}`).

- **Product:**
  - `addToCart`: Text for adding a product to the cart (`{{ 'product.form.add_to_cart' | t }}`).
  - `outOfStock`: Text indicating a product is out of stock (`{{ 'product.form.out_of_stock' | t }}`).
  - `unavailable`: Text indicating a product is unavailable (`{{ 'product.form.unavailable' | t }}`).

- **ErrorsMessage:**
  - `emailErrorMessage`: Error message for invalid email (`{{ 'customer.error_messages.email_error_message' | t }}`).
  - `passwordErrorMessage`: Error message for invalid password (`{{ 'customer.error_messages.password_error_message' | t }}`).
  - `firstNameErrorMessage`: Error message for invalid first name (`{{ 'customer.error_messages.first_name_error_message' | t }}`).
  - `lastNameErrorMessage`: Error message for invalid last name (`{{ 'customer.error_messages.last_name_error_message' | t }}`).
