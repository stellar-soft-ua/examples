# Merchants Component

## Purpose
The `Merchants` component is a React functional component designed to display a list of merchants with pagination and CSV download functionality. It fetches data from an API and manages authentication state.

## Key Features
- **Fetch Merchants Data:** Uses `fetchData` utility to retrieve merchants data from the API.
- **Pagination:** Implements pagination controls to navigate through the list of merchants.
- **CSV Download:** Provides functionality to download merchants data in CSV format.
- **Authentication Management:** Includes a logout function to manage user authentication state.

## Example Usage
```javascript
import React from 'react';
import { Merchants } from './path/to/Merchants';

const ExampleComponent = () => {
  return <Merchants />;
};

export default ExampleComponent;
