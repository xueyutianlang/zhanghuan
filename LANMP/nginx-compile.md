
##Centos 6.5 编译安装 nginx (lnmp)
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)
1.安装前准备软件下载

   下载 nginx-1.5.13.tar.gz
   下载 pcre-8.36.tar.bz2

2.安装必要的编译器

   yum -y install gcc openssl-devel pcre-devel zlib-devel gcc-c++ libtool

3.安装pcre-devel 
   
   目的:Nginx支持http rewrite的模块
      
```javascript
   cd  /usr/local/src
   tar -jxvf pcre-8.36.tar.bz2
   cd  ./pcre-8.36
   ./configure  --prefix=/usr/local/pcre 
   make && make install
```
4.安装nginx

   若编译参数添加 gzip 压缩模块，还需要编译zlib-devel 包
   yum -y install  zlib-devel
   
```javascript
   cd /usr/local/src
   tar -zxvf nginx-1.5.13.tar.gz
   cd nginx-1.5.13
   ./configure --prefix=/usr/local/nginx \
      --without-http_autoindex_module \
      --without-http_geo_module \
      --without-http_map_module \
      --without-http_browser_module \
      --with-http_stub_status_module \ #可以用来启用Nginx的NginxStatus功能，以监控Nginx的当前状态。
      --with-http_realip_module \
      --with-http_gzip_static_module \ #支持在线实时压缩输出数据流。 
      --with-pcre=../pcre-8.36 #pcre解压缩包的路径(/usr/local/src/pcre-8.36),非pcre的安装目录
    make && make install 
```
    若启动Nginx出现的问题：
```javascript    
    /usr/local/nginx/sbin/nginx
```
    /usr/local/nginx/sbin/nginx: error while loading shared libraries: libpcre.so.1: cannot open shared object file: No such file or directory

    从错误看出是缺少lib文件导致，进一步查看下
```javascript
    ldd $(which /usr/local/nginx/sbin/nginx)
```
    linux-gate.so.1 => (0x0071b000)
    libpthread.so.0 => /lib/libpthread.so.0 (0×00498000)
    libcrypt.so.1 => /lib/libcrypt.so.1 (0×00986000)
		libpcre.so.1 => not found
		libcrypto.so.6 => /lib/libcrypto.so.6 (0×00196000)
		libz.so.1 => /lib/libz.so.1 (0×00610000)
		libc.so.6 => /lib/libc.so.6 (0x002d7000)
		/lib/ld-linux.so.2 (0x006a8000)
        libdl.so.2 => /lib/libdl.so.2 (0x008c3000)
        可以看出 libpcre.so.1 => not found 并没有找到，进入/lib目录中手动链接下
```javascript    
    ln -s libpcre.so.0.0.1 libpcre.so.1
```
   Notice : 若本机上还有其他服务器例如apache 会出现端口占用的问题，需要修改下nginx 默认端口 80 为其他端口

