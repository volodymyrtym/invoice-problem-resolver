const { default: packetJsDi, Container } = require('packetjs-di');
const { ApiClient } = require('./api-сlient');


class DIContainer {
    constructor() {
        if (!DIContainer.instance) {
            this.container = new Container();
            console.log('process.env.API_BASE_URL: ', process.env.API_BASE_URL)
            this.container.add('ApiClient', () => {
                return new ApiClient(process.env.API_BASE_URL);
            });

            DIContainer.instance = this;
        }

        return DIContainer.instance;
    }

    /** @returns ApiClient */
    getApiClient() {
        return this.container.get('ApiClient');
    }
}

const diContainerInstance = new DIContainer();
module.exports = diContainerInstance;
