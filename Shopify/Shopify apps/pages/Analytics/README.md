# Analytics Component

## Purpose
The `Analytics` component is a React functional component designed to display and manage analytics data. It uses Shopify's Polaris components for consistent UI/UX and includes features like date range selection, pagination, data fetching, and downloading analytics data in CSV format.

## Key Features
- **Date Range Selection:** Allows users to select a date range for filtering analytics data.
- **Pagination:** Provides pagination controls to navigate through the data.
- **Data Fetching:** Uses custom hooks and API calls to fetch analytics data.
- **Download Functionality:** Allows users to download selected or all analytics data in CSV format.
- **Responsive Design:** Adjusts layout and components based on screen size.

## Example Usage
```javascript
import React from 'react';
import { Analytics } from './path/to/Analytics';

const ExampleComponent = () => {
  return <Analytics />;
};

export default ExampleComponent;
