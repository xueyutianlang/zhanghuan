
##Centos 编译安装 php 5.2.17 (lnmp)
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)
### 编译前请先参考 lnamp-install-preparation.md 查看是否需要安装相关类库和编译器。
### 该编译参数中与服务器使用apache整合 若使用nginx服务器可在编译参数去掉apache整合参数，个人考虑实际情况。

```javascript
   cd  /usr/local/src
   
   #下载php-5.2.17.tar.gz 软件包   
   wget https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/lnamp-web-server/php-5.2.17.tar.gz
   tar -zxvf php-5.2.17.tar.gz
   cd  ./php-5.2.17
 
   #因php 5.3.3 之前的版本来说php-fpm一直是以补丁包形式存在，故需下载安装补丁包
   wget -c http://php-fpm.org/downloads/php-5.2.17-fpm-0.5.14.diff.gz
   # 若本机无补丁包装命令需要下载
   yum -y install patch
   gzip -d php-5.2.17-fpm-0.5.14.diff.gz
   patch -p1 < php-5.2.17-fpm-0.5.14.diff   

   ./configure --prefix=/usr/local/php \
    --disable-rpath \
    --enable-mod-charset \
    --with-apxs2=/usr/local/apache2/bin/apxs \
    --enable-embed=shared \
    --enable-roxen-zts \
    --enable-fastcgi \
    --enable-force-cgi-redirect \
    --enable-discard-path \
    --enable-fpm \
    --enable-debug \
    --with-config-file-path=/usr/local/php/etc \
    --with-config-file-scan-dir=/usr/local/php/etc/php.d \
    --enable-safe-mode \
    --enable-magic-quotes \
    --enable-dmalloc \
    --with-libxml \
    --with-openssl \
    --with-kerberos \
    --with-zlib \
    --enable-bcmath \
    --with-bz2 \
    --with-curl \
    --enable-exif \
    --with-pcre-dir \
    --enable-ftp \
    --with-gd \
    --with-ttf \
    --enable-gd-native-ttf \
    --enable-mbstring \
    --with-mcrypt \
    --with-mhash \
    --with-mysql=/usr/local/mysql \
    --with-mysql-sock=/tmp/mysql.sock \
    --with-jpeg-dir \
    --with-png-dir \
    --with-zlib-dir \
    --with-mysqli=/usr/local/mysql/bin/mysql_config \
    --with-ncurses \
    --enable-pcntl \
    --with-pdo-mysql \
    --enable-shmop \
    --enable-session \
    --enable-soap \
    --enable-sockets  \
    --without-sqlite \
    --enable-sqlite-utf8 \
    --enable-sysvmsg \
    --enable-sysvsem \
    --enable-sysvshm \
    --with-tidy \
    --enable-zip \
    --with-pear  \
    --enable-shared

   ./configure --prefix=/usr/local/php \
    --with-config-file-path=/usr/local/php/etc  \ 
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

php 5.2 编译参数详解
Configuration:
  --cache-file=file       #指定测试结果文件目录
  --help 
  --no-create	          #configure脚本运行结束后不输出结果文件，常用于正式编译前的测试。
  --quiet, --silent       # 不显示 configure 自检信息;do not print `checking...` messages
  --version               
Directory and file names:
  --prefix=PREFIX         #体系无关安装目录.
  --exec-prefix=EPREFIX   #体系相关文件的顶级安装目录EPREFIX ，把体系相关的文件安装到不同的位置可以方便地在不同主机之间共享体系相关的文件.
  --bindir=DIR            # 用户执行文件目录 user executables in DIR [EPREFIX/bin]
  --sbindir=DIR           # 系统管理员执行文件目录,存放运行PHP服务器所必须的服务程序; system admin executables in DIR [EPREFIX/sbin]
  --libexecdir=DIR        # 程序执行文件目录,动态模块加载目录  program executables in DIR [EPREFIX/libexec]
  --datadir=DIR           # 只读依赖文件数据目录 read-only architecture-independent data in DIR
                          [PREFIX/share]
  --sysconfdir=DIR        # 只读单机数据,存放服务设置相关文件  read-only single-machine data in DIR [PREFIX/etc]
  --sharedstatedir=DIR    # 可修改与体系结构无关的数据目录  modifiable architecture-independent data in DIR
                          [PREFIX/com]
  --localstatedir=DIR     # 可修改的单机数据目录  modifiable single-machine data in DIR [PREFIX/var]
  --libdir=DIR            # 类库  object code libraries in DIR [EPREFIX/lib]
  --includedir=DIR        # 加载php c 头文件目录 C header files in DIR [PREFIX/include]
  --oldincludedir=DIR     # 加载非 gcc 头文件目录  C header files for non-gcc in DIR [/usr/include]
  --infodir=DIR           # 明细 info documentation in DIR [PREFIX/info]
  --mandir=DIR            # 手册文档 man documentation in DIR [PREFIX/man]
  --srcdir=DIR            # 源文件所在目录 find the sources in DIR [configure dir or ..]
  --program-prefix=PREFIX prepend PREFIX to installed program names
  --program-suffix=SUFFIX append SUFFIX to installed program names
  --program-transform-name=PROGRAM
                          # 程勋运行时，要运行sed 脚本 run sed PROGRAM on installed program names
# 交叉编译的选项Host type:
  --build=BUILD           # 编译工具所在系统的系统类型BUILD configure for building on BUILD [BUILD=HOST]
  --host=HOST             # 指定Apache HTTP服务器将要进行交叉编译时运行的目标系统类型HOST configure for HOST [guessed]
  --target=TARGET         # 指定交叉编译产生目标代码类型 configure for TARGET [TARGET=HOST]
# 特征选项 Features and packages:
  --disable-FEATURE       # 关闭选项特征 do not include FEATURE (same as --enable-FEATURE=no)
  --enable-FEATURE[=ARG]  include FEATURE [ARG=yes]
  --with-PACKAGE[=ARG]    # 使用封装 use PACKAGE [ARG=yes]
  --without-PACKAGE       do not use PACKAGE (same as --with-PACKAGE=no)
  --x-includes=DIR        # 在目录中 x 头文件 X include files are in DIR
  --x-libraries=DIR       # 在目录中包含 X library files are in DIR
--enable and --with options recognized:
  --with-libdir=NAME      # 库文件查找路径设置…/XXX/lib/ Look for libraries in .../NAME rather than .../lib
  --disable-rpath         # 禁止传递额外运行时候库搜索路径 Disable passing additional runtime library
                          search paths

SAPI modules:

  --with-aolserver=DIR    # 指定aolserver服务器安装路径 Specify path to the installed AOLserver
  --with-apxs[=FILE]      # 编译出共享的apache 1.x版本的共享模块; 参数 FILE 是可选路径apache apxs tool[apache 服务器扩展功能模块] Build shared Apache 1.x module. FILE is the optional
                          pathname to the Apache apxs tool [apxs]
  --with-apache[=DIR]     # 建立 apache 模块; 参数DIR Apache 安装根目录;Build Apache 1.x module. DIR is the top-level Apache
                          build directory [/usr/local/apache]
  --enable-mod-charset    # 为apache的mod_charset模块启用传输表模式。(俄文的apache使用) APACHE: Enable transfer tables for mod_charset (Rus Apache)
  --with-apxs2filter[=FILE]   
                          # 实验性：编译apache2.0的共享过滤模块。参数是apache apxs工具的路径文件 EXPERIMENTAL: Build shared Apache 2.0 Filter module. FILE is the optional
                          pathname to the Apache apxs tool [apxs]
  --with-apxs2[=FILE]     # 编译共享的apache2.0处理程序的模块。参数是apache apxs工具的路径文件 Build shared Apache 2.0 Handler module. FILE is the optional
                          pathname to the Apache apxs tool [apxs]
  --with-apache-hooks[=FILE]      
                          # 实验性:编译共享的apache1.0的hooks模块。参数是apache apxs工具的路径文件 EXPERIMENTAL: Build shared Apache 1.x module. FILE is the optional
                          pathname to the Apache apxs tool [apxs]
  --with-apache-hooks-static[=DIR]
                          # 实验性：编译apache1.x的hooks模块。参数是apache 安装顶级的路径文件EXPERIMENTAL: Build Apache 1.x module. DIR is the top-level Apache
                          build directory [/usr/local/apache]
  --with-caudium[=DIR]    # 为Caudium服务器编译Pick模块。参数为Caudium软件的目录 Build PHP as a Pike module for use with Caudium.
                          DIR is the Caudium server dir [/usr/local/caudium/server]
  --disable-cli           # 编译禁用CLI的PHP版本。这个参数需要–without-pear (this forces –without-pear) Disable building CLI version of PHP
                          (this forces --without-pear)
  --with-continuity=DIR   # 编译php为连续服务模块。参数为安装Continuity Server的根目录。 Build PHP as Continuity Server module. 
                          DIR is path to the installed Continuity Server root
  --enable-embed[=TYPE]   # 实验性：建立内嵌的SAPI库。参数为shared、static。EXPERIMENTAL: Enable building of embedded SAPI library
                          TYPE is either 'shared' or 'static'. [TYPE=shared]
  --with-isapi[=DIR]      # 为Zeus web服务器建立ISAPI模块。 Build PHP as an ISAPI module for use with Zeus
  --with-milter[=DIR]     # 编译PHP为Milter(协议)应用程序 Build PHP as Milter application
  --with-nsapi=DIR        # 为Netscape/iPlanet/Sun Web服务器编译PHP为NSAPI模块。Build PHP as NSAPI module for Netscape/iPlanet/Sun Webserver
  --with-phttpd=DIR       # 编译PHP为phttpd模块 Build PHP as phttpd module
  --with-pi3web[=DIR]     # 编译PHP为Pi3web模块 Build PHP as Pi3Web module
  --with-roxen=DIR        # 编译PHP为Pike模块。参数为ROXEN软件的路径。 Build PHP as a Pike module. DIR is the base Roxen
                          directory, normally /usr/local/roxen/server
  --enable-roxen-zts      # 编译Roxen的模块，使用Zend线程安全模式。 ROXEN: Build the Roxen module using Zend Thread Safety
  --with-thttpd=SRCDIR    # 编译PHP为thttpd模块 Build PHP as thttpd module
  --with-tux=MODULEDIR    # 编译PHP为TUX模块（仅适用于linux下） Build PHP as a TUX module (Linux only)
  --with-webjames=SRCDIR  # 编译PHP为WebJames模块（仅适用于RISC系统）Build PHP as a WebJames module (RISC OS only)
  --disable-cgi           # 编译禁用cgi 版本的php Disable building CGI version of PHP
  --enable-fastcgi        # 编译支持fastcig版本 php   CGI: Enable FastCGI support in the CGI binary
  --enable-force-cgi-redirect # 启用内附服务重定向的安全检查。如果使用在Apache下运行PHP的CGI则使用此项。
                            CGI: Enable security chz`eck for internal server
                            redirects. Use this if you run the PHP CGI with Apache
  --enable-discard-path   # 当此项启用时PHP CGI二进制能够安全的代替外网树并且能够防止人们绕过.htaccess的安全。  CGI: When this is enabled the PHP CGI binary can 
                            safely be placed outside of the web tree and people
                            will not be able to circumvent .htaccess security
  --disable-path-info-check # 禁用url参数。如果此项启用，则如/info.php/test?a=b将不工作。CGI: If this is disabled, paths such as
                            /info.php/test?a=b will fail to work
  --enable-fpm              FastCGI: If this is enabled, the fastcgi support
                            will include experimental process manager code
  --with-fpm-conf=PATH        Set the path for php-fpm configuration file [PREFIX/etc/php-fpm.conf]
  --with-fpm-log=PATH         Set the path for php-fpm log file [PREFIX/logs/php-fpm.log]
  --with-fpm-pid=PATH         Set the path for php-fpm pid file [PREFIX/logs/php-fpm.pid]
  --with-xml-config=PATH      FPM: use xml-config in PATH to find libxml

