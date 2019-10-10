FROM hub.t-me.pp.ua/wi1w/webserver:7-1-opencart

WORKDIR /var/www/html

ADD ./www /var/www/html/
RUN mkdir -p backend/web/uploads/ && chmod -R 0777 backend/web/uploads/
RUN ln -s /var/img/uploads/2019 backend/web/uploads/2019

#RUN /etc/init.d/apache2 restart

ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
