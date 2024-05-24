export const cartLine = `
id
quantity
attributes {
  key
  value
}
cost {
  totalAmount {
    amount
    currencyCode
  }
}
merchandise {
  ... on ProductVariant {
    id
    quantityAvailable
    product {
      ... on Product {
        title
        handle
      }
    }
  }
}
`;

export const cart = `
checkoutUrl
id
totalQuantity
cost {
  subtotalAmount {
    amount
    currencyCode
  }
}
lines(first: 50) {
  edges {
    node {
      ${cartLine}
    }
  }
}
`;

export const variant = `
availableForSale
id
price {
  amount
  currencyCode
}
compareAtPrice {
  amount
  currencyCode
}
selectedOptions {
  name
  value
}
`;

export const product = `
availableForSale
handle
id
title
handle
images(first: 50) {
  edges {
    node {
      alt: altText
      height
      id
      src: url(transform: { preferredContentType: WEBP })
      width
    }
  }
}
options {
  id
  name
  values
}
priceRange {
  minVariantPrice {
    amount
    currencyCode
  }
}
compareAtPriceRange {
  minVariantPrice {
    amount
    currencyCode
  }
}
variants(first: 100) {
  edges {
    node {
      ${variant}
    }
  }
}
`;
