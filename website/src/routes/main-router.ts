import {NextFunction, Request, Response, Router} from 'express';
import userRoutes from './users';

const mainRouter = Router();

/* GET home page. */
mainRouter.get('/', (req: Request, res: Response, next: NextFunction) => {
    res.render('login', {title: 'Express'});
});

mainRouter.use('/users', userRoutes)

export default mainRouter;
