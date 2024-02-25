const { Role } = require('../models');

module.exports.fetchRoles = async (request, response, next) => {
    try {
        const roles = await Role.findAll();
        response.send(roles);
    } catch (err) {
        next(err);
    }
};
