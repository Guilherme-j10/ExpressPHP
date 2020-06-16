# EexpressPHP @elevenstack

pacote para roteamento de rotas inpirado no expressjs do nodejs, para quem é familiarizado com o expressjs o expressphp não sera nada complicado.

## Installation


## Documentation
````
RewriteEngine On
Options All -Indexes

# ROUTER WWW Redirect.
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# ROUTER HTTPS Redirect
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?aplication=/$1 [L,QSA]
````