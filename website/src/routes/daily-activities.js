const {Router} = require('express');
const {apiClient, ApiClientRequestDTO} = require('../utils/api-client');

module.exports = () => {
    const router = Router();

    router.get('/', async (req, res, next) => {
        try {
            const response = await apiClient.get(
                new ApiClientRequestDTO('daily-activities', {
                    limit: 30,
                    page: req.query.page || 1,
                    userId: req.sessionManager.userId
                }, req.sessionManager.authToken)
            );

            console.log(response);
            res.render('daily-activities', {data: response});
        } catch (error) {
            next(error);
        }
    });

    return router;
};
