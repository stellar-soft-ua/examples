const { Role, User, sequelize } = require('../models');
const bcrypt = require('bcrypt');
const saltRounds = 12; //2-3 hashes/sec
const passport = require('passport');
const { roles } = require('../common/constants');
const { handleError } = require('../common/utils');

exports.signUp = async (request, response, next) => {
    const transaction = await sequelize.transaction();

    try {
        const { user, contactInfo } = request.body;
        const salt = await bcrypt.genSalt(saltRounds);
        user.password = await bcrypt.hash(user.password, salt);

        const RoleId = await Role.findOne({
            where: { name: roles.USER },
            attributes: ['id'],
        }).then(res => res.id);

        //atomic creating of contact info and user - creation can throw error on duplicate email for User and duplicate phone for ContactInfo so need rollback both if any error
        const createdUser = await User.create({...user, RoleId }, { transaction });
        await createdUser.createContactInfo(contactInfo, { transaction });
        await transaction.commit();

        request.logIn(createdUser, err => {
            if (err) {
                handleError(err);
                next("Can't authorize new user");
            }
            response.sendStatus(201);
        });
    } catch (err) {
        await transaction.rollback();
        next(err);
    }
};

exports.signIn = async (request, response, next) => {
    passport.authenticate('local', (err, user, info) => {
        if (err) {
            next(err);
        }

        if (info) {
            // Dev only, insecure
            // const errorMessage = info.message;
            const errorMessage = 'Invalid username or password.';

            return response
                .status(401)
                .send(errorMessage);
        }

        request.logIn(user, err => {
            if (err) {
                next(err);
            }

            response.sendStatus(200);
        });
    })(request, response, next);
};
