const {Router} = require('express');
const {ApiClientRequestDTO, ApiValidationError} = require('../utils/api-сlient');

module.exports = (diContainer) => {
    const router = Router();

    router.get('/', async (req, res, next) => {
        const apiClient = diContainer.getApiClient();
        try {
            const response = await apiClient.get(
                new ApiClientRequestDTO('daily-activities', {
                    limit: 30,
                    page: req.query.page || 1,
                    userId: req.sessionManager.userId
                }, req.sessionManager.authToken)
            );

            res.render('daily-activities', {data: response});
        } catch (error) {
            next(error);
        }
    });

    return router;
};
