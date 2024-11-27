class SessionManager {
    constructor(session) {
        this.session = session;
    }

    ensureSession() {
        if (!this.session) {
            throw new Error('Session is not initialized');
        }
    }

    loggIn(token, userId) {
        this.ensureSession();
        this.session.userId = userId;
        this.session.token = token;
    }

    isLoggedIn() {
        try {
            return !!(this.session.userId && this.session.token);
        } catch {
            return false;
        }
    }

    get userId() {
        this.ensureSession();
        return this.session.userId;
    }

    get token() {
        this.ensureSession();
        return this.session.token;
    }
}

module.exports = SessionManager;
