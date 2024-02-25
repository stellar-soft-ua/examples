module.exports = (roles) => (request, response, next) => {
    if (roles.includes(request.user.Role.name)) {
        next();
    } else {
        response.sendStatus(403);
    }
};
