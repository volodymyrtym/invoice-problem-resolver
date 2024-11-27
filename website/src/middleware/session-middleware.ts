import {NextFunction, Request, Response} from 'express';
import {SessionManager} from "../utils/session-manager";

export const sessionMiddleware = (req: Request, res: Response, next: NextFunction) => {
    (req as any).sessionManager = new SessionManager(req.session);

    next();
};
