
__开发环境__:docker,ubuntu

__webserver__:nginx

__后端框架__:lumen

__前端框架__:bootstrap,vue.js,Jquery等

__数据库__:Mysql

__缓存层__:Redis

__长连接__:swoole、websocket

__异步队列__:crontab

__图像处理__:FFmpeg扩展,image扩展等


项目描述:用户可以通过邮箱进行注册和登录,观看视频,上传视频,发射弹幕,评论视频,发送动态等

核心架构描述:
用户接口层采用lumen框架编写,依赖于核心coreServive(单)


Swoole_websocket将用户发送的弹幕至Redis队列缓存中,
编写异步cron将队列缓存数据同步到mysql中,
上传视频采用插件对视频进行上传,
使用FFmpeg对视频按秒数进行截取并将截取的图片通过imagick合成gif作为封面展示,
个人中心含有新增/修改个人信息,
发送动态等功能,
利用Redis缓存减轻了MYSQL读写的压力

