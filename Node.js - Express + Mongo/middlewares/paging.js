module.exports = (request, response, next) => {
    const { offset, limit } = request.query;

    // && request.user.role === USER
    if (!offset || !limit) {
        return response
            .status(400)
            .send('You should use paging query for this request');
    }
    request.paging = {
        offset: Number(offset),
        limit: Number(limit)
    };
    next();
};
