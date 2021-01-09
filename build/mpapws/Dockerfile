FROM registry.univ-lr.fr:81/iutlr-info/iutlr-info-apache2-php7.4-symfony5.1

LABEL Maintainer="Equipe MPA-PWS Z-3-1"
LABEL Vendor="Equipe MPA-PWS Z-3-1"
LABEL Description="Apache2-Symfony5.2-PHP7.4"
LABEL Version="Dec-2020"

####### APP_DOCUMENT_ROOT
ARG APP_DOCUMENT_ROOT
ENV APP_DOCUMENT_ROOT=${APP_DOCUMENT_ROOT}

####### vhosts activation 
ADD vhosts /etc/apache2/sites-available

####### add activation 
RUN a2ensite 000-default

