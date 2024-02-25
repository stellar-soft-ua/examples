const io = require('socket.io')();
const { User, Role } = require('../../models');

io.on('connection', async (socket) => {
    if (!socket.request.session.passport.user) {
        // socket.emit('error', { message: 'Authentication error' });
        return socket.disconnect();
    }

    let chat;
    let chatOwner;

    const userId = socket.request.session.passport.user;
    const user = await User.findByPk(userId, {
        include: [{
            model: Role,
            attributes: ['name']
        }]
    });

    socket.on('open_chat', async (chatOwnerId) => {
        try {
            chatOwner = await User.findByPk(chatOwnerId || user.id);
            // TODO single chat
            [chat] = await chatOwner.getChats();
            if (!chat) {
                chat = await chatOwner.createChat();
            }

            socket.join(chatOwner.id);
            socket.emit('chat_opened');
        } catch (err) {
            socket.emit('error', err.message);
        }
    });

    socket.on('fetch_messages', async (paging) => {
        const messages = await chat.getMessages();
        socket.emit('messages_fetched', messages);
    });

    socket.on('send_message', async (message) => {
        message.UserId = user.id;

        try {
            message = await chat.createMessage(message);
        } catch (err) {
            socket.emit('error', err.message);
        }

        socket.to(chatOwner.id).emit('message_sent', message);
        // Message to the owner itself - notify that the msg successfully delivered
        socket.emit('message_sent', message);
    });
});

module.exports = io;
