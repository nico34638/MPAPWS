FROM registry.univ-lr.fr:81/iutlr-info/iutlr-info-apache2-php7.4-symfony5.1

LABEL Maintainer="Jamal Malki <jmalki@univ-lr.fr>"
LABEL Vendor="Jamal Malki"
LABEL Description="Apache2-Symfony5.1-PHP7.2"
LABEL Version="Dec-2020"

####### APP_DOCUMENT_ROOT
ARG APP_DOCUMENT_ROOT
ENV APP_DOCUMENT_ROOT=${APP_DOCUMENT_ROOT}

####### vhosts activation 
ADD vhosts /etc/apache2/sites-available

####### add activation 
RUN a2ensite 000-default

