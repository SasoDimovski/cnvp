# Користиме лесен и сигурен nginx image
FROM nginx:1.27-alpine

# Поставуваме работен директориум
WORKDIR /var/www

# Копираме nginx конфигурација
COPY ./.docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./.docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Дозволи за root и nginx корисник
RUN chown -R nginx:nginx /var/www \
    && chmod -R 755 /var/www

# Експонираме порта 80
EXPOSE 80

# Дефинираме default команда за стартување на nginx
CMD ["nginx", "-g", "daemon off;"]
