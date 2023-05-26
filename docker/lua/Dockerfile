FROM openresty/openresty:alpine-fat

WORKDIR ./../../
ADD ./artifact/dev/luanginx.conf	/etc/nginx/conf.d/default.conf
ADD ./artifact/lua	/usr/local/openresty/nginx/html/default
ADD ./artifact/dev/resty.conf /usr/local/openresty/nginx/conf/nginx.conf