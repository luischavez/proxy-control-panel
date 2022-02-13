#!/bin/bash

apt install software-properties-common
add-apt-repository -y ppa:ondrej/php

apt-get -y update
apt-get -y upgrade

apt-get -y purge apache2
apt-get -y install zip unzip letsencrypt nginx php8.1 php8.1-fpm php8.1-common php8.1-mysql php8.1-sqlite3 php8.1-xml php8.1-xmlrpc php8.1-curl php8.1-gd php8.1-imagick php8.1-cli php8.1-dev php8.1-imap php8.1-mbstring php8.1-opcache php8.1-soap php8.1-zip php8.1-redis php8.1-intl

ufw default deny incoming
ufw default allow outgoing

ufw allow ssh
ufw allow http
ufw allow https

ufw enable

mkdir /ssl
mkdir /etc/proxy-config
chown -R www-data:www-data /etc/proxy-config

NGINX_CONFIG="
user www-data;
worker_processes auto;
pid /run/nginx.pid;
include /etc/nginx/modules-enabled/*.conf;

events {
    worker_connections 768;
}

http {
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;

    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    ssl_protocols TLSv1 TLSv1.1 TLSv1.2 TLSv1.3; # Dropping SSLv3, ref: POODLE
    ssl_prefer_server_ciphers on;

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    gzip on;

    include /etc/nginx/conf.d/*.conf;
    include /etc/nginx/sites-enabled/*;
    include /etc/proxy-config/*;
}
"

CERT_DOMAIN_COMMAND="
#!/bin/bash

service nginx stop
certbot certonly --standalone --preferred-challenges=http --non-interactive --agree-tos -m admin@\$1 -d \$1
service nginx start
"

CERT_SUBDOMAIN_COMMAND="
#!/bin/bash

service nginx stop
certbot certonly --standalone --preferred-challenges=http --non-interactive --agree-tos -m admin@\$1 -d \$2.\$1
service nginx start
"

DEPLOY_COMMAND="
#!/bin/bash

CONFIG_DEFAULT=\"
server {
    listen 80;
    listen 443 ssl;

    server_name _;

    ssl_certificate        /etc/letsencrypt/live/\$1/fullchain.pem;
    ssl_certificate_key    /etc/letsencrypt/live/\$1/privkey.pem;

    return 301 https://\$1;
}
\"

CONFIG_PANEL=\"
server {
    listen 443 ssl;

    ssl_certificate        /etc/letsencrypt/live/\$2.\$1/fullchain.pem;
    ssl_certificate_key    /etc/letsencrypt/live/\$2.\$1/privkey.pem;

    server_name \$2.*;
    root /var/www/\$2/public;

    add_header X-Frame-Options \\\"SAMEORIGIN\\\";
    add_header X-XSS-Protection \\\"1; mode=block\\\";
    add_header X-Content-Type-Options \\\"nosniff\\\";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files \\\$uri \\\$uri/ /index.php?\\\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \\\$realpath_root\\\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
\"

rm /etc/nginx/sites-available/default
echo \"\$CONFIG_DEFAULT\" > /etc/nginx/sites-available/default
echo \"\$CONFIG_PANEL\" > /etc/nginx/sites-available/proxy-control-panel
ln -s /etc/nginx/sites-available/proxy-control-panel /etc/nginx/sites-enabled

generate-cert-domain.sh \$1
generate-cert-subdomain.sh \$1 \$2

unzip /tmp/proxy-control-panel.zip -d /var/www
chown -R www-data:www-data /var/www/\$2
chmod -R ug+rwx /var/www/\$2/storage /var/www/\$2/bootstrap/cache
"

service nginx stop
rm /etc/nginx/nginx.conf
echo "$NGINX_CONFIG" > /etc/nginx/nginx.conf
service nginx start

echo "$CERT_DOMAIN_COMMAND" > /bin/generate-cert-domain.sh
echo "$CERT_SUBDOMAIN_COMMAND" > /bin/generate-cert-subdomain.sh
echo "$DEPLOY_COMMAND" > /bin/deploy-proxy-control-panel.sh

chmod +x /bin/generate-cert-domain.sh
chmod +x /bin/generate-cert-subdomain.sh
chmod +x /bin/deploy-proxy-control-panel.sh

cat >> /etc/sudoers << EOF
www-data ALL=(ALL:ALL) NOPASSWD:/bin/generate-cert-domain.sh
www-data ALL=(ALL:ALL) NOPASSWD:/bin/generate-cert-subdomain.sh
www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/nginx -t
www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/service nginx reload
EOF
