import Bottle from 'bottlejs';
import dotenv from 'dotenv';
import ApiClient from './api-сlient'

dotenv.config({path: '../../.env'});

class DIContainer {
    private bottle: Bottle;

    constructor() {
        this.bottle = new Bottle();

        const apiBaseUrl = process.env.API_BASE_URL || 'http://invoice-problem-resolver.loc/';
        //this.bottle.service('ApiClient', ApiClient, 'fdsf');
        console.log(apiBaseUrl);
        this.bottle.service('ApiClient', ApiClient);
        console.log('api cl regis')
    }

    public getApiClient(): ApiClient {
        return this.bottle.container.ApiClient;
    }
}

export const diContainer = new DIContainer();
