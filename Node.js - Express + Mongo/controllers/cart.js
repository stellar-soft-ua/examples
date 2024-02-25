const sequelize = require('sequelize');
const { Product } = require('../models');

module.exports.fetchShoppingCart = async (request, response, next) => {
    try {
        const productsIds = await request.user.getProducts({
            attributes: ['id']
        }).then(res => res.map(prod => prod.id));

        const { totalCost } = await Product.findOne({
            where: { id: productsIds },
            attributes: [[sequelize.fn('sum', sequelize.col('price')), 'totalCost']],
            raw : true,
        });

        response.send({ productsIds, totalCost });
    } catch (err) {
        next(err);
    }
};

module.exports.fetchCartProducts = async (request, response, next) => {
    try {
        const cart = await request.user.getProducts({ ...request.paging });
        response.send(cart);
    } catch (err) {
        next(err);
    }
};

module.exports.insertProduct = async (request, response, next) => {
    const ProductId = parseInt(request.body.productId);

    try {
        const prod = await request.user.addProduct(ProductId);

        if (!prod) {
            return response
                .status(400)
                .send('Such product already inside shopping cart');
        }

        response.sendStatus(201);
    } catch (err) {
        next(err);
    }
};

module.exports.excludeProduct = async (request, response, next) => {
    const ProductId = parseInt(request.params['id']);

    try {
        const prod = await request.user.removeProduct(ProductId);

        if (!prod) {
            return response
                .status(400)
                .send('Such product already excluded from shopping cart');
        }

        response.sendStatus(204);
    } catch (err) {
        next(err);
    }
};
