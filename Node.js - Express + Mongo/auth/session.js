const sequelize = require('../models').sequelize;
const expressSession = require('express-session');
const SequelizeStore = require('connect-session-sequelize')(expressSession.Store);

const sessionMiddleware = expressSession({
    secret: process.env.AUTH_SECRET,
    store: new SequelizeStore({
        db: sequelize
    }),
    resave: false,
    saveUninitialized: false,
    cookie: {
        maxAge: 24 * 60 * 60 * 1000,
    }
});

module.exports = sessionMiddleware;
