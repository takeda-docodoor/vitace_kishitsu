# ベースイメージを指定
FROM php:7.4.33-apache

# mysqliをインストール
RUN docker-php-ext-install mysqli