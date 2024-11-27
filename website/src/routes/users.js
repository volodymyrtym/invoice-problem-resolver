const {Router} = require('express');
const {ApiClientRequestDTO, ApiValidationError} = require('../utils/api-сlient');
const { formatSuccess, formatError } = require('../utils/json-response-formatter');

module.exports = (diContainer) => {
    const router = Router();

    router.get('/login', (req, res, next) => {
        res.render('login', {title: 'Express'});
    });

    router.post('/login', async (req, res) => {
        const {email, password} = req.body;
        console.log('body:', req.body);

        if (!email || !password) {
            return res.status(400).send('Email and password are required');
        }

        const apiClient = diContainer.getApiClient();

        try {
            const response = await apiClient.put(
                new ApiClientRequestDTO('users/login', { email: email, password: password }, null)
            );

            req.sessionManager.loggIn(response.data.token, response.data.userId);

            return res.status(200).json(formatSuccess(null));
        } catch (error) {
            if (error instanceof ApiValidationError) {
                return res.status(error.httpStatus).json(formatError(error.message, error.httpStatus));
            }

            return res.status(500).json(formatError(error.message, 500,));
        }
    });

    return router;
};