# 普通参数 General settings:

  --enable-gcov           # 请用GCOV代码覆盖率（仅用于开发人员使用） Enable GCOV code coverage (requires LTP) - FOR DEVELOPERS ONLY!!
  --enable-debug          # Compile with debugging symbols
  --with-layout=TYPE      # 显示安装文件的布局。参数为PHP或GNU Set how installed files will be laid out.  Type can
                          be either PHP or GNU [PHP]
  --with-config-file-path=PATH
                          Set the path in which to look for php.ini [PREFIX/lib]
  --with-config-file-scan-dir=PATH
                          Set the path where to scan for configuration files
  --enable-safe-mode      Enable safe mode by default
  --with-exec-dir[=DIR]   # 在安全模式目录下仅允许可执行文件 Only allow executables in DIR under safe-mode
                          [/usr/local/php/bin]
  --enable-sigchild       # 使用PHP自带的SIGCHLD(信号)处理器 Enable PHP's' own SIGCHLD handler
  --enable-magic-quotes   # 默认激活magic quotes。可让程序在执行时自动加入反斜线的引入字符 Enable magic quotes by default.
  --enable-libgcc         # 启用libgcc的精确链接 Enable explicitly linking against libgcc
  --disable-short-tags    #  默认禁用短形式的<?作为php代码的开始标记 Disable the short-form <? start tag by default
  --enable-dmalloc        # 启用dmalloc（dmalloc是Linux C编程侦测记忆体溢出工具）Enable dmalloc
  --disable-ipv6          Disable IPv6 support
  --enable-fd-setsize     # 设置描述集的大小 Set size of descriptor sets

