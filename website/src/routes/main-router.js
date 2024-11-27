const usersRouter = require('./users');

function registerRoutes(app, diContainer) {
    app.get('/', (req, res) => {
        if (req.sessionManager.isLoggedIn()) {
            return res.redirect('/dashboard');
        }

        return res.render('login');
    });

    app.use('/users', usersRouter(diContainer));
}

module.exports = registerRoutes;
