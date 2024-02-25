module.exports = (sequelize, DataTypes) => {
    const Cart = sequelize.define('Cart', {
        // will be generated programmatically by belongsToMany
        /*UserId: {
            type: DataTypes.INTEGER,
            allowNull: false,
            references: {
                model: 'Users',
                key: 'id'
            }
        },
        ProductId: {
            type: DataTypes.INTEGER,
            allowNull: false,
            references: {
                model: 'Products',
                key: 'id'
            }
        }*/
    });

    return Cart;
};
