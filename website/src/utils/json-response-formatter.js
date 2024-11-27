/**
 * @param {string} error
 * @param {int} status
 *
 * @returns {{detail: string, error: boolean, title: string, status: int}}
 */
function formatError(error, status) {
    return {
        error: true,
        title: error || 'An error occurred',
        status: status,
        detail: error || 'No additional information provided',
    };
}

/**
 * @param {Object|null} resource
 * @returns {Object}
 */
function formatSuccess(resource) {
    return {
        error: false,
        resource: resource || {},
    };
}

module.exports = {
    formatSuccess,
    formatError,
};
