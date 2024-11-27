import {Session} from 'express-session';

export class SessionManager {
    private session: Session;

    public construct(session: Session): void {
        this.session = session;
    }

    private ensureSession(): void {
        if (!this.session) {
            throw new Error('Session is not initialized');
        }
    }

    public loggedIn(token: string, userId: string): void {
        this.session.userId = userId;
        this.session.token = token;
    }

    public isLoggedIn(): boolean {
        try {
            this.ensureSession();

            return !!(this.session.userId && this.session.token);
        } catch {
            return false;
        }
    }

    get userId(): string {
        this.ensureSession();

        return this.session.userId;
    }

    get token(): string {
        this.ensureSession();

        return this.session.token;
    }
}
