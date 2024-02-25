const express = require('express');
const router = express.Router();
const orderController = require('../controllers/order');
const pagingMiddleware = require('../middlewares/paging');
const HasRole = require('../middlewares/hasRole');
const { MANAGER, ADMIN } = require('../common/constants').roles;

router.get('/fetch_orders',
    HasRole([MANAGER, ADMIN]),
    pagingMiddleware,
    orderController.fetchOrders
);

router.get('/fetch_users_order/:id',
    HasRole([MANAGER, ADMIN]),
    orderController.fetchUsersOrder
);

router.get('/fetch_personal_orders', orderController.fetchPersonalOrders);

router.post('/create_personal_order', orderController.createPersonalOrder);

router.delete('/decline_order/:id', orderController.declineOrder);

module.exports = router;
