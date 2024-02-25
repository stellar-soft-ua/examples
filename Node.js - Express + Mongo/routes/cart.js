const express = require('express');
const router = express.Router();
const cartController = require('../controllers/cart');
const pagingMiddleware = require('../middlewares/paging');

router.get('/fetch_shopping_cart', cartController.fetchShoppingCart);

router.get('/fetch_products', pagingMiddleware, cartController.fetchCartProducts);

router.post('/insert_product', cartController.insertProduct);

router.delete('/exclude_product/:id', cartController.excludeProduct);

module.exports = router;
