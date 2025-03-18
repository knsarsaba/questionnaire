# Use official PHP CLI image
FROM php:8.1-cli

# Set the working directory inside the container
WORKDIR /var/www

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    default-mysql-client

# Install PHP extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-install intl mbstring pdo pdo_mysql mysqli zip xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . .

# Expose port 8000 for the built-in PHP server
EXPOSE 8000

# Default command to start the PHP server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
