usar este htaccess

````
    RewriteEngine On
    Options All -Indexes

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?aplication=/$1 [L,QSA]
````