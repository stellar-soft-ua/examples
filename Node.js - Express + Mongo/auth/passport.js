const passport = require('passport');
const LocalStrategy = require('passport-local').Strategy;
const bcrypt = require('bcrypt');
const models = require('../models');

passport.use(new LocalStrategy({
    usernameField: 'email',
    passwordField: 'password',
}, async (username, password, done) => {
    try {
        const user = await models.User.findOne({
            where: { email: username }
        });

        if (!user) {
            return done(null, false, { message: 'User is not exists' });
        }

        const validPassword = await bcrypt.compare(password, user.password());

        if (!validPassword) {
            return done(null, false, { message: 'Incorrect password.' });
        }

        done(null, user);
    } catch (err) {
        done(err, null);
    }
}));

passport.serializeUser((user, done) => {
    done(null, user.id);
});

passport.deserializeUser(async (id, done) => {
    try {
        const user = await models.User.findOne({
            where: { id },
            include: [
                { model: models.ContactInfo },
                { model: models.Role }
            ],
            attributes: { exclude: ['RoleId'] }
        });
        done(null, user)
    } catch (err) {
        done(err, null);
    }
});

module.exports = passport;
