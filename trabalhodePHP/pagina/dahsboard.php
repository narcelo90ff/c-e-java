<?php


require_once(__DIR__ . '/../despesas/config.php');
require_once(__DIR__ . '/../protetor_pagina/funcoes.php');

proteger_pagina();
header('Location: index.php');
exit;
