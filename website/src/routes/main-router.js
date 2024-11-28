const usersRouter = require('./users');
const dailyActivities = require('./daily-activities');

function registerRoutes(app, diContainer) {
    app.get('/', (req, res) => {
        if (req.sessionManager.isLoggedIn()) {
            return res.redirect('/daily-activities');
        }

        return res.render('login');
    });

    app.use('/users', usersRouter(diContainer));
    app.use('/daily-activities', dailyActivities(diContainer));
}

module.exports = registerRoutes;
