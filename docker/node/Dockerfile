FROM node:9
##MAINTAINER Name Here <username@localhost>
##RUN rpm -Uvh http://mirror.pnl.gov/epel/7/x86_64/Packages/e/epel-release-7-11.noarch.rpm
##RUN yum install nodejs npm -y
#WORKDIR /var/www/frontend
##COPY . /var/www/frontend
#RUN cd /var/www/frontend;
#
##RUN npm install -g nodemon
#
#EXPOSE 3000
#
##CMD ["nodemon","-L","/var/www/frontend" ]

RUN apt-get update && \
	apt-get install -y \
		curl \
		apt-transport-https

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
	echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update && apt-get install yarn

#RUN mkdir -p /var/www/symfony && cd /var/www/symfony
#RUN cd /var/www/
# Install node_modules with yarn
ADD package.json yarn.lock /tmp/
RUN cd /tmp && yarn
RUN mkdir -p /var/www/api && cd /var/www/api && ln -s /tmp/node_modules

# Copy app
COPY . /var/www/api

# Expose port
EXPOSE 9000

# Run app
#CMD ["yarn","encore dev --watch"]

#RUN yarn install --ignore-engines

#EXPOSE 8888
#WORKDIR /var/www/symfony