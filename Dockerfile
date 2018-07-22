FROM debian
LABEL maintainer="spamfree@matthieubessat.fr"
ADD . /app
WORKDIR /app
RUN apt-get update && apt-get -y upgrade
# install php
RUN apt-get install -y apt-transport-https lsb-release ca-certificates wget
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
RUN apt-get update && apt-get -y upgrade
RUN apt-get -y install curl
RUN apt-get -y install php7.2 php7.2-common php7.2-cli php7.2-fpm php7.2-zip
RUN apt-get -y install php7.2-common php7.2-json php7.2-curl php7.2-mbstring php7.2-bcmath php7.2-mysql
RUN apt-get -y install composer
# install nginx
RUN apt-get -y install nginx
RUN apt-get -y install unzip zip
RUN rm /etc/nginx/sites-enabled/default
RUN cp /app/nginx.conf /etc/nginx/sites-enabled/default
RUN composer install
RUN chmod -R 777 /app
RUN chown -R www-data:www-data /app
RUN service php7.2-fpm restart
RUN service nginx restart
# env
ENV APP_NAME retrobox_api
ENV APP_ENV_NAME prod
ENV APP_DEBUG 0
ENV LOG_DISCORD 1
ENV LOG_DISCORD_WH https://discordapp.com/api/webhooks/468096349292986368/oM2DKFsSwtCntbZd0Mcpynyo_BoOiYQq4SWyTLNzfJyt6LmcAEH3cXgwIuHy8gnH0h77
ENV LOG_PATH ../log
ENV LOG_LEVEL INFO
ENV WEB_ENDPOINT https://retrobox.tech
EXPOSE 80
CMD sh /app/start.sh