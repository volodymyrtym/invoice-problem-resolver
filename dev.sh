#!/bin/sh

echo "Installing dev dependencies: php-cs-fixer, psalm, phpmd. For local development"

wget https://github.com/vimeo/psalm/releases/latest/download/psalm.phar
chmod +x psalm.phar
mv psalm.phar -f ./backend/bin/psalm.phar

wget -c https://phpmd.org/static/latest/phpmd.phar
chmod +x phpmd.phar
mv phpmd.phar -f ./backend/bin/phpmd.phar
