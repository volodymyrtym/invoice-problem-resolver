const axios = require('axios');

class ApiClient {
    /**
     *
     * @param {string} baseUrl
     */
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
        this.client = axios.create({
            baseURL: baseUrl,
            timeout: 5000,
        });
    }

    /**
     * @param {import('axios').AxiosError} error
     * @throws {ApiValidationError}
     */
    handleError(error) {
        if (error.response) {
            const { status, data } = error.response;

            if (status >= 400 && status < 500) {
                const detail = data.detail || 'Validation failed';

                throw new ApiValidationError(detail, status);
            }
        }

        throw new ApiValidationError(error.message, error.status || 500);
    }

    /**
     * @param {ApiClientRequestDTO} request
     * @returns {Object}
     */
    buildHeaders(request) {
        const headers = {
            'Content-Type': 'application/json',
        };

        if (request.authenticationToken) {
            headers['auth-token'] = request.authenticationToken;
        }

        return headers;
    }

    /**
     *
     * @param {ApiClientRequestDTO} request
     * @returns {Promise<any>}
     * @throws {ApiValidationError}
     */
    async put(request) {
        try {
            const headers = this.buildHeaders(request);

            return await this.client.put(request.uri, request.data, {headers});
        } catch (error) {
            return this.handleError(error);
        }
    }

    /**
     * @param {ApiClientRequestDTO} request
     * @returns {Promise<Object | Array>}
     * @throws {ApiValidationError}
     */
    async post(request) {
        try {
            const headers = this.buildHeaders(request);

            return await this.client.post(request.uri, request.data, {headers});
        } catch (error) {
            return this.handleError(error);
        }
    }

    /**
     *
     * @param {ApiClientRequestDTO} request
     * @returns {Promise<Array>}
     * @throws {ApiValidationError}
     */
    async get(request) {
        try {
            const headers = this.buildHeaders(request);
            const response = await this.client.get(request.uri, {params: request.data, headers});

            return response.data;
        } catch (error) {
            return this.handleError(error);
        }
    }

    /**
     * @param {ApiClientRequestDTO} request
     * @returns {Promise<Object | Array>}
     * @throws {ApiValidationError}
     */
    async delete(request) {
        try {
            const headers = this.buildHeaders(request);

            return await this.client.delete(request.uri, {data: request.data, headers});
        } catch (error) {
            return this.handleError(error);
        }
    }

}

class ApiClientRequestDTO {
    /**
     *
     * @param {string}  uri
     * @param {object} data
     * @param {string|null} authenticationToken
     */
    constructor(uri, data, authenticationToken = null) {
        this.uri = uri;
        this.data = data;
        this.authenticationToken = authenticationToken;
    }
}

class ApiValidationError extends Error {
    /**
     *
     * @param {string} message
     * @param {number} httpStatus
     */
    constructor(message, httpStatus) {
        super(message);
        this.name = 'ApiError';
        this.httpStatus = httpStatus;
    }
}

const baseUrl = process.env.API_BASE_URL; // Тягнемо базовий URL із змінних оточення
if (!baseUrl) {
    throw new Error('API_BASE_URL not set!');
}

const apiClient = new ApiClient(baseUrl);

module.exports = {
    apiClient,
    ApiClientRequestDTO,
    ApiValidationError,
};
