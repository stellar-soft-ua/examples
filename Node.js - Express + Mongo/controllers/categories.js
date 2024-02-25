const { Category } = require('../models');

module.exports.fetchCategories = async (request, response, next) => {
    try {
        const categories = await Category.findAll();
        response.send(categories);
    } catch (err) {
        next(err);
    }
};

module.exports.createCategory = async (request, response, next) => {
    const { categoryName } = request.body;

    try {
        const category = await Category.create({ name: categoryName });
        response.send(category);
    } catch (err) {
        next(err);
    }
};

module.exports.removeCategory = async (request, response, next) => {
    const { id } = request.params;

    try {
        const category = await Category.findByPk(id);
        if (!category) {
            return response
                .status(404)
                .send('Such category not found');
        }

        await category.destroy();
        response.sendStatus(204);
    } catch (err) {
        next(err);
    }
};
