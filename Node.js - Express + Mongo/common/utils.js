const fs = require('fs');
const path = require('path');

const deletePreviewPhoto = async (previewPhoto) => {
    if (previewPhoto) {
        const dirPath = path.join( __dirname, `/../public/preview_photo/`);
        const files = [
            dirPath + previewPhoto,
            `${dirPath}/thumbnail/${previewPhoto}`
        ];

        files.forEach(file => {
            fs.unlink(file, (err) => err && handleError(err));
        });
    }
};

const handleError = (err) => handleError(err);

module.exports = {
    deletePreviewPhoto,
    handleError,
}
