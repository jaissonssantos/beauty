<?php

//ocultar os warning e alerts do php
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 1);

//definindo os dados de acesso ao banco de dados(DEVELOPER)
define('DB', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'labella');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SALT', '&$_100#*xh!9%0'); //nunca mudar(salt padrão)

//definindo os dados de acesso ao banco de dados(PRODUÇÃO)
// define('DB', 'mysql');
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'congresso_app');
// define('DB_USER', 'congresso_app');
// define('DB_PASS', 'S}eU;$W(sndz');
// define('SALT', '&$15#*cg!1='); //nunca mudar(salt padrão)


//definindo as URLs padrões do sistema e site
define('URL_APP', 'http://localhost');
define('STORAGE_URL', 'http://localhost/assets/images');
define('TITLE_APP', 'La Bella - beleza e bem-estar de forma que você quer!');
define('EMAIL_TITLE', 'La Bella');
define('EMAIL_NOREPLAY', 'labella.ac@gmail.com');
define('EMAIL_SUPPORT', 'jaissonssantos@gmail.com');
define('DEBUG', false);

//PagSeguro(SANDBOX)
define('PAGSEGURO_EMAIL', 'jaissonssantos@gmail.com');
define('PAGSEGURO_TOKEN', 'A23B0F63E9684FF489709FC57243801A');
define('sessionURL', 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions');
define('transactionsURL', 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions');
define('notificationsURL', 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications');
define('javascriptURL', 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js');

//PagSeguro(PRODUÇÃO)
// define('PAGSEGURO_EMAIL', 'kambo.tecnologia@gmail.com');
// define('PAGSEGURO_TOKEN', '075141F8B5184E858B39B9F6B6FB8779');
// define('sessionURL', 'https://ws.pagseguro.uol.com.br/v2/sessions');
// define('transactionsURL', 'https://ws.pagseguro.uol.com.br/v2/transactions');
// define('notificationsURL', 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications');
// define('javascriptURL', 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js');
