module.exports = (sequelize, DataTypes) => {
    const Category = sequelize.define('Category', {
        name: {
            type: DataTypes.STRING,
            unique: {
                args: true,
                msg: 'This category already exists'
            },
            validation: {
                len: [1, 32]
            },
            allowNull: false,
        }
    });

    Category.associate = (models) => {
        Category.hasMany(models.Product,{
            onDelete: 'cascade',
            hooks: true
        });
    };

    return Category;
};
