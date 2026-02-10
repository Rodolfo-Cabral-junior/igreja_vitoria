<?php

// Script para criar hash da senha DANIEL
$password = 'DANIEL';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash para senha '$password': $hash\n";
echo "Verificação: " . (password_verify($password, $hash) ? 'OK' : 'FALHOU') . "\n";
