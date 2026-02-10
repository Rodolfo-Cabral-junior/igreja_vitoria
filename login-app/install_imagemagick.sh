#!/bin/bash

echo "=== INSTALANDO IMAGEMAGICK PARA CONVERTER PSD ==="

# Instalar ImageMagick
echo "1. Instalando ImageMagick..."
sudo apt update
sudo apt install -y imagemagick

# Verificar instalação
echo "2. Verificando instalação..."
convert -version

# Converter PSD para PNG
echo "3. Convertendo PSD para PNG..."
convert public/images/banners/church-worship-social-media-facebook-cover-banner-template-premium/586.psd public/images/banners/586.png

# Verificar resultado
echo "4. Verificando arquivo criado..."
ls -la public/images/banners/586.png

echo "=== CONCLUÍDO ==="
