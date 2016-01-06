
##Centos 编译安装 php 5.4 (lnmp)
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)
### 该编译参数中未与apache 整合,服务器使用apache 或者 nginx 考虑实际情况。

```javascript
   cd  /usr/local/src
   tar -zxvf php-5.4.27.tar.gz
   cd  ./php-5.4.27
   ./configure --prefix=/usr/local/php54 \
    --with-config-file-path=/usr/local/php54/etc  \ 
    --with-mysql=/usr/local/mysql \
    --with-mysqli=/usr/local/mysql/bin/mysql_config \
    --with-iconv=/usr/local/libiconv \
    --with-freetype-dir\
    --with-jpeg-dir \
    --with-png-dir \
    --with-zlib \
    --with-libxml-dir=/usr \
    --enable-xml \
    --disable-rpath \
    --enable-discard-path \
    --enable-safe-mode \
    --enable-bcmath \
    --enable-shmop \
    --enable-sysvsem \
    --enable-inline-optimization \
    --with-curl \
    --enable-mbregex \
    --enable-fastcgi \
    --enable-fpm \
    --enable-force-cgi-redirect \
    --enable-mbstring \
    --with-mcrypt=/usr \
    --with-openssl \
    --with-mhash \
    --enable-pcntl \
    --enable-sockets \
    --with-ldap \
    --with-ldap-sasl \
    --with-xmlrpc \
    --enable-zip \
    --enable-soap \
    --enable-opcache
   make && make install
```

