<?php

// Criar hash para senha DANIEL em maiúsculas
$password = 'DANIEL';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash para senha '$password' (maiúsculas): $hash\n";
echo "Verificação: " . (password_verify($password, $hash) ? 'OK' : 'FALHOU') . "\n";

// Testar com minúsculas
$passwordLower = 'daniel';
echo "Teste com '$passwordLower' (minúsculas): " . (password_verify($passwordLower, $hash) ? 'OK' : 'FALHOU') . "\n";
