module.exports = (sequelize, DataTypes) => {
    const OrderProduct = sequelize.define('OrderProduct', {
        // id and association will be generated automatically
    });

    OrderProduct.associate = (models) => {
        OrderProduct.belongsTo(models.Order);
        OrderProduct.belongsTo(models.Product);
    };

    return OrderProduct;
};
