const { ApiValidationError } = require('./api-client');
const logger = require('./logger');
const formatError = require('./json-response-formatter');

/**
 * @param {Error} err
 * @param {Request} req
 * @param {Response} res
 * @param {Function} next
 */
function errorHandler(err, req, res, next) {
    // Логування помилки
    logger.error({
        message: err.message,
        stack: err.stack,
        method: req.method,
        url: req.originalUrl,
        status: err.status || 500
    });

    if (err instanceof ApiValidationError) {
        if (req.is('application/json')) {
            if (err.httpStatus > 400 && err.httpStatus < 500) {
                return res.status(err.httpStatus).json(formatError(err.message, err.httpStatus));
            }
            return res.status(500).json(formatError(err.message, 500));
        }

        if (err.httpStatus === 401) {
            return res.status(401).render('login', {
                message: 'Your session has expired. Please log in again.',
            });
        }
    }


    res.locals.message = err.message;
    res.locals.error = req.app.get('env') === 'development' ? err : {};

    res.status(err.status || 500);
    res.render('error');
}

module.exports = errorHandler;
