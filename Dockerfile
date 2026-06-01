FROM php:8.2-apache

# Set timezone di level OS Debian (Debian sudah mendefinisikan symlink zoneinfo)
RUN ln -sf /usr/share/zoneinfo/Asia/Makassar /etc/localtime \
    && echo "Asia/Makassar" > /etc/timezone

# Atur konfigurasi PHP untuk menggunakan timezone Asia/Makassar
RUN echo "date.timezone = Asia/Makassar" > /usr/local/etc/php/conf.d/timezone.ini

# Pindahkan working directory ke folder apache
WORKDIR /var/www/html

# Pastikan Apache memiliki hak akses penuh untuk menulis file log (access.log)
RUN chown -R www-data:www-data /var/www/html