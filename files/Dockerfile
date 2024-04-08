# Imagem base com PHP e Composer instalados
FROM php:8-fpm

# Atualiza a lista de pacotes e instala algumas dependências úteis
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuração do diretório de trabalho
WORKDIR /var/www/html

# Copia o código do projeto Laravel para o diretório de trabalho
COPY . .

# Instala as dependências do Laravel usando o Composer
RUN composer install

# Exponha a porta do servidor web
EXPOSE 9000

# Inicie o servidor PHP-FPM
CMD ["php-fpm"]
