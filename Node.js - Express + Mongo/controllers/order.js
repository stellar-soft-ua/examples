const _ = require('lodash');
const { roles } = require('../common/constants');
const { Order, OrderProduct, Product, Category, User, ContactInfo } = require('../models');

module.exports.fetchOrders = async (request, response, next) => {
    try {
        const orders = await Order.findAndCountAll({
            ...request.paging,
            include: [{
                model: OrderProduct,
                include: [{
                    model: Product,
                    include: [{
                        model: Category,
                        attributes: [ 'name' ]
                    }]
                }],
            }],
        });

        const resultOrders = orders.rows.map(order =>
            User.findOne({
                where: { id: order.UserId },
                include: [{
                    model: ContactInfo
                }]
            }).then(user => {
                const { ContactInfo } = user;
                const { id, createdAt, OrderProducts } = order;
                const products = OrderProducts.map(prod => prod.Product);

                return {
                    id,
                    createdAt,
                    ContactInfo,
                    products
                };
            }),
        );
        await Promise.all(populateUserContactInfo);

        response.send({ rows: resultOrders, count: orders.count });
    } catch (err) {
    next(err);
    }
};

module.exports.fetchUsersOrder = async (request, response, next) => {
    const { id } = request.params;
    // TODO paginate
    try {
        const user = await User.findByPk(id);
        const orders = await fetchOrders(user);

        response.send(orders);
    } catch (err) {
    next(err);
    }
};

module.exports.fetchPersonalOrders = async (request, response, next) => {
    // TODO paginate
    try {
        const orders = await fetchOrders(request.user);
        response.send(orders);
    } catch (err) {
    next(err);
    }
};

module.exports.createPersonalOrder = async (request, response, next) => {
    const { productIds } = request.body;
    const productQuery = productIds.map(id => ({ ProductId: id }));

    if (!productIds) {
        return response
            .status(400)
            .send('Products is not exists');
    }

    try {
        const [ order, OrderProducts ] = await Promise.all([
            request.user.createOrder(),
            OrderProduct.bulkCreate(productQuery),
            request.user.removeProducts(productIds)
        ]);

        const res = await order.addOrderProduct(OrderProducts);

        response.send(res);
    } catch (err) {
    next(err);
    }
};

module.exports.declineOrder = async (request, response, next) => {
    const id = request.params['id'];

    try {
        if (![roles.ADMIN, roles.MANAGER].includes(request.user.Role.name)) {
            const order = await Order.findOne({ where: { id, UserId: request.user.id } });

            if (!order) {
                return response
                    .status(403)
                    .send('You have not permission to close this Order');
            }
        }

        const res = await Order.destroy({ where: { id } });

        if (!res) {
            return response
                .status(400)
                .send('Such product already excluded from shopping cart');
        }

        response.sendStatus(204);
    } catch (err) {
    next(err);
    }
};

const fetchOrders = async (user) => {
    const orders = await user.getOrders({
        include: [{
            model: OrderProduct,
            include: [{
                model: Product,
                include: [{
                    model: Category,
                    attributes: [ 'name' ]
                }]
            }],
        }],
    });

    return orders.map(order => {
        const { id, createdAt, OrderProducts } = order;
        const products = OrderProducts.map(prod => prod.Product);
        return {
            id,
            createdAt,
            products: _.compact(products)
        }
    });
};
