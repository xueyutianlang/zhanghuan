
##Centos 6.5 编译安装 apache (lnmp)
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)
1.安装前准备软件下载
    
    1)下载apache 
       
        wget http://mirror.bit.edu.cn/apache/httpd/httpd-2.4.18.tar.gz 
    
    2)下载apr(Apache库文件)

　　    wget mirror.bit.edu.cn/apache/apr/apr-1.5.0.tar.gz

　　3)下载apr-util(Apache库文件)

　　    wget mirror.bit.edu.cn/apache/apr/apr-util-1.5.3.tar.gz
   



2.安装apr
      
```javascript
   cd  /usr/local/src
   tar -jxvf apr-1.5.0.tar.gz
   cd  ./apr-1.5.0
   ./configure  --prefix=/usr/local/apr
   make && make install
```
3.安装apr-util

```javascript
   cd  /usr/local/src
   tar -jxvf apr-util-1.5.3.tar.gz
   cd  ./apr-util-1.5.3
   ./configure  --prefix=/usr/local/apr-util  --with-apr=/usr/local/apr/bin/apr-1-config
   make && make install
```
4.安装apache
   
```javascript
   cd /usr/local/src
   groupadd www #添加www组
   groupadd www #添加www组
   useradd -g www www -s /bin/false #创建apache运行账号www并加入www组,且不允许www用户直接登录系统
   tar -zxvf httpd-2.4.18.tar.gz
   cd httpd-2.4.18
   ./configure \
      --prefix=/usr/local/apache2 \
      --with-apr-util=/usr/local/apr-util \
      --with-ssl \
      --enable-ssl \
      --enable-module=so \                   #支持so 模块是用来提 DSO 支持的 apache 核心模块
      --enable-rewrite \                     #支持url重写
      --enable-cgid \
      --enable-cgi 
     
      --enable-defalte=shared  \ #支持网页压缩
      --enable-expires=shared  \ #支持http控制
      --enable-cache           \ #支持缓存
      --enable-file-cache \ #支持文件缓存
      --enable-mem-cache  \ #支持记忆缓存
      --enable-disk-cache \ #支持磁盘缓存
      #--enable-static-support   \ #支持静态连接(默认为动态连接)
      #--enable-static-htpasswd   \ #使用静态连接编译 htpasswd – 管理用于基本认证的用户文件
      #--enable-static-htdigest   \ #使用静态连接编译 htdigest – 管理用于摘要认证的用户文件
      #--enable-static-rotatelogs  \ #使用静态连接编译 rotatelogs – 滚动 Apache 日志的管道日志程序
      #--enable-static-logresolve  \ #使用静态连接编译 logresolve – 解析 Apache 日志中的IP地址为主机名
      #--enable-static-htdbm   \ #使用静态连接编译 htdbm – 操作 DBM 密码数据库
      --enable-static-ab  \ #使用静态连接编译 ab – Apache HTTP 服务器性能测试工具
     
      #--enable-static-checkgid   \ #使用静态连接编译 checkgid
      #--disable-cgid   \ # 禁止用一个外部 CGI 守护进程执行CGI脚本
      #--disable-cgi   \ # 禁止编译 CGI 版本的 PHP
      #--disable-userdir  \ # 禁止用户从自己的主目录中提供页面
      --with-mpm=worker \ # 让apache以worker方式运行
      --enable-authn-dbm=shared \ # 对动态数据库进行操作。Rewrite时需要。
      
      #用于apr的configure脚本的选项：
      #--enable-experimental-libtool \ #启用试验性质的自定义libtool
      #--disable-libtool-lock \ #取消锁定(可能导致并行编译崩溃)
      --enable-debug \ #启用调试编译，仅供开发人员使用。    
      --enable-profile \ #打开编译profiling(GCC)
      #--enable-pool-debug[=yes|no|verbose|verbose-alloc|lifetime|owner|all] \ # 打开pools调试

      --enable-malloc-debug \ #打开BeOS平台上的malloc_debug
      --disable-lfs \ # 在32-bit平台上禁用大文件支持(large file support)
      --enable-nonportable-atomics \ #若只打算在486以上的CPU上运行Apache ，那么使用该选项可以启用更加高效的基于互斥执行的原子操作。
      --enable-threads \ #启用线程支持，在线程型的MPM上必须打开它
      #--disable-threads \ #禁用线程支持，如果不使用线程化的MPM ，可以关闭它以减少系统开销。

      #--disable-dso \ #禁用DSO支持
      --enable-other-child \ #启用可靠子进程支持
      #--disable-ipv6 \ #禁用IPv6支持
      #--with-gnu-ld \ #指定C编译器使用 GNU ld
      #--with-pic \ #只使用 PIC/non-PIC 对象[默认为两者都使用]
      #--with-tags[=TAGS] \ #包含额外的配置
      #--with-installbuilddir=DIR \ #指定APR编译文件的存放位置(默认值为：’${datadir}/build’)
      #--without-libtool \ #禁止使用libtool连接库文件
      #--with-efence[=DIR] \ #指定Electric Fence的安装目录
      #--with-sendfile \ #强制使用sendfile(译者注：Linux2.4/2.6内核都支持)
      #--with-egd[=DIR] \ #使用EDG兼容的socket
      #--with-devrandom[=DEV] \ #指定随机设备[默认为：/dev/random]

      #用于apr-util的configure脚本的选项：
      --with-apr=/usr/local/apr \ #指定APR的安装目录(–prefix选项值或apr-config的路径)
      #--with-ldap-include=PATH \ #ldap包含文件目录(带结尾斜线)
      #--with-ldap-lib=PATH \ #ldap库文件路径
      #--with-ldap=library \ #使用的ldap库
      #--with-dbm=DBM \ #选择使用的DBM类型DBM={sdbm,gdbm,ndbm,db,db1,db185,db2,db3,db4,db41,db42,db43,db44}
      #--with-gdbm=PATH \ #指定GDBM的位置
      #--with-ndbm=PATH \ #指定NDBM的位置
      #--with-berkeley-db=PATH \ #指定Berkeley DB的位置
      #--with-pgsql=PATH \ #指定PostgreSQL的位置
      #--with-mysql=PATH \ #参看INSTALL.MySQL文件的内容
      #--with-sqlite3=PATH \ #指定sqlite3的位置
      #--with-sqlite2=PATH \ #指定sqlite2的位置
      #--with-expat=PATH \ #指定Expat的位置或’builtin’
      #--with-iconv=PATH \ #iconv的安装目录
    make && make install 
```

