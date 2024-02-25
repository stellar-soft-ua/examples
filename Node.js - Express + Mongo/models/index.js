'use strict';

const fs = require('fs');
const path = require('path');
const Sequelize = require('sequelize');
const basename = path.basename(__filename);
const env = process.env.NODE_ENV || 'development';
const config = require(__dirname + '/../config/config.json')[env];
const db = {};

const sequelize = config.use_env_variable
  ? new Sequelize(process.env[config.use_env_variable], config)
  : new Sequelize(config.database, config.username, config.password, config);

fs
  .readdirSync(__dirname)
  .filter(file =>
    file.indexOf('.') && file !== basename && (file.slice(-3) === '.js')
  )
  .forEach(file => {
    const model = sequelize['import'](path.join(__dirname, file));
    db[model.name] = model;
  });

Object.keys(db).forEach(modelName => {
  if (db[modelName].associate) {
    db[modelName].associate(db);
  }
});

db.sequelize = sequelize;
db.Sequelize = Sequelize;

// FIXME just for initilize db for the first running
const initDefaultValues = async (db) => {
  const { roles } = require('../common/constants');
    // db.sequelize.sync({force: true});

  await db.Session.sync();
  await db.Role.sync();
  await db.User.sync();
  await db.ContactInfo.sync();
  await db.Category.sync();
  await db.Product.sync();
  await db.Cart.sync();
  await db.Order.sync();
  await db.OrderProduct.sync();
  await db.Chat.sync();
  await db.Message.sync();

  db.Category.bulkCreate([
      { name: 'Art' },
      { name: 'Fruits' },
      { name: 'Tablet' },
      { name: 'Clothes' },
      { name: 'Business' },
      { name: 'Fastfood' },
      { name: 'Computers' },
      { name: 'Vegetables' },
      { name: 'Smartphones' },
      { name: 'Decorations' }
  ]);

  db.Role.bulkCreate([
      { name: roles.USER },
      { name: roles.ADMIN },
      { name: roles.MANAGER }
  ]);
};
// initDefaultValues(db);

module.exports = db;
