module.exports = (sequelize, DataTypes) => {
    const Message = sequelize.define('Message', {
        textContent: {
            type: DataTypes.TEXT,
            allowNull: false,
        },
    });

    Message.associate = (models) => {
        Message.belongsTo(models.Chat);
        Message.belongsTo(models.User);
    };

    return Message;
};
