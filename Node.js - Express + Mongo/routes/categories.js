const express = require('express');
const router = express.Router();
const categoriesController = require('../controllers/categories');
const HasRole = require('../middlewares/hasRole');
const { MANAGER, ADMIN } = require('../common/constants').roles;

router.get('/fetch_categories', categoriesController.fetchCategories);

router.post('/create_category', HasRole([MANAGER, ADMIN]), categoriesController.createCategory);

router.delete('/remove_category/:id', HasRole([MANAGER, ADMIN]), categoriesController.removeCategory);

module.exports = router;
