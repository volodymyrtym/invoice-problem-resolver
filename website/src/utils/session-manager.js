class SessionManager {
    constructor(session) {
        this.session = session;
    }

    ensureSession() {
        if (!this.session) {
            throw new Error('Session is not initialized');
        }
    }

    /**
     *
     * @param {string} authToken
     * @param {string} userId
     */
    loggIn(authToken, userId) {
        this.ensureSession();
        this.session.userId = userId;
        this.session.authToken = authToken;
    }

    /**
     *
     * @return {boolean}
     */
    isLoggedIn() {
        try {
            return !!(this.session.userId && this.session.authToken);
        } catch {
            return false;
        }
    }

    /**
     *
     * @return {string}
     */
    get userId() {
        this.ensureSession();
        return this.session.userId;
    }

    /**
     *
     * @return {string}
     */
    get authToken() {
        this.ensureSession();
        return this.session.authToken;
    }
}

module.exports = SessionManager;
