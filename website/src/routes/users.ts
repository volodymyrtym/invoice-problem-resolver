import { Router, Request, Response, NextFunction } from 'express';
import { diContainer } from '../utils/di-container';

const router = Router();

router.get('/login', (req: Request, res: Response, next: NextFunction) => {
    res.render('login', {title: 'Express'});
});
router.post('/login', async (req: Request, res: Response, next: NextFunction) => {
    const {email, password} = req.body;
    console.log('body:',req.body);
    if (!email || !password) {
        return res.status(400).send('Email and password are required');
    }

    try {
        const response = await diContainer.getApiClient().put('/users/login', {
            email: email,
            password: password
        });
        console.log(response)
        //const sessionManager = (req as any).sessionManager;
        //sessionManager.loggedIn(response.data.token, response.data.userId)

        res.redirect('/daily-activities');
    } catch (error) {
        console.error('Error during login:', error);
        res.status(500).send('Login failed. Please try again later.');
    }
});

export default router;
