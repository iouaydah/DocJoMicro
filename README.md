# DocJoMicro
Microservices Challenge
version: '3'
services:

  webserver:
    image: nginx:stable-alpine
    tty: true
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./apps/selfservice/:/var/www/selfservice
      - ./apps/mailerservice/:/var/www/mailerservice
      - ./docker/nginx/nginx.conf:/etc/nginx/nginx.conf
      - ./docker/nginx/sites/:/etc/nginx/conf.d/
      - ./docker/nginx/ssl/:/etc/ssl/
    networks:
      - app-network

  selfservice:
    build:
      context: apps/selfservice
      dockerfile: Dockerfile
    image: digitalocean.com/php
    restart: unless-stopped
    tty: true
    ports:
      - "9002:9002"
    environment:
      SERVICE_NAME: selfservice
      SERVICE_TAGS: dev
    working_dir: /var/www/selfservice
    command: php -S localhost:9002 -t public
    volumes:
      - ./apps/selfservice/:/var/www/selfservice
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - app-network

  mailerservice:
    build:
      context: apps/mailerservice
      dockerfile: Dockerfile
    image: digitalocean.com/php
    restart: unless-stopped
    tty: true
    ports:
      - "9001:9001"
    environment:
      SERVICE_NAME: mailerservice
      SERVICE_TAGS: dev
    working_dir: /var/www/mailerservice
    command: php -S localhost:9001 -t public
    volumes:
      - ./apps/mailerservice/:/var/www/mailerservice
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - app-network

  db:
    image: mysql/mysql-server:latest
    tty: true
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: showcase
      MYSQL_USER: root
      MYSQL_ROOT_PASSWORD: 
      SERVICE_NAME: mysql
      SERVICE_TAGS: dev
    command: mysqld --default-authentication-plugin=mysql_native_password
    volumes:
       - ./database/mysql-data:/var/lib/mysql:rw
      
    networks:
      - app-network

networks:
  app-network:
    driver: bridge

volumes:
  mysql_data:
