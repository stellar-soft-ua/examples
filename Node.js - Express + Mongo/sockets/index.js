const chatSocket = require('./chat');
const sessionMiddleware = require('../auth/session');

module.exports.init = (server) => {
    chatSocket.attach(server, { cookie: true });
    chatSocket.use((socket, next) => {
        sessionMiddleware(socket.request, {}, next);
    })
};
