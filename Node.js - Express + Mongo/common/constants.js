const fileQuotas = {
    IMAGE_MAX_SIZE: 5 * 1024 * 1024
};

const productFileSizes = [
    {
        name: 'thumbnail',
        height: 200
    },
    {
        name: 'micro_thumbnail',
        height: 40
    }
];

const roles = {
    USER: 'User',
    ADMIN: 'Admin',
    MANAGER: 'Manager'
};

module.exports = {
    fileQuotas,
    productFileSizes,
    roles,
}