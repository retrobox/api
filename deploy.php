<?php
chdir('/var/www/html/api.lefuturiste.fr/');
shell_exec("git pull {$argv[1]}");
shell_exec('php composer.phar install');
shell_exec('php composer.phar update');
