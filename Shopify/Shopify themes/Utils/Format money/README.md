# Format Money Utility

## Purpose
This JavaScript utility function is used to format monetary amounts into a specified currency format. It supports formatting both in whole units and cents.

## Key Features
- **Currency Formatting:** Formats amounts into specified currency formats.
- **Optional Cents Handling:** Allows formatting amounts as cents by dividing the amount by 100.
- **Error Handling:** Logs an error to the console if the amount is not a valid number.

## Function Definition
### `formatMoney`
Formats a monetary amount into a specified currency format.

**Parameters:**
- `amount` (number): The monetary amount to be formatted.
- `currencyCode` (string): The currency code (default: 'USD').
- `cents` (boolean): Whether the amount is in cents (default: false).

**Returns:**
- A formatted currency string.

**Usage:**
```javascript
const formatMoney = ({ amount, currencyCode = 'USD' }, cents = false) => {
  let amt = amount;
  if (Number.isNaN(amt)) 
    return console.error('utils/format-money.js: No amount value passed.');

  if (cents) amt /= 100;

  const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: currencyCode,
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });

  return formatter.format(amt);
};

export default {
  formatMoney,
};
