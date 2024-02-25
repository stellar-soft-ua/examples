module.exports = (sequelize, DataTypes) => {
    const User = sequelize.define('User', {
        email: {
            type: DataTypes.STRING,
            unique: {
                args: true,
                msg: 'Email address already in use'
            },
            validate: {
                isEmail: true,
            },
            allowNull: false,
        },
        password: {
            type: DataTypes.STRING,
            allowNull: false,
            get() {
                return () => this.getDataValue('password');
            },
        },
        firstName: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        lastName: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        gender: {
            type: DataTypes.BOOLEAN,
            allowNull: true,
        },
        birthDay: {
            type: DataTypes.INTEGER,
            allowNull: true,
        }
    });

    User.associate = (models) => {
        User.belongsTo(models.Role, {
            foreignKey: {
                field: 'RoleId',
                allowNull: false
            },
        });
        User.hasOne(models.ContactInfo, {
            onDelete: 'cascade'
        });
        User.belongsToMany(models.Product, {
            through: models.Cart,
            inverse: 'Product'
        });
        User.hasMany(models.Order, {
            onDelete: 'cascade'
        });
        User.hasMany(models.Chat, {
            onDelete: 'cascade'
        });
    };

    return User;
};
