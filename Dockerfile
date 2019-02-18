FROM lefuturiste/php-fpm
LABEL maintainer="contact@thingmill.fr"
ADD . /app
# env
ENV APP_NAME retrobox_api
ENV APP_ENV_NAME prod
ENV APP_DEBUG 0
ENV LOG_DISCORD 1
ENV LOG_DISCORD_WH https://discordapp.com/api/webhooks/468096349292986368/oM2DKFsSwtCntbZd0Mcpynyo_BoOiYQq4SWyTLNzfJyt6LmcAEH3cXgwIuHy8gnH0h77
ENV LOG_PATH ../log
ENV LOG_LEVEL INFO
ENV WEB_ENDPOINT https://retrobox.tech
