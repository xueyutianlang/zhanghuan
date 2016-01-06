
##Centos 编译安装 php 7 (lnmp)
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)


```javascript
   cd  /usr/local/src
   tar -jxvf php-7.0.1.tar.bz2
   cd  ./php-7.0.1
   ./configure  --prefix=/usr/local/php7 \
      --bindir=/usr/local/php7/bin \
      --sbindir=/usr/local/php7/sbin \
      --includedir=/usr/local/php7/include \
      --libdir=/usr/local/php7/lib/php \
      --mandir=/usr/local/php7/php/man \
      --with-config-file-path=/usr/local/php7/etc \
      --with-libdir=lib64 \
      --with-mysql=/usr/local/mysql \
      --with-mysqli=/usr/local/mysql/bin/mysql_config \
      --with-mysql-sock=/tmp/mysql.sock \
      --with-pdo-mysql=/usr/local/mysql \
      --with-mcrypt=/usr \
      --with-mhash \
      --with-openssl \
      --enable-safe-mode \
      --with-gd \
      --with-iconv \
      --with-zlib \
      --enable-zip \
      --enable-inline-optimization \
      --enable-debug \
      --disable-rpath \
      --enable-shared \
      --enable-xml \
      --enable-bcmath \
      --enable-shmop \
      --enable-sysvsem \
      --enable-mbregex \
      --enable-mbstring \
      --enable-ftp \
      --enable-gd-native-ttf \
      --enable-pcntl \
      --enable-sockets \
      --with-xmlrpc \
      --enable-soap \
      --without-pear \
      --with-gettext \
      --enable-session \
      --with-curl \
      --with-jpeg-dir \
      --with-freetype-dir \
      --enable-opcache \
      --enable-fpm \
      --enable-fastcgi \
      --without-gdbm \
      --disable-fileinfo
   make && make install
```
