const { Category, Product, sequelize, Sequelize } = require('../models');
const { deletePreviewPhoto } = require('../common/utils');
const fs = require('fs');
const path = require('path');
const uuid = require('uuid');
const sharp = require('sharp');
const { productFileSizes } = require('../common/constants');

module.exports.fetchTopProducts = async (request, response, next) => {
    const { searchQuery } = request.query;
    const searchFilter = searchQuery ?
        { name: { [Sequelize.Op.like]: `%${searchQuery}%` } } : {};

    try {
        const orderProducts = await Product.findAndCountAll({
            ...request.paging,
            where: searchFilter,
            paranoid: false,
            attributes: {
                include: [
                    [sequelize.literal('(SELECT COUNT(*) FROM OrderProducts WHERE OrderProducts.ProductId = Product.id )'), 'OrderCount']
                ]
            },
            order: [
                [sequelize.literal('OrderCount'), 'DESC']
            ]
        });

        response.send(orderProducts);
    } catch (err) {
        next(err);
    }
};

module.exports.fetchProducts = async (request, response, next) => {
    const {
        category: categoryName,
        searchQuery
    } = request.query;

    const { Op } = Sequelize;
    const searchFilter = searchQuery ?
        { name: { [Op.like]: `%${searchQuery}%` } } : {};

    try {
        const category = await Category.findOne({ where: { name: categoryName } });
        const product = await Product.findAndCountAll({
            where: {
                CategoryId: category.id,
                ...searchFilter
            },
            ...request.paging,
            include: [
                { model: Category }
            ]
        });
        response.send(product);
    } catch (err) {
        next(err);
    }
};

module.exports.createProduct = async (request, response, next) => {
    const { file } = request;

    try {
        if (file) {
            request.body.previewPhoto = await savePreviewWithThumbnail(file);
        }

        const product = await Product.create(request.body);
        response.send(product);
    } catch (err) {
        next(err);
    }
};

module.exports.updateProduct = async (request, response, next) => {
    const { id } = request.body;
    const { file } = request;

    try {
        if (file) {
            request.body.previewPhoto = await savePreviewWithThumbnail(file);
            const product = await Product.findByPk(id);
            await deletePreviewPhoto(product.previewPhoto);
        }

        await Product.update(
            request.body,
            { where: { id } }
        );
        response.sendStatus(200);
    } catch (err) {
        next(err);
    }
};

module.exports.deleteProduct = async (request, response, next) => {
    const id = request.params['id'];

    try {
        await Product.destroy({
            where: { id },
            individualHooks: true
        });
        response.sendStatus(204);
    } catch (err) {
        next(err);
    }
};

const savePreviewWithThumbnail = (file) => {
    const dirPath = path.join( __dirname, `/../public/preview_photo/`);
    const fileName = uuid.v1() + path.extname(file.originalname);

    const fileResizingPromises = [];
    const fileSavingPromises = [];

    productFileSizes.forEach(fileMode => {
        fileResizingPromises.push(
            sharp(file.buffer)
                .resize(null, fileMode.height)
                .toFile(`${dirPath}/${fileMode.name}/${fileName}`)
        );

        fileSavingPromises.push(
            new Promise((resolve, reject) => {
                fs.writeFile(
                    dirPath + fileName,
                    file.buffer,
                    (err) => {
                        if (err) {
                            reject(err);
                        }
                        resolve(true);
                    }
                );
            })
        )
    });

    return Promise.all([...fileResizingPromises, ...fileSavingPromises])
        .then(() => fileName);
};
