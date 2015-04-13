##Load lazy 图片延时加载插件原理是：
修改目标img标签的src属性(占位图片)变为orginal属性(真实图片地址)，从而中断图片的加载。检测滚动状态，然后把可视网页中的img的 src 属性还原加载图片，制造缓冲加载的效果。通俗说就是img标签src(占位)，orginal(真实)，页面初始化时先加载src的占位图，根据右侧纵向导航条的滚动状态，智能化的将orginal地址还原给src。

##Load lazy 使用：
####注意：如使用此效果请严格按照以下范例，否则结果不可预知。
###第一步：加载插件／加载jquery
    
    <script src='/js/jquery-1.11.0.min.js'></script>
    <script src='/js/jquery.lazyload.js'></script>
###第二步：定义图片标签结构
修改 HTML 的结构，在 img 标签中添加新的属性，把 src 属性的值指向占位图片，添加 original 属性，让其指向真正的图像地址。例如：本例
```php
<img src="/js/loading.gif" original='/picture/1.jpg' width='1020' height='400'/>
```
####注意： !特殊图片不需按照lazyload.js官方格式。例如：
```php
<img class='noLazy' src='/picture/mao.jpg' width='70' height='60'/> 
```
###第三步：触发
```php
jQuery(document).ready(
    function($){
	$("img:not(.noLazy)").lazyload({
		 placeholder : "/js/loading.gif",/*预加载图片路径*/
		 effect      : "fadeIn"/*自定义效果*/
	});
})
```
