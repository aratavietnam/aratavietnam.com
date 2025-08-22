FROM wordpress:cli

USER root

# Install sudo and git
RUN apk update && apk add --no-cache sudo git

# Allow www-data to run commands as root without a password
RUN echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

USER www-data
