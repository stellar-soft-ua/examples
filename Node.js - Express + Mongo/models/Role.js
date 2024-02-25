module.exports = (sequelize, DataTypes) => {
    const Role = sequelize.define('Role', {
        name: {
            type: DataTypes.STRING,
            unique: {
                args: true,
                msg: 'This role already exists'
            },
            allowNull: false,
        }
    });

    return Role;
};
