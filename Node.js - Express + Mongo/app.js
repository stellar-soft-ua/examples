const express = require('express');
const app = express();
const path = require('path');
const cookieParser = require('cookie-parser');
const logger = require('morgan');
const history = require('connect-history-api-fallback');
require('dotenv').config();

const sessionMiddleware = require('./auth/session');
const passport = require('./auth/passport');

const cors = require('cors');
const corsWhiteList = [
    process.env.CLIENT_URL_VUE,
    process.env.CLIENT_URL_REACT,
    process.env.CLIENT_URL_ANGULAR,
];
const corsOptions = {
    origin: (origin, callback) =>
        ~corsWhiteList.indexOf(origin)
            ? callback(null, true)
            : callback(new Error('Not allowed by CORS')),
    credentials: true,
};

app.use(cookieParser());
app.use(sessionMiddleware);
app.use(passport.initialize());
app.use(passport.session());
app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(express.static(path.join(__dirname, 'public')));
app.use(cors(corsOptions));
app.use(history({ verbose: true }));

const AuthRequired = require('./middlewares/authRequired');

const authRouter = require('./routes/auth');
const productRouter = require('./routes/products');
const cartRouter = require('./routes/cart');
const orderRouter = require('./routes/order');
const usersRouter = require('./routes/users');
const categoriesRouter = require('./routes/categories');
const internalError = require('./middlewares/internalError');

app.use('/', authRouter);
app.use('/products', productRouter);
app.use('/cart', AuthRequired, cartRouter);
app.use('/order', AuthRequired, orderRouter);
app.use('/users', usersRouter);
app.use('/categories', categoriesRouter);
app.use(internalError);

module.exports = app;
