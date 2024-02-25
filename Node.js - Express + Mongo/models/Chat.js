module.exports = (sequelize, DataTypes) => {
    const Chat = sequelize.define('Chat', {
        // id and association will be generated automatically
    });

    Chat.associate = (models) => {
        Chat.belongsTo(models.User);
        Chat.hasMany(models.Message, {
            onDelete: 'cascade'
        });
    };

    return Chat;
};
