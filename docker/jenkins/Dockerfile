FROM jenkins/jenkins:lts
MAINTAINER Matthieu Mota <matthieumota@gmail.com>

USER root

RUN apt-get update \
  && apt-get install -y \
  php \
  libltdl7

ARG DOCKER_VERSION="18.06.0"
RUN curl -sSL https://download.docker.com/linux/static/stable/x86_64/docker-${DOCKER_VERSION}-ce.tgz \
    | tar -zxC /tmp/ \
    && cp /tmp/docker/docker /usr/local/bin \
    && rm -rf /tmp/docker

RUN apt-get update \
    && apt-get install -y \
    php

#RUN rm -rf /var/lib/apt/lists/*

USER jenkins

COPY plugins.txt /usr/share/jenkins/ref/
RUN /usr/local/bin/install-plugins.sh < /usr/share/jenkins/ref/plugins.txt