# 🏁 Início do Dockerfile

# 📦 Use a imagem oficial do PHP com Apache
FROM php:8.2-apache as development
WORKDIR /var/www/html
RUN echo "🚀 Configurando ambiente de trabalho..."

# 🛠️ Habilita o mod_rewrite do Apache para suportar reescrita de URL via .htaccess
RUN echo "🚀 Habilitando mod_rewrite do Apache..." && a2enmod rewrite

# 🛠️ Instala as ferramentas de compilação necessárias
RUN echo "🚀 Instalando ferramentas de compilação..." && apt-get update && apt-get install -y \
    gcc \
    make \
    autoconf \
    curl \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# 🛠️ Instala extensões e dependências necessárias
RUN echo "🚀 Instalando extensões e dependências necessárias..." && apt-get update && apt-get install -y \
    libbz2-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    libssl-dev \
    libldap-dev \
    libpcre3-dev \
    libmariadb-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    libldap2-dev \
    libgd-dev \
    libpq-dev

# 🛠️ Remove extensões PHP padrão
RUN echo "🚀 Removendo extensões PHP padrão..." && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo_mysql \
    ctype \
    soap \
    session \
    dom

# 🛠️ Instala extensões PHP adicionais
RUN echo "🚀 Instalando extensões PHP adicionais..." && docker-php-ext-install -j$(nproc) \
    bcmath \
    zip \
    intl \
    gd \
    bz2 \
    mbstring \
    pgsql \
    opcache

# 🛠️ Define o diretório raiz do documento Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN echo "🚀 Definindo diretório raiz do documento Apache..." \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 🛠️ Habilita os módulos Apache
RUN echo "🚀 Habilitando módulos Apache..." && a2enmod rewrite setenvif

# 📄 Instala o Composer
RUN echo "🚀 Instalando Composer..." \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 📄 Copia os arquivos do projeto para o container
COPY . /var/www/html
RUN echo "🚀 Copiando arquivos do projeto para o container..."

# 🛠️ Instala as dependências do Composer
RUN composer install

# 🛠️ Ajusta as permissões dos arquivos e diretórios
RUN echo "🚀 Ajustando permissões dos arquivos e diretórios..." \
    && chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;


# Expose ports
EXPOSE 80
RUN echo "🚀 Expondo porta 80..."

# 🏁 Fim do Dockerfile
