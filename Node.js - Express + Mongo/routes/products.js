const express = require('express');
const router = express.Router();
const productsController = require('../controllers/products');
const pagingMiddleware = require('../middlewares/paging');
const HasRole = require('../middlewares/hasRole');
const { MANAGER, ADMIN } = require('../common/constants').roles;

const { fileQuotas } = require('../common/constants');
const multer = require('multer');
const storage = multer.memoryStorage();

const upload = multer({
    storage,
    limits: {
        fileSize: fileQuotas.IMAGE_MAX_SIZE
    }
});

router.get('/top_products', pagingMiddleware, productsController.fetchTopProducts);

router.get('/products', pagingMiddleware, productsController.fetchProducts);

router.post('/create_products',
    HasRole([MANAGER, ADMIN]),
    upload.single('attachedPhoto'),
    productsController.createProduct
);

router.put('/update_product',
    HasRole([MANAGER, ADMIN]),
    upload.single('attachedPhoto'),
    productsController.updateProduct
);

router.delete('/delete_product/:id',
    HasRole([MANAGER, ADMIN]),
    productsController.deleteProduct
);

module.exports = router;
