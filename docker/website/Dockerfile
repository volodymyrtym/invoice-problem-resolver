FROM node:22

RUN apt-get update && apt-get install -y \
    python3 \
    make \
    g++ \
    && rm -rf /var/lib/apt/lists/*


WORKDIR /var/www/website

ARG NODE_ENV=development

RUN if [ "$NODE_ENV" = "prod" ]; then \
      echo "Running in production mode" && \
      COPY ../../package*.json ./ && \
      npm install --production && \
      COPY ../../backend . && \
      echo "Production dependencies installed and files copied"; \
    fi

RUN mkdir -p /home/node/.npm && chown -R node:node /home/node
# Kept set user last layer
RUN usermod -u ${HOST_UID} node;\
    groupmod -g ${HOST_GID} node;\
    chown -R node:node /var/www;

USER node

#EXPOSE 3000
#CMD ["node", "run", "start"]