启动

```javascript    
    /usr/local/apache2/bin/apachectl -k start
```
编译apache 配置文件
```javascript
    vi /usr/local/apache2/conf/httpd.conf #编辑配置文件

　　找到：#ServerName www.example.com:80

　　修改为：ServerName www.xueyutianlang.com:80

　　找到：DirectoryIndex index.html

　　修改为：DirectoryIndex index.html index.php

　　找到：Options Indexes FollowSymLinks

　　修改为：Options FollowSymLinks #不显示目录结构

　　找到AllowOverride None

　　修改为：AllowOverride All #开启apache支持伪静态，有两处都做修改

　　LoadModule rewrite_module modules/mod_rewrite.so #取消前面的注释，开启apache支持伪静态

```    
添加apache 服务系统变量

vi /etc/profile #添加apache服务系统环境变量

　　在最后添加下面这一行
```javascript
　　export PATH=$PATH:/usr/local/apache2/bin    
```
添加编辑系统启动脚本

```javascript
    cp /usr/local/apache2/bin/apachectl /etc/rc.d/init.d/httpd
    
    在#!/bin/sh下面添加以下两行
    #chkconfig:2345 10 90
　　#descrption:Activates/Deactivates Apache Web Server
```
更改目录用户组权限

```javascript
    chown www.www -R /usr/local/apache2/htdocs #更改目录所有者
　　chmod 700 /usr/local/apache2/htdocs -R #更改apache网站目录权限
```

设置开机自启动

```javascrip
    chkconfig httpd on
    /etc/init.d/httpd start
    server httpd restart
```

NOTICE: 若apache 2.4 搭载 较低版本的php会出现以下情况,建议为了良好向下兼容php，请换较低apache版本
```javascript

httpd: Syntax error on line 154 of /usr/local/apache2/conf/httpd.conf: Cannot load modules/libphp5.so into server: /usr/local/apache2/modules/libphp5.so: undefined symbol: unixd_config

```


