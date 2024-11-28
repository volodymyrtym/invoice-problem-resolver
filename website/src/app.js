require('dotenv').config({path: './.env'});
require('dotenv').config({path: './.env.local'});

const express = require('express');
const createError = require('http-errors');
const path = require('path');
const cookieParser = require('cookie-parser');
const logger = require('morgan');
const session = require('express-session');
const sessionFileStore = require('session-file-store')(session);
const sessionMiddleware = require('./middleware/session-middleware');
const apiErrorsMiddleware = require('./middleware/api-errors-middleware');
const registerRoutes = require('./routes/main-router');
const diContainer = require('./utils/di-container');

const app = express();

app.set('views', path.join(__dirname, '../templates'));
app.set('view engine', 'twig');

if (process.env.NODE_ENV === 'dev') {
    app.set("view cache", false);
    app.use(logger('dev'));
}

app.use(express.json());
app.use(express.urlencoded({extended: true}));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, '../public')));
app.use(
    session({
        store: new sessionFileStore({
            path: path.join(__dirname, '/var/sessions'),
            logFn: console.log,
        }),
        secret: process.env.SESSION_SECRET || 'default-secret',
        resave: false,
        saveUninitialized: true,
        cookie: {secure: false},
    })
);
app.use(sessionMiddleware);
app.use((req, res, next) => {
    console.log(`[${new Date().toISOString()}] ${req.method} ${req.url}`);
    next();
});
registerRoutes(app, diContainer);
//post controller middlewares
app.use(apiErrorsMiddleware);
// catch 404 and forward to error handler
app.use((req, res, next) => {
    next(createError(404));
});

app.use((err, req, res, next) => {
    res.locals.message = err.message;
    res.locals.error = req.app.get('env') === 'development' ? err : {};

    res.status(err.status || 500);
    res.render('error');
});

module.exports = app;
