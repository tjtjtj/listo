tjtjtj/listo
============

Amazon S3 RESTful API compatible object storage server.

### Use PHP Built-in Server + Local File System

Server installation

```
git clone https://github.com/tjtjtj/listo.git
cd listo
composer install
mkdir -p buckets/mybucket
php -S 0.0.0.0:8080 -t web web/index_dev.php
```

S3Client configuration

```
Service point: localhost:8080
Access key: asdf
Secret key: asdf(no validation)
```

