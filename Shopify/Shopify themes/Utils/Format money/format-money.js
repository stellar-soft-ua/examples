const formatMoney = ({ amount, currencyCode = 'USD' }, cents = false) => {
  let amt = amount;
  if (Number.isNaN(amt))
    // eslint-disable-next-line no-console
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
