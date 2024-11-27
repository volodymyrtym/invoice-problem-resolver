const SessionManager = require('../utils/session-manager');

const sessionMiddleware = (req, res, next) => {
    req.sessionManager = new SessionManager(req.session);
    next();
};

module.exports = sessionMiddleware;