Extensions:

  --with-EXTENSION=[shared[,PATH]]
  
    NOTE: Not all extensions can be build as 'shared'.

    Example: --with-foobar=shared,/usr/local/foobar/

      o Builds the foobar extension as shared extension.
      o foobar package install prefix is /usr/local/foobar/


 --disable-all   # 关闭默认为启用的所有扩展功能 Disable all extensions which are enabled by default

  --disable-libxml        # 禁用LIBXML支持 Disable LIBXML support
  --with-libxml-dir[=DIR]   LIBXML: libxml2 install prefix
  --with-openssl[=DIR]    # 启用openssl支持 Include OpenSSL support (requires OpenSSL >= 0.9.6)
  --with-kerberos[=DIR]   # 开启   OPENSSL: Include Kerberos support
  --without-pcre-regex    # 禁用pcre（perl兼容正则表达式）支持。Do not include Perl Compatible Regular Expressions support.
                          DIR is the PCRE install prefix [BUNDLED]
  --with-zlib[=DIR]       # 启动 zlib Include ZLIB support (requires zlib >= 1.0.9)
  --with-zlib-dir=<DIR>   Define the location of zlib install directory
  --enable-bcmath         # 启用bcmatch（公元前风格精度数学） Enable bc style precision math functions
  --with-bz2[=DIR]        # 启用 bzip2 压缩 Include BZip2 support
  --enable-calendar       # 启用日历转换支持 Enable support for calendar conversion
  --disable-ctype         # 禁用ctype功能 Disable ctype functions
  --with-curl[=DIR]       # 启动 curl  Include cURL support
  --with-curlwrappers     # 使用cURL作为网址流 EXPERIMENTAL: Use cURL for url streams
  --enable-dba            # 构架捆绑模块的DBA。要建立扩展的共享模块使用–enable-dba=shared参数。 Build DBA with bundled modules. To build shared DBA
                          extension use --enable-dba=shared
  --with-qdbm[=DIR]         DBA: QDBM support
  --with-gdbm[=DIR]         DBA: GDBM support
  --with-ndbm[=DIR]         DBA: NDBM support
  --with-db4[=DIR]          DBA: Berkeley DB4 support
  --with-db3[=DIR]          DBA: Berkeley DB3 support
  --with-db2[=DIR]          DBA: Berkeley DB2 support
  --with-db1[=DIR]          DBA: Berkeley DB1 support/emulation
  --with-dbm[=DIR]          DBA: DBM support
  --without-cdb[=DIR]       DBA: CDB support (bundled)
  --disable-inifile         DBA: INI support (bundled)
  --disable-flatfile        DBA: FlatFile support (bundled)
  --enable-dbase          Enable the bundled dbase library
  --disable-dom           Disable DOM support
  --with-libxml-dir[=DIR]   DOM: libxml2 install prefix
  --enable-exif           # 启用EXIF支持（从图片中获取元数据）Enable EXIF (metadata from images) support
  --with-fbsql[=DIR]      # 包含FrontBase支持 Include FrontBase support. DIR is the FrontBase base directory
  --with-fdftk[=DIR]      # 支持 fpf Include FDF support
  --disable-filter        # 禁用过滤支持 Disable input filter support
  --with-pcre-dir           FILTER: pcre install prefix
  --enable-ftp            # 启用ftp支持 Enable FTP support
  --with-openssl-dir[=DIR] # 指定openssl的安装目录 FTP: openssl install prefix
  --with-gd[=DIR]         # 启用GD支持并指定GD库的安装目录 Include GD support.  DIR is the GD library base
                          install directory [BUNDLED]
  --with-jpeg-dir[=DIR]   # 指定libjpeg的安装目录 GD: Set the path to libjpeg install prefix
  --with-png-dir[=DIR]    # 指定libpng的安装目录  GD: Set the path to libpng install prefix
  --with-zlib-dir[=DIR]   # 指定libz的安装目录  GD: Set the path to libz install prefix
  --with-xpm-dir[=DIR]    # 指定libXpm的安装目录  GD: Set the path to libXpm install prefix
  --with-ttf[=DIR]        # 指定FreeType 1.x的安装目录  GD: Include FreeType 1.x support
  --with-freetype-dir[=DIR] # 指定freetype GD: Set the path to FreeType 2 install prefix
  --with-t1lib[=DIR]        # 指定T1lib支持 GD: Include T1lib support. T1lib version >= 5.0.0 required
  --enable-gd-native-ttf  # 启用TureType字符功能  GD: Enable TrueType string function
  --enable-gd-jis-conv    # 启用JIS-mapped日语字体支持  GD: Enable JIS-mapped Japanese font support
  --with-gettext[=DIR]    # 包含GNU gettext支持 Include GNU gettext support
  --with-gmp[=DIR]        # 启用GNU MP支持 Include GNU MP support
  --disable-hash          # 禁用hash支持 Disable hash support
  --without-iconv[=DIR]   # 禁用iconv支持 Exclude iconv support
  --with-imap[=DIR]       # 包含IMAP支持。指定c-client安装目录 Include IMAP support. DIR is the c-client install prefix
  --with-kerberos[=DIR]   # 启用kerberos支持并指定其目录  IMAP: Include Kerberos support. DIR is the Kerberos install prefix
  --with-imap-ssl[=DIR]   # 启用ssl支持并指定openssl目录  IMAP: Include SSL support. DIR is the OpenSSL install prefix
  --with-interbase[=DIR]  # 启用interbase支持并指定其目录 Include InterBase support.  DIR is the InterBase base
                          install directory [/usr/interbase]
  --disable-json          # 禁用JavaScript对象顺序话支持 Disable JavaScript Object Serialization support
  --with-ldap[=DIR]       # 包含LDAP支持(轻量级别目的协议) Include LDAP support
  --with-ldap-sasl[=DIR]  # 包含Cyrus SASL支持  LDAP: Include Cyrus SASL support
  --enable-mbstring       # 启用多字节字符串的支持 Enable multibyte string support
  --disable-mbregex       # 禁用多字节正则表达式的支持  MBSTRING: Disable multibyte regex support
  --disable-mbregex-backtrack # 禁用多字节正则表达式回溯检查
                            MBSTRING: Disable multibyte regex backtrack check
  --with-libmbfl[=DIR]      # 使用外部的libmbfl并制定其目录 MBSTRING: Use external libmbfl.  DIR is the libmbfl base
                            install directory [BUNDLED]
  --with-mcrypt[=DIR]     # 包含mcrypt支持 Include mcrypt support
  --with-mhash[=DIR]      # 包含mhash支持 Include mhash support
  --with-mime-magic[=FILE]  # 启用mime_magic支持（不推荐使用！） 
                          Include mime_magic support (DEPRECATED!!)
  --with-ming[=DIR]       # 包含MING支持 Include MING support
  --with-msql[=DIR]       # 包含mSQL支持 Include mSQL support.  DIR is the mSQL base
                          install directory [/usr/local/Hughes]
  --with-mssql[=DIR]      # 包含MSSQL-DB支持，并指定FreeTDS软件目录 Include MSSQL-DB support.  DIR is the FreeTDS home
                          directory [/usr/local/freetds]
  --with-mysql[=DIR]      # 包含MySQL支持 Include MySQL support. DIR is the MySQL base directory
  --with-mysql-sock[=DIR] # 定位mysql的unix 套接字指针。如果未指定，则按默认位置搜索  MySQL: Location of the MySQL unix socket pointer.
                            If unspecified, the default locations are searched
  --with-zlib-dir[=DIR]   # 设置zlib的安装目录  MySQL: Set the path to libz install prefix
  --with-mysqli[=FILE]    # 包含MySQLi支持。参数为mysql_config的位置 Include MySQLi support.  FILE is the optional pathname 
                          to mysql_config [mysql_config]
  --enable-embedded-mysqli # 启用embedded支持。  MYSQLi: Enable embedded support
  --with-ncurses[=DIR]    # 包含ncurses支持。Include ncurses support (CLI/CGI only)
  --with-oci8[=DIR]       # 包含Oracle支持。如果使用Oracle客户端安装则使用–with-oci8=instantclient,/path/to/oic /lib Include Oracle (OCI8) support. DIR defaults to $ORACLE_HOME.
                          Use --with-oci8=instantclient,/path/to/oic/lib 
                          for an Oracle Instant Client installation
  --with-adabas[=DIR]     # 包含Adabas D支持 Include Adabas D support [/usr/local]
  --with-sapdb[=DIR]      # 包含SAP DB支持 Include SAP DB support [/usr/local]
  --with-solid[=DIR]      # 包含Solid支持 Include Solid support [/usr/local/solid]
  --with-ibm-db2[=DIR]    # 包含IBM DB2支持 Include IBM DB2 support [/home/db2inst1/sqllib]
  --with-ODBCRouter[=DIR] # 包含ODBCRouter支持。 Include ODBCRouter.com support [/usr]
  --with-empress[=DIR]    # 包含empress支持 Include Empress support [$EMPRESSPATH]
                          (Empress Version >= 8.60 required)
  --with-empress-bcs[=DIR] # 包含Empress本地访问支持。 
                          Include Empress Local Access support [$EMPRESSPATH]
                          (Empress Version >= 8.60 required)
  --with-birdstep[=DIR]   # 包含Birdstep支持 Include Birdstep support [/usr/local/birdstep]
  --with-custom-odbc[=DIR] # 包括用户自定义的ODBC的支持。目录是ODBC安装的主目录。确定定义了CUSTOM_ODBC_LIBS并且在include目录下有 odbc.h的头文件你要在QNX上为Sybase SQL Anywhere定义如下：运行此之前，配置脚本CPPFLAGS=”-DODBC_QNX -DSQLANY_BUG”LDFLAGS=-lunix CUSTOM_ODBC_LIBS=”-ldblib -lodbc”
                          Include user defined ODBC support. DIR is ODBC install base
                          directory [/usr/local]. Make sure to define CUSTOM_ODBC_LIBS and
                          have some odbc.h in your include dirs. f.e. you should define 
                          following for Sybase SQL Anywhere 5.5.00 on QNX, prior to
                          running this configure script:
                              CPPFLAGS="-DODBC_QNX -DSQLANY_BUG"
                              LDFLAGS=-lunix
                              CUSTOM_ODBC_LIBS="-ldblib -lodbc"
  --with-iodbc[=DIR]     # 包含iODBC支持  Include iODBC support [/usr/local]
  --with-esoob[=DIR]     # 包含Easysoft OOB支持  Include Easysoft OOB support [/usr/local/easysoft/oob/client]
  --with-unixODBC[=DIR]  # 包含unixODBC支持  Include unixODBC support [/usr/local]
  --with-dbmaker[=DIR]   # 包含DBMaker支持  Include DBMaker support
  --enable-pcntl         # 启用pcntl 多进程支持。 Enable pcntl support (CLI/CGI only)
  --disable-pdo          # 禁用PHP数据对象支持  Disable PHP Data Objects support
  --with-pdo-dblib[=DIR] # 启用DBLIB-DB支持。目录为FreeTDS主目录   PDO: DBLIB-DB support.  DIR is the FreeTDS home
                            directory
  --with-pdo-firebird[=DIR] # 启用 pdo frebird 驱动 PDO: Firebird support.  DIR is the Firebird base
                            install directory [/opt/firebird]
  --with-pdo-mysql[=DIR]    # 启用PDO：mysql支持。 PDO: MySQL support. DIR is the MySQL base directory
  --with-zlib-dir[=DIR]     # 设置PDO：MySQL的zlib支持  PDO_MySQL: Set the path to libz install prefix
  --with-pdo-oci[=DIR]      # 设置PDO：Oracle OCI支持。为Oracle安装客户端SDK使用–with-pdo-oci=instantclient,prefix,version参数 PDO: Oracle OCI support. DIR defaults to $ORACLE_HOME.
                            Use --with-pdo-oci=instantclient,prefix,version 
                            for an Oracle Instant Client SDK. 
                            For Linux with 10.2.0.3 RPMs (for example) use:
                            --with-pdo-oci=instantclient,/usr,10.2.0.3
  --with-pdo-odbc=flavour,dir
                            # 启用“flavour”ODBC支持。在dir目录的include和lib目录下查找。“flavour”参数值可以是ibm-db2, unixODBC, generic。如果dir省略，则使用默认值。如果你试图通过generic使用一个如若不支持的驱动程序。为generic ODBC提供的语法格式如下：–with-pdo-odbc=generic,dir,libname,ldflags,cflags。作为共享的编译 后的扩展文件的名一般为pdo_odbc.so PDO: Support for 'flavour' ODBC driver.
                            include and lib dirs are looked for under 'dir'.
                            
                            'flavour' can be one of:  ibm-db2, unixODBC, generic
                            If ',dir' part is omitted, default for the flavour 
                            you have selected will used. e.g.:
                            
                              --with-pdo-odbc=unixODBC
                              
                            will check for unixODBC under /usr/local. You may attempt 
                            to use an otherwise unsupported driver using the "generic" 
                            flavour.  The syntax for generic ODBC support is:
                            
                              --with-pdo-odbc=generic,dir,libname,ldflags,cflags

                            When build as shared the extension filename is always pdo_odbc.so
  --with-pdo-pgsql[=DIR]    # 启用PDO：PostgreSQL支持。 PDO: PostgreSQL support.  DIR is the PostgreSQL base
                            install directory or the path to pg_config
  --without-pdo-sqlite[=DIR] # 禁用 SQLite 3支持。 
                            PDO: sqlite 3 support.  DIR is the sqlite base
                            install directory [BUNDLED]
  --with-pgsql[=DIR]      # 启用PostgreSQL支持并指定其软件根目录或者pg_config的路径 Include PostgreSQL support.  DIR is the PostgreSQL
                          base install directory or the path to pg_config
  --disable-posix         # 禁用POSIX-like支持 Disable POSIX-like functions
  --with-pspell[=DIR]     # 包含PSPELL支持GNU Include PSPELL support.
                          GNU Aspell version 0.50.0 or higher required
  --with-libedit[=DIR]    # 包含libedit readline更换（仅用于CLI和CGI） Include libedit readline replacement (CLI/CGI only)
  --with-readline[=DIR]   # (CLI/CGI only)包含readline支持（仅用于CLI和CGI） Include readline support (CLI/CGI only)
  --with-recode[=DIR]     # 包含recode支持 Include recode support
  --disable-reflection    # 禁用reflection支持。 Disable reflection support
  --disable-session       # 禁用session支持 Disable session support
  --with-mm[=DIR]         # 为session存储启用mm支持。  SESSION: Include mm support for session storage
  --enable-shmop          # 启用shmop 共享内存段 支持 Enable shmop support
  --disable-simplexml     # 禁用 simplexml 支持 Disable SimpleXML support
  --with-libxml-dir=DIR   # 启用simpleXML：libXML2支持。  SimpleXML: libxml2 install prefix
  --with-snmp[=DIR]       # 包含SNMP(简单网络管理协议)支持。 Include SNMP support
  --with-openssl-dir[=DIR] #包含SNMP：openssl支持  SNMP: openssl install prefix
  --enable-ucd-snmp-hack   # 包含UCD  SNMP: Enable UCD SNMP hack
  --enable-soap           # 启用SOAP支持 Enable SOAP support
  --with-libxml-dir=DIR   # 启用SOAP：LIBXML2支持。  SOAP: libxml2 install prefix
  --enable-sockets        # 启用sockets支持 Enable sockets support
  --disable-spl           # 禁用标准PHP库 Disable Standard PHP Library
  --without-sqlite=DIR    # 不包含sqlite支持。 Do not include sqlite support.  DIR is the sqlite base
                          install directory [BUNDLED]
  --enable-sqlite-utf8    # 启用SQLite的UTF-8支持。  SQLite: Enable UTF-8 support for SQLite
  --with-regex=TYPE       # 正则表达式库类型。regex library type: system, apache, php. [TYPE=php]
                          WARNING: Do NOT use unless you know what you are doing!
  --with-sybase[=DIR]     # 包含Sybase-DB支持 Include Sybase-DB support.  DIR is the Sybase home
                          directory [/home/sybase]
  --with-sybase-ct[=DIR]  # 包含Sybase-CT支持 Include Sybase-CT support.  DIR is the Sybase home
                          directory [/home/sybase]
  --enable-sysvmsg        # 启用sysvmsg支持。Enable sysvmsg support
  --enable-sysvsem        # 启用系统V信号支持 Enable System V semaphore support
  --enable-sysvshm        # 启用系统V共享内存支持。Enable the System V shared memory support
  --with-tidy[=DIR]       # 启动tidy Tidy是清理HTML代码的，生成干净的符合W3C标准的HTML代码，支持HTML,XHTML,XML Include TIDY support
  --disable-tokenizer     # 禁用tokenizer支持 Disable tokenizer support
  --enable-wddx           # 启用WDDX支持 Enable WDDX support
  --with-libxml-dir=DIR   # 包含WDDX：libxml2支持。  WDDX: libxml2 install prefix
  --with-libexpat-dir=DIR # 为XMLRPC-EPI启用libexpat（不推荐）  WDDX: libexpat dir for XMLRPC-EPI (deprecated)
  --disable-xml           # 禁用XML支持。 Disable XML support
  --with-libxml-dir=DIR   # 启用libxml2支持   XML: libxml2 install prefix
  --with-libexpat-dir=DIR # 启用libexpat支持（不推荐）  XML: libexpat install prefix (deprecated)
  --disable-xmlreader     # 禁用XMLreader支持。 Disable XMLReader support
  --with-libxml-dir=DIR   # 启用XMLreader的libxml2支持。  XMLReader: libxml2 install prefix
  --with-xmlrpc[=DIR]     # 包含XMLRPC-EPI支持 Include XMLRPC-EPI support
  --with-libxml-dir=DIR   # 启用XMLRPC-EPI：libxml2支持   XMLRPC-EPI: libxml2 install prefix
  --with-libexpat-dir=DIR # 启用XMLRPC-EPI：libexpat支持（不推荐）   XMLRPC-EPI: libexpat dir for XMLRPC-EPI (deprecated)
  --with-iconv-dir=DIR    # 启用XMLRPC-EPI：iconv支持   XMLRPC-EPI: iconv dir for XMLRPC-EPI
  --disable-xmlwriter     # 禁用XMLWriter支持 Disable XMLWriter support
  --with-libxml-dir=DIR   # 启用XMLReader：libxml2支持。  XMLWriter: libxml2 install prefix
  --with-xsl[=DIR]        # 启用XSL(XSL是可扩展样式表语言的外语缩写，是一种用于以可读格式呈现 XML（标准通用标记语言的子集）数据的语言)支持 Include XSL support.  DIR is the libxslt base
                          install directory (libxslt >= 1.1.0 required)
  --enable-zip            # 包含zip读写支持 Include Zip read/write support
  --with-zlib-dir[=DIR]   # 启用zip：zlib支持  ZIP: Set the path to libz install prefix

