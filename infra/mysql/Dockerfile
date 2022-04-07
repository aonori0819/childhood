FROM mysql/mysql-server:8.0

ENV MYSQL_DATABASE=${MYSQL_DATABASE} \
    MYSQL_USER=${MYSQL_USER} \
    MYSQL_PASSWORD=${MYSQL_PASSWORD} \
    MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD} \
    TZ=Asia/Tokyo

COPY ./infra/mysql/my.cnf /etc/my.cnf
RUN chmod 644 /etc/my.cnf