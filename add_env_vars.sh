#!/bin/bash
echo "" >> /etc/php/7.2/fpm/pool.d/www.conf # new line.
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
