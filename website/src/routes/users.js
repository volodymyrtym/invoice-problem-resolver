const {Router} = require('express');
const {ApiClientRequestDTO} = require('../utils/api-сlient');

module.exports = (diContainer) => {
    const router = Router();

    router.get('/login', (req, res, next) => {
        res.render('login', {title: 'Express'});
    });

    router.post('/login', async (req, res, next) => {
        const {email, password} = req.body;

        if (!email || !password) {
            return res.status(400).send('Email and password are required');
        }

        const apiClient = diContainer.getApiClient();

        try {
            const response = await apiClient.put(
                new ApiClientRequestDTO('users/login', { email: email, password: password }, null)
            );

            req.sessionManager.loggIn(response.data.authToken, response.data.userId);

            return res.status(204).json(null);
        } catch (error) {
            next(error);
        }
    });

    return router;
};
