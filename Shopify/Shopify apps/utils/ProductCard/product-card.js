import { h, Fragment } from 'preact';
import clsx from 'clsx';
import HeartIcon from 'utils/icon/icon-heart.svg';
import HeartIconFilled from 'utils/icon/icon-heart-filled.svg';
import CartIcon from 'utils/icon/icon-cart.svg';
import PlusIcon from 'utils/icon/icon-plus.svg';
import { useState, useMemo, useEffect, useRef } from 'preact/hooks';
import useProductSiblings from 'utils/product-siblings';
import useProductWithVideo from 'utils/product-video';
import ProductBadge from '../product/product-badge';
import {
  decodeId,
  generateUrl,
  getProductColor,
  getProductFit,
  getVariantColor,
  sortProductFits,
} from './helpers';
import ProductSwatches from '../product-swatches/product-swatches';
import ProductPrice from '../product/product-price';
import ProductCardMedia from '../product/product-card-media';
import useDiscountProduct from "../product-discounts/product-discount";

const ProductCard = ({
  product: initialProduct,
  className = '',
  imageSlider,
  placement,
  variantId,
}) => {
  const [product, setProduct] = useState(initialProduct);
  const activeProduct = useRef(product);

  const relativeProducts = useProductSiblings(initialProduct);
  const products = useMemo(
    () => relativeProducts.filter((item) => item.availableForSale),
    [relativeProducts],
  );
  const currentProduct = useProductWithVideo(product);

  const url = `${Shopify.routes.root}products/${product.handle}`;

  const colorValue = getProductColor(currentProduct);

  const isOutfit = product.productType === 'Outfit';

  const setupQuickView = () => {
    document.dispatchEvent(
      new CustomEvent(
        product.productType === 'Outfit'
          ? 'look-overlay:open'
          : 'quick-view:open',
        {
          detail:
            product.productType === 'Outfit'
              ? {
                  id: decodeId(product.id, 'Product'),
                }
              : {
                  handle: product.handle,
                },
        },
      ),
    );
  };

  const productFits = useMemo(() => {
    const originalFits = products
      .reduce(
        (items, prod) => [
          ...items,
          ...(prod.options?.find(
            (option) =>
              option.name.trim().toLowerCase() ===
              window.TMW.Strings.product.options.fit,
          )?.values || []),
        ],
        [],
      )
      .filter((value, index, array) => array.indexOf(value) === index)
      .sort()
      .reverse();

    return sortProductFits(originalFits);
  }, [products]);

  const swatches = useMemo(() => {
    if (products.length) {
      const mappedProducts = products.reduce((mapping, item) => {
        const color = getProductColor(item);
        if (!mapping[color]) {
          // eslint-disable-next-line no-param-reassign
          mapping[color] = [item];
        } else {
          mapping[color].push(item);
        }
        return mapping;
      }, {});
      return Object.keys(mappedProducts).map((key) => {
        const initialProductFit = getProductFit(initialProduct);
        return (
          mappedProducts[key].find(
            (item) => getProductFit(item) === initialProductFit,
          ) || mappedProducts[key][0]
        );
      });
    }
    return [];
  }, [products, productFits]);

  const fits = useMemo(
    () =>
      productFits.map((fit) => ({
        name: fit,
        available: products.some((item) =>
          item.variants.some(
            (variant) =>
              getVariantColor(variant) === colorValue &&
              variant.selectedOptions.find(
                (opt) =>
                  opt.name.trim().toLowerCase() ===
                    window.TMW.Strings.product.options.fit && opt.value === fit,
              ) &&
              variant.availableForSale,
          ),
        ),
      })),
    [productFits, colorValue],
  );

  const productChangeHandle = (newProduct, action) => {
    setProduct(newProduct ? { ...newProduct } : { ...activeProduct.current });
    if (action !== 'hover') {
      activeProduct.current = newProduct;
    }
  };

  useEffect(() => {
    document.dispatchEvent(new CustomEvent('swym:collections-loaded'));
  }, [colorValue]);

  const inlineDiscount = useDiscountProduct(
    product.id,
    product.priceRange.minVariantPrice.amount,
    product.collectionsId,
  );
  const productDiscountBadge = useMemo(() =>
    window.getDiscountBadge(product), [product, inlineDiscount]);

  return (
    <article className={clsx('relative z-10 group product-card', className)}>
      <div className="relative mb-8">
        {!isOutfit ? (
          <a className="block no-underline pb-[137%] group/media" href={url}>
            <ProductCardMedia
              product={currentProduct}
              placement={placement}
              imageSlider={imageSlider}
            />
          </a>
        ) : (
          <>
            <button
              className="block no-underline pb-[137%] group/media"
              onClick={(e) => {
                e.preventDefault();
                setupQuickView();
              }}
            >
              <ProductCardMedia
                product={currentProduct}
                placement={placement}
                imageSlider={imageSlider}
              />
            </button>
            <button
              className={clsx(
                'absolute right-8 bottom-8 lc:cta-text-icon w-max mt-16 lc:!pl-14 lc:!pr-14 lc:md:!pl-16 lc:md:!pr-16 ml:bg-white ml:flex ml:items-center ml:justify-center ml:w-24 ml:h-24 ml:md:w-32 ml:md:h-32 z-20',
              )}
              onClick={(e) => {
                e.preventDefault();
                setupQuickView();
              }}
            >
              <PlusIcon className="w-16 h-auto lc:hidden" />
              <CartIcon className="w-16 h-auto ml:hidden" />
              {product.type === 'O'}
              <div className="hidden lc:md:block ml:hidden">
                {window.TMW.Strings.product.shopLook}
              </div>
            </button>
          </>
        )}
        {!isOutfit && (
          <>
            <button
              className={clsx(
                'group z-20 swym-button swym-add-to-wishlist-view-product !text-default !absolute !right-8 !top-8 lg:!hidden lg:group-hover:!inline-block',
                `product_${decodeId(product.id, 'Product')}`,
                {
                  'lc:lg:!right-16 lc:lg:!top-16': placement !== 'cart',
                },
              )}
              data-with-epi="true"
              data-swaction="addToWishlist"
              data-product-id={decodeId(product.id, 'Product')}
              data-variant-id={
                variantId ||
                decodeId(product?.variants?.[0]?.id, 'ProductVariant')
              }
              data-product-url={generateUrl(product.handle, 'products')}
            >
              <HeartIcon
                className={clsx('h-auto text-default heart-outline', {
                  'w-20 lg:w-32': placement !== 'cart',
                  'w-24': placement === 'cart',
                })}
              />
              <HeartIconFilled
                className={clsx('h-auto text-default heart-filled', {
                  'w-20 lg:w-32': placement !== 'cart',
                  'w-24': placement === 'cart',
                })}
              />
            </button>

            <button
              className="lg:hidden lg:group-hover:flex absolute z-20 bottom-8 right-8 items-center lc:lg:right-16 lc:lg:bottom-16 lc:bg-white lc:p-8 flex lc:gap-4 lc:rounded-full lc:border border-grey-300 ml:p-8 ml:right-0 ml:bottom-0 ml:lg:p-0 ml:lg:right-8 ml:lg:bottom-8"
              onClick={(e) => {
                e.preventDefault();
                setupQuickView();
              }}
            >
              <PlusIcon className="w-24 h-auto lc:hidden" />
              <CartIcon className="w-16 h-auto ml:hidden" />
              <span className="body-6 ml:hidden">
                {window.TMW.Strings.cart.add}
              </span>
            </button>
          </>
        )}
        {placement !== 'cart' && (
          <ProductBadge
            className={clsx('py-2 z-20 ml:py-4 px-8 body-6 absolute left-0 bottom-16 !font-normal ml:uppercase md:block', {
              'hidden': !productDiscountBadge,
            })}
            badges={product.badges?.value}
            text={productDiscountBadge}
          />
        )}
      </div>

      <div className="px-6 lg:px-8">
        {placement !== 'cart' && product.productType !== 'Outfit' && (
          <ProductSwatches
            products={swatches}
            currentProduct={product}
            onChange={productChangeHandle}
            viewType="card"
          />
        )}

        {!product.productType.toLowerCase().includes('accessories') &&
          !!fits.length && (
            <div className="flex gap-8 mb-8 ml:hidden">
              {fits.map((fit) => (
                <div
                  key={fit.name}
                  className={clsx('body-6 px-4', {
                    'bg-accent-2': fit.available,
                    'bg-grey-200 text-subdued': !fit.available,
                  })}
                >
                  {fit.name}
                </div>
              ))}
            </div>
          )}

        <h3 className="ml:text-center mb-4 ml:mb-8">
          {isOutfit ? (
            <button
              className="line-clamp-2 product-card-title lg:hover:underline"
              onClick={(e) => {
                e.preventDefault();
                setupQuickView();
              }}
            >
              {product.title}
            </button>
          ) : (
            <a
              className="line-clamp-2 product-card-title lg:hover:underline"
              href={url}
            >
              {product.title}
            </a>
          )}
        </h3>

        {!isOutfit && (
          <ProductPrice
            product={product}
            className="[&_.price]:product-card-price ml:text-center flex flex-wrap gap-x-4 items-center ml:justify-center"
            saleClass="text-misc-sale body-3"
            showRange={false}
            compareClass="product-card-price--compare text-subdued"
          />
        )}
      </div>
    </article>
  );
};

export default ProductCard;
