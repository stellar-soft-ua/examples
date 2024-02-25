module.exports = (sequelize, DataTypes) => {
    const ContactInfo = sequelize.define('ContactInfo', {
        phone: {
            type: DataTypes.INTEGER,
            validate: {
                len: [4, 12],
                isNumeric: true
            },
            unique: {
                args: true,
                msg: 'Such phone already in use'
            },
            allowNull: false,
        },
        address: {
            type: DataTypes.STRING,
            allowNull: false,
        }
        // TODO cities dropdown, zip code, etc ...
    });

    ContactInfo.associate = (models) => {
        ContactInfo.belongsTo(models.User, {
            onDelete: 'cascade'
        });
    };

    return ContactInfo;
};
