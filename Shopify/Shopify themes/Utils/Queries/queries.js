import * as fragments from './fragments';

export const bundleGet = (id) => `
query bundleGet {
  products(query: "tag:bundle_id::${id}", first: 9) {
    edges {
      node {
        ${fragments.product}
      }
    }
  }
}
`;

export const cartCreate = `
mutation cartCreate($input: CartInput!) {
  cartCreate(input: $input) {
    cart {
      id
    }
    userErrors {
      field
      message
    }
  }
}`;

export const cartBuyerIdentityUpdate = `
mutation cartCreate($cartId: ID!, $buyerIdentity: CartBuyerIdentityInput!) {
  cartBuyerIdentityUpdate(cartId: $cartId, buyerIdentity: $buyerIdentity) {
    cart {
      ${fragments.cart}
    }
    userErrors {
      field
      message
    }
  }
}`;

export const cartLinesAdd = `
mutation cartLinesAdd(
  $cartId: ID!,
  $lines: [CartLineInput!]!,
  $countryCode: CountryCode!
)
@inContext(country: $countryCode) {
  cartLinesAdd(cartId: $cartId, lines: $lines) {
    cart {
      ${fragments.cart}
    }
    userErrors {
      field
      message
    }
  }
}`;

export const cartLinesRemove = `
mutation cartLinesRemove(
  $cartId: ID!,
  $lineIds: [ID!]!,
  $countryCode: CountryCode!
)
@inContext(country: $countryCode) {
  cartLinesRemove(cartId: $cartId, lineIds: $lineIds) {
    cart {
      ${fragments.cart}
    }
    userErrors {
      field
      message
    }
  }
}`;

export const cartLinesUpdate = `
mutation cartLinesUpdate(
  $cartId: ID!,
  $lines: [CartLineUpdateInput!]!,
  $countryCode: CountryCode!
)
@inContext(country: $countryCode) {
  cartLinesUpdate(cartId: $cartId, lines: $lines) {
    cart {
      ${fragments.cart}
    }
    userErrors {
      field
      message
    }
  }
}`;

export const collectionGet = `
query collectionGet($id: ID!, $first: Int!) {
  collection(id: $id) {
    products(first: $first) {
      edges {
        node {
          ${fragments.product}
        }
      }
    }
  }
}`;

export const cartAttributesUpdate = `
mutation cartAttributesUpdate($cartId: ID!, $attributes: [AttributeInput!]!) {
  cartAttributesUpdate(attributes: $attributes, cartId: $cartId) {
    cart {
      ${fragments.cart}
    }
    userErrors {
      field
      message
    }
  }
}`;
