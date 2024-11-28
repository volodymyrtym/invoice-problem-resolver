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
     * @throws {Error}
     */
    handleError(error) {
        if (error.response) {
            const { status, data } = error.response;

            if (status >= 400 && status < 500) {
                const detail = data.detail || 'Validation failed';

                throw new ApiValidationError(detail, status);
            }
        }

        throw error;
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
     * @param {ApiClientRequestDTO} request
     * @returns {Promise<Object | Array>}
     */
    async get(request) {
        try {
            const headers = this.buildHeaders(request);

            return await this.client.get(request.uri, {params: request.data, headers});
        } catch (error) {
            return this.handleError(error);
        }
    }

    /**
     * @param {ApiClientRequestDTO} request
     * @returns {Promise<Object | Array>}
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

module.exports = {
    ApiClient,
    ApiClientRequestDTO,
    ApiValidationError,
};
