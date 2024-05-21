# AccountForm Component

## Purpose
The `AccountForm` component is a React functional component designed for managing account information. It utilizes Shopify's Polaris UI components, React Hook Form for form management, and Yup for validation. This form allows users to create, edit, and delete account information.

## Key Features
- **Form Handling:** Uses React Hook Form for managing form state and validation.
- **Yup Validation:** Implements Yup for schema validation.
- **Polaris Components:** Utilizes Polaris components for consistent UI/UX.
- **Translation Support:** Integrates with `react-i18next` for internationalization.
- **Modal for Deletion:** Includes a modal for confirming account deletion.

## Props
- `accountInfo` (object): Information about the account to be edited.
- `onClose` (function): Function to call when the form is closed.
- `onSubmit` (function): Function to call when the form is submitted.
- `onDelete` (function): Function to call when the account is deleted.
- `isLoading` (boolean): Indicates whether the form submission is in progress.
- `deleteLoading` (boolean): Indicates whether the account deletion is in progress.
- `marketplaceList` (object): List of marketplaces available for selection.
- `isEditMode` (boolean): Indicates whether the form is in edit mode.
- `orderTypesList` (object): List of order types available for selection.
- `syncColumns` (object): List of columns available for synchronization.
- `syncSelected` (string|number): The selected synchronization column.

## Example Usage
```javascript
import React from 'react';
import { AccountForm } from './path/to/AccountForm';

const ExampleComponent = () => {
  const accountInfo = { /* account info */ };
  const marketplaceList = { /* marketplace list */ };
  const orderTypesList = { /* order types list */ };
  const syncColumns = { /* sync columns */ };

  const handleFormClose = () => { /* handle form close */ };
  const handleFormSubmit = (data) => { /* handle form submit */ };
  const handleAccountDelete = () => { /* handle account delete */ };

  return (
    <AccountForm
      accountInfo={accountInfo}
      onClose={handleFormClose}
      onSubmit={handleFormSubmit}
      onDelete={handleAccountDelete}
      isLoading={false}
      deleteLoading={false}
      marketplaceList={marketplaceList}
      isEditMode={true}
      orderTypesList={orderTypesList}
      syncColumns={syncColumns}
      syncSelected="sync_key"
    />
  );
};

export default ExampleComponent;
