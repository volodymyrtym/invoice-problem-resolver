const { ApiValidationError } = require('../utils/api-сlient');
const {formatError} = require("../utils/json-response-formatter"); // Імпортуємо ваш клас помилки

module.exports = (err, req, res, next) => {
    if (!(err instanceof ApiValidationError)) {
        return next(err);
    }

    if (req.is('application/json')) {
        if(error.httpStatus > 400 && error.httpStatus < 500){
            return res.status(error.httpStatus).json(formatError(error.message, error.httpStatus));
        }

        return res.status(500).json(formatError(error.message, 500,));
    }

    if (err.httpStatus === 401) {
        return res.status(401).render('login', {
            message: 'Your session has expired. Please log in again.',
        });
    }

    next(err);
};
