#!/bin/bash
# env vars
if [ -e /env_vars_added.check ]
then
    rm /etc/php/7.2/fpm/pool.d/www.conf
    cp /etc/php/7.2/fpm/pool.d/www.conf.opsave /etc/php/7.2/fpm/pool.d/www.conf
else
    # first time
    echo "coping..."
    cp /etc/php/7.2/fpm/pool.d/www.conf /etc/php/7.2/fpm/pool.d/www.conf.opsave
    touch /env_vars_added.check
fi
echo "adding env vars..."
echo "" >> /etc/php/7.2/fpm/pool.d/www.conf
echo "env[APP_NAME] = $APP_NAME;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[APP_ENV_NAME] = $APP_ENV_NAME;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[APP_DEBUG] = $APP_DEBUG;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[LOG_DISCORD] = $LOG_DISCORD;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[LOG_PATH] = $LOG_PATH;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[LOG_LEVEL] = $LOG_LEVEL;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[LOG_DISCORD_WH] = $LOG_DISCORD_WH;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[MYSQL_HOST] = $MYSQL_HOST;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[MYSQL_DATABASE] = $MYSQL_DATABASE;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[MYSQL_USERNAME] = $MYSQL_USERNAME;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[MYSQL_PASSWORD] = $MYSQL_PASSWORD;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[STAILEU_PUBLIC] = $STAILEU_PUBLIC;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[STAILEU_PRIVATE] = $STAILEU_PRIVATE;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[STAILEU_REDIRECT] = $STAILEU_REDIRECT;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[JWT_KEY] = $JWT_KEY;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[SOURCE_DOMAIN] = $SOURCE_DOMAIN;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[STRIPE_IS_TEST] = $STRIPE_IS_TEST;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[STRIPE_PRIVATE] = $STRIPE_PRIVATE;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[STRIPE_PUBLIC] = $STRIPE_PUBLIC;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "env[WEB_ENDPOINT] = $WEB_ENDPOINT;" >>  /etc/php/7.2/fpm/pool.d/www.conf
echo "Done!"

echo "Migrating db..."
if eval "/app/vendor/bin/phinx migrate"; then
        echo "Done!"
        echo "Migrating success!"
else
        echo "Migrating failed!"
        exit
fi

echo "Starting php7.2-fpm..."
service php7.2-fpm start
echo "Done!"

echo "Starting nginx server..."
nginx -g "daemon off;"
echo "End of nginx server"