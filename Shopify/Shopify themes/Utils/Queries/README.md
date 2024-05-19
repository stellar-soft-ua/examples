# GraphQL Queries and Mutations

## Purpose
This JavaScript module provides GraphQL queries and mutations for interacting with Shopify's API. It includes operations for fetching products, creating and updating carts, and managing cart lines.

## Key Queries and Mutations

### `bundleGet(id)`
Fetches products with a specific bundle ID.

**Parameters:**
- `id` (string): The bundle ID to query for.

**Query:**
```graphql
query bundleGet {
  products(query: "tag:bundle_id::${id}", first: 9) {
    edges {
      node {
        ${fragments.product}
      }
    }
  }
}
