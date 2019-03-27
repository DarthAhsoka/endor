# Endor-Wechat
Endo-Wechat is Non-Official Wechat Libarary 

## 使用手册
https://www.kancloud.cn/darth-ahsoka/wechat/999679

## 序言
Endor Wechat 是一个免费开源的，快速、简单的面向对象的轻量级PHP非官方微信SDK，是为了敏捷微信应用开发而封装的一套工具
该框架遵循`MIT`开源许可协议发布，意味着你可以免费使用Endo ，甚至允许把你基于Endo 开发的应用开源或商业产品发布/销售。

## 交流
如果您有更好的建议或者发现BUG，或您有其他需求，可以通过下面的联系方式联系我们

## 联系方式
QQ： 929204168
Mail:   darthahsoka@hotmail.com

## 环境要求
* PHP >= 5.5 
*   [PHP cURL 扩展](http://php.net/manual/en/book.curl.php)
*   [PHP OpenSSL 扩展](http://php.net/manual/en/book.openssl.php)
*   [PHP SimpleXML 扩展](http://php.net/manual/en/book.simplexml.php)

## 引入项目
该项目的引入是非常简单的，该项目的文件目录是可以放在任何位置的，在您的项目中，可以通过PHP框架自带的
第三方库引入工具引入，也可以直接使用 require  项目路径/EndorAutoLoader.php 即可。
> 该项目提供一个简易的自动加载器，根据名字空间，自动加载类，您可以在您的项目任何地方使用endor而
> 不用require具体文件。
> 
## 扩展项目
您只需要给扩展的文件正确定义所在的命名空间，并且命名空间的路径与类库文件的目录一致，那么就可以实现类的自动加载，从而实现真正的惰性加载。


