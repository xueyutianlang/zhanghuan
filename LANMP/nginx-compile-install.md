
##Centos 6.5 编译安装 nginx (lnmp)
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)
1.安装前准备软件下载

   下载 nginx-1.5.13.tar.gz
      wget  http://nginx.org/download/nginx-1.2.3.tar.gz
   下载 pcre-8.36.tar.bz2
      wget  ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.36.tar.gz

2.安装必要的编译器与库文件

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

   
```javascript
   cd /usr/local/src
   groupadd www #添加www组
   groupadd www #添加www组
   useradd -g www www -s /bin/false #创建nginx运行账号www并加入www组,且不允许www用户直接登录系统
   tar -zxvf nginx-1.5.13.tar.gz
   cd nginx-1.5.13
   ./configure --prefix=/usr/local/nginx \
      --sbin-path=/usr/local/nginx/sbin \ # 设定程序文件目录
      --conf-path=/usr/local/nginx/conf \ # 设定配置文件(nginx.conf)目录
      #--error-log-path=PATH \ # 设定错误日志目录
      #--pid-path=PATH \ # 设定pid文件(nginx.pid)目录
      #--lock-path=PATH \ # 设定lock文件(nginx.lock)目录
      --user=www \  # 设定用户
      --group=www \ # 设定组
      #--with-rtsig_module \ # 允许rtsig模块;rtsig模块是一种实时信号，在Linux 2.2.19 默认情况下，实时信号连接数不超过1024，但是对于高负载是肯定不够的。因此通过调整内核参数/proc/sys/kernel/rtsig-max达到效果。但是Linux 2.6.6-mm2开始，这个参数不再可用，并为每个进程有一个独立的信号队列，数字是由RLIMIT_SIGPENDING确定。当队列变得满载时，nginx开始抛弃连接并使用poll方法，直到负载恢复正常。 
      #--with-select_module \ # 允许select模块(一种轮询模式,不推荐用在高载环境)
      --without-select_module \ # 不使用select模块
      #-with-poll_module \ # 允许poll模块(一种轮询模式,不推荐用在高载环境)
      --without-poll_module \ # 不使用poll模块
      --with-http_ssl_module \ # 开启HTTP SSL 模块,支持HTTPS 模块(Apache对应:mod_ssl)
      --with-http_realip_module \ # 允许ngx_http_realip_module模块(mod_rpaf)此模块支持显示真实来源IP地址，主要用于NGINX做前端负载均衡服务器使用。
      --with-http_addition_module \ # 允许ngx_http_addition_module模块(mod_layout),游戏服务器不必安装，门户网站可以安装，有利于被搜索引擎收录页面信息
      --with-http_xslt_module \  # 过滤器，它可以通过XSLT模板转换XML应答。0.7.8后面版本才可以使用。      
      --with-http_sub_module \  # 在nginx的应答中搜索并替换文本。
      --with-http_dav_module \  # 为文件和目录指定权限，限制不同类型的用户对于页面有不同的操作权限
	  --with-http_flv_module \ # 支持对flv文件的拖动播放
      --with-http_gzip_static_module \ # 支持在线实时压缩输出数据流又防止文件被重复压缩。 
      #--with-http_random_index_module \ # 允许ngx_http_random_index_module模块(mod_autoindex)，从目录中选择一个随机主页
      --with-http_stub_status_module \ # 可以用来启用Nginx的NginxStatus功能，以监控Nginx的当前状态。
      #--without-http_charset_module \ # 不使用ngx_http_charset_module模块这个模块将在应答头中为"Content-Type"字段添加字符编码
      #--without-http_ssi_module \ # 不使用ngx_http_ssi_module模块，此模块处理服务器端包含文件(ssi)的处理
      #--without-http_userid_module \ # 不使用ngx_http_userid_module模块The module ngx_http_userid_module gives out cookies for identification of clients
      #--without-http_access_module \
      #--without-http_auth_basic_module \
      --without-http_autoindex_module \ # 不可以浏览网站目录
      #--without-http_geo_module \ # 基于客户端ip地址创建一些ngx_http_geoip_module变量
      #--without-http_map_module \ # 允许分类或者同时映射多个值到多个不同值并存储到一个变量,可用页面跳转后其他域名使用
      #--without-http_referer_module \ # 若请求的referer中包含非法字段,该模块可以禁止请求该站点,防止盗链。
      #--without-http_rewrite_module \ 
      #--without-http_proxy_module   \ # 不适用代理模块
      #--without-http_fastcgi_module \ 
      #--without-http_memcached_module \
      #--without-http_limit_zone_module \ # 可限制并发链接,达到减少攻击的效果
      #--without-http_empty_gif_module  \ # 可在内存中保存一个很小传递很快的1x1透明GIF
      #--without-http_browser_module \ # 识别不同浏览器,页面展示不同的效果
      #--without-http_upstream_ip_hash_module \
      --with-http_perl_module  \ # 允许nginx使用SSI调用perl或者直接执行perl
      #--with-perl_modules_path=PATH \ # 设置perl 模块路径 
      #--with-perl =PATH \ # 设置 perl库文件路径
      #--http-log-path=PATH \ # 设置accesslog 路径
      #--http-client-body-temp-path=PATH \ # 设置客户端临时请求文件
      #--http-proxy-temp-path=PATH \ # 设置代理临时文件
      #--http-fastcgi-temp-path=PATH \ # 设置fastcgi 临时文件
      #--without-http \ #如果只是做代码服务器，可以不提供http服务
      --with-mail 允许POP3/IMAP4/SMTP \ # 代理模块
      --with-mail_ssl_module \ # POP3/IMAP/SMTP 可以使用ssl尽管tls已经定义了http ssl,但不支持客户端证书检验
      --with-http_realip_module \
      #--without-mail_pop3_module \
      #--without-mail_imap_module \
      #--without-mail_smtp_module \
      --with-google_perftools_module \ # 可启动google 性能分析工具
      #--with-cpp_test_module 
      #--add-module=PATH \ # 允许使用外部模块以及路径
      #--with-cc=PATH  \ # 设置c编译器路径
      #--with-cpp=PATH \ # 设置c预处理路径
      #--with-cc-opt=OPTIONS \ # 设置c编译器参数
      #--with-ld-opt=OPTIONS \ # 设置文件链接参数
      --with-cpu-opt=cpu \ # 指定优化cpu,可选参数:pentium pentiumpro pentinum3 pentinum4 athlon opteron sparc32 sparc64 ppc64
 
      #--with-md5= DIR \ # 设定md5库文件路径
      #--with-md5-opt= OPTIONS \ # 设置md5运行参数
      #--with-md5-asm \ # 使用md5源文件编译
      #--with-sha1= DIR \ # 设定sha1库文件路径,sha1 安全哈希算法,主要是数字签名算法 
      #--with-sha1-opt=OPTIONS \ # 设置sha1运行参数
      #--with-sha1-asm \ # 使用sha1源文件编译
      --with-zlib = /usr  \ # 设定zlib库(程序中压缩解压缩)文件路径
      #--with-zlib-opt=OPTIONS \ # 设置zlib运行参数
      --with-zlib-asm=CPU \ # 使zlib对特定的cpu进行优化,可选参数:pentium,pentiumpro
      --with-openssl=/usr \ # 设定OpenSSL库文件路径
      #--with-openssl-opt=OPTIONS \ # 设置OpenSSL 运行参数
      --with-debug 允许日志调试模式 \
      --with-pcre=../pcre-8.36 \ # pcre解压缩包的路径(/usr/local/src/pcre-8.36),非pcre的安装目录
      #--with-pcre-opt=OPTIONS 设置PCRE运行参数
      #--without-pcre \ # 不使用pcre库文件,pcre 是包括perl正则表达式库
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

```javascript
    netstat -tlnp 
    killall -9
``` 
