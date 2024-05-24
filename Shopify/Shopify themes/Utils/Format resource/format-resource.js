export const edgesToNodes = (resource, type) => {
  if (!resource || !type) return [];
  return resource.edges.map(({ node }) => {
    switch (type) {
      case 'cartline':
        return formatCartLine(node);
      case 'image':
        return formatImage(node);
      case 'product':
        return formatProduct(node);
      case 'variant':
        return formatVariant(node);
      default:
        return null;
    }
  });
};

export const formatBundle = (prods) => {
  const products = edgesToNodes(prods, 'product');
  const activeVariants = products.map((p) =>
    p.variants.find((v) => v.availableForSale),
  );
  const bundleValue = products.reduce((total, product) => {
    const totalPrice =
      total + parseFloat(product.priceRange.minVariantPrice.amount);
    return totalPrice;
  }, 0);

  return {
    products,
    activeVariants: products.map((p) =>
      p.variants.find((v) => v.availableForSale),
    ),
    available: activeVariants.every((v) => v.availableForSale),
    value: {
      amount: bundleValue,
      currencyCode: window.SS.localization.currencyCode,
    },
  };
};

export const formatCart = (cart) => {
  const subtotal = cart?.cost?.subtotalAmount || {
    amount: 0,
    currencyCode: window.SS.localization.currencyCode,
  };
  return {
    ...cart,
    subtotal,
    lines: formatCartLines(edgesToNodes(cart?.lines, 'cartline')),
  };
};

export const formatCartLine = (line) => ({
  ...line,
});

export const formatCartLines = (lines) => {
  if (!lines) return [];

  const processedBundles = [];
  const formattedLines = lines
    .map((line) => {
      const bundleProductsId = line.attributes?.find(
        (attr) => attr.key === '_bundleProductsId',
      );
      // If not a bundle item return the default line object
      if (!bundleProductsId) return formatCartLine(line);
      // If bundle already processed, skip to next line item
      if (processedBundles.includes(bundleProductsId.value)) return null;

      // Get bundle items
      const bundleItems = lines
        .filter((l) => {
          const currentId = l.attributes.find(
            (attr) => attr.key === '_bundleProductsId',
          )?.value;
          if (currentId === bundleProductsId.value) return l;
          return null;
        })
        .map((l) => l);

      // Log bundle ID in processed bundles array
      processedBundles.push(bundleProductsId.value);

      const firstItem = bundleItems[0];
      const bundleData = JSON.parse(
        firstItem.attributes.find((a) => a.key === '_bundleData').value,
      );

      // Return bundle line item
      return {
        merchandise: bundleData.merchandise,
        cost: bundleData.cost,
        quantity: firstItem.quantity,
        children: bundleItems,
      };
    }, [])
    .filter((i) => i);

  return formattedLines.filter((x) => x);
};

export const formatCartLinesAjax = (lines) => {
  if (!lines) return [];

  const processedBundles = [];
  const formattedLines = lines
    .map((line) => {
      const bundleProductsId = line.properties?._bundleProductsId;
      // If not a bundle item return the default line object
      if (!bundleProductsId) return line;
      // If bundle already processed, skip to next line item
      if (processedBundles.includes(bundleProductsId)) return null;

      // Get bundle items
      const bundleItems = lines
        .filter((l) => {
          const currentId = l.properties?._bundleProductsId;
          if (currentId === bundleProductsId) return l;
          return null;
        })
        .map((l) => l);

      // Log bundle ID in processed bundles array
      processedBundles.push(bundleProductsId);

      const firstItem = bundleItems[0];
      const bundleData = JSON.parse(firstItem.properties._bundleData);

      // Return bundle line item
      return {
        merchandise: bundleData.merchandise,
        cost: bundleData.cost,
        quantity: firstItem.quantity,
        children: bundleItems,
      };
    }, [])
    .filter((i) => i);

  return formattedLines.filter((x) => x);
};

export const formatImage = (image) => ({
  ...image,
});

export const formatProduct = (product) => ({
  ...product,
  variants: edgesToNodes(product.variants, 'variant'),
  images: edgesToNodes(product.images, 'image'),
  hasOnlyDefaultVariant:
    product.options.length === 1 &&
    product.options[0].values[0] === 'Default Title',
});

export const formatVariant = (variant) => ({
  ...variant,
});

export const formatMoney = (
  { amount, currencyCode = 'USD' },
  cents = false,
) => {
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
