
##Centos 6.5 编译安装 redis
###有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(xueyutianlang1#gmail.com, 把#换成@)
1.安装前准备软件下载

   下载 redis-2.6.14.tar.gz
      wget https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/redis/redis-2.6.14.tar.gz


2.安装redis 

```javascript
   cd  /usr/local/src
   tar -zxvf  redis-2.6.14.tar.gz
   cd  ./redis-2.6.14
   make && make test
```

