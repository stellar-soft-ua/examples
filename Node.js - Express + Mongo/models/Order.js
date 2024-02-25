module.exports = (sequelize, DataTypes) => {
    const Order = sequelize.define('Order', {}, {
        paranoid: true
    });

    Order.associate = (models) => {
        Order.belongsTo(models.User);
        Order.hasMany(models.OrderProduct, {
            onDelete: 'cascade'
        });
    };

    return Order;
};