# PEAR 相关设置 PEAR:

  --with-pear=DIR         # 在目录中安装pear Install PEAR in DIR [PREFIX/lib/php]
  --without-pear          # 禁用pear Do not install PEAR

# ZEND相关选项 Zend:

  --with-zend-vm=TYPE     # 设置虚拟机调度方法，参数为CALL, SWITCH或GOTO Set virtual machine dispatch method. Type is
                          one of CALL, SWITCH or GOTO [TYPE=CALL]
  --enable-maintainer-zts # 启用线程安全模式（仅用于代码维护人员使用） Enable thread safety - for code maintainers only!!
  --disable-inline-optimization # 如果编译zend_execute.lo失败，则使用此参数 
                          If building zend_execute.lo fails, try this switch
  --enable-zend-multibyte # 编译zend多字节支持 Compile with zend multibyte support

# Thread Safe Resource Manager线程安全资源管理器相关配置 TSRM:

  --with-tsrm-pth[=pth-config] # 使用GNU方式管理线程 
                          Use GNU Pth
  --with-tsrm-st          # 使用SGI静态线程方式管理线程 Use SGI's' State Threads
  --with-tsrm-pthreads    # 使用POSIX线程方式管理线程 Use POSIX threads (default)

Libtool:

  --enable-shared[=PKGS]  # 编译共享模块 build shared libraries [default=yes]
  --enable-static[=PKGS]  # 编译静态模块 build static libraries [default=yes]
  --enable-fast-install[=PKGS]  # 启用快速安装优化方式 optimize for fast installation [default=yes]
  --with-gnu-ld           assume the C compiler uses GNU ld [default=no]
  --disable-libtool-lock  # 避免锁死（可能破坏并联的编译） avoid locking (might break parallel builds)
  --with-pic              # 尝试仅使用PIC或non-PIC对象 try to use only PIC/non-PIC objects [default=use both]
  --with-tags[=TAGS]      # 包括额外的配置 include additional configurations [automatic]

  --with-gnu-ld           # 假设C编译器使用GNU ld assume the C compiler uses GNU ld [default=no]




