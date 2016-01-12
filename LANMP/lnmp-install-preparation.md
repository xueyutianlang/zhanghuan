
##Centos 6.5 编译安装 lnmp
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)

###步骤一
安装前准备工作编译工具与库文件安装
   CentOS yum命令安装

```javascript
   yum install make apr* autoconf automake curl-devel gcc gcc-c++ gtk+-devel zlib-devel openssl openssl-devel pcre-devel gd gettext gettext-devel kernel keyutils patch perl kernel-headers compat* mpfr cpp glibc libgomp libstdc++-devel ppl cloog-ppl keyutils-libs-devel libcom_err-devel libsepol-devel libselinux-devel krb5-devel  libXpm* freetype freetype-devel freetype* fontconfig fontconfig-devel libjpeg* libpng* php-common php-gd ncurses* libtool* libxml2 libxml2-devel patch
```
Notice : 各个步骤之间联系不大，可单独根据自身需要进行参考安装
