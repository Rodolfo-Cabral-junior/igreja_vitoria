#!/bin/bash

echo "=== CONVERTENDO SVG PARA PNG ==="

# Instalar pacotes necessários
echo "1. Instalando pacotes..."
sudo apt update
sudo apt install -y librsvg2-bin

# Converter SVG para PNG
echo "2. Convertendo SVG para PNG..."
rsvg-convert -w 3800 -h 2000 public/images/banners/586.svg -o public/images/banners/586.png

# Verificar resultado
echo "3. Verificando arquivo criado..."
ls -la public/images/banners/586.png

echo "=== CONCLUÍDO ==="
