const winston = require('winston');
const LoggerTransport = require('winston-daily-rotate-file');
const path = require("path");

const logger = winston.createLogger({
    level: 'error',
    format: winston.format.combine(
        winston.format.timestamp(),
        winston.format.json() // Логи у форматі JSON
    ),
    transports: [
        new LoggerTransport({
            filename: path.join(__dirname, '../var/logs/error-%DATE%.log') ,
            datePattern: 'YYYY-MM-DD',
            maxSize: '20m',
            maxFiles: '7d'
        })
    ]
});

module.exports = logger;
