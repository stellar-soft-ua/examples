const express = require('express');
const router = express.Router();
const userController = require('../controllers/users');
const roleController = require('../controllers/roles');
const pagingMiddleware = require('../middlewares/paging');
const HasRole = require('../middlewares/hasRole');
const { MANAGER, ADMIN } = require('../common/constants').roles;

router.get('/fetch_role_list', HasRole([MANAGER, ADMIN]), roleController.fetchRoles);

router.get('/fetch_users', HasRole([MANAGER, ADMIN]), pagingMiddleware, userController.fetchUsers);

router.put('/update_role/:id', HasRole([ADMIN]), userController.updateRole);

module.exports = router;
