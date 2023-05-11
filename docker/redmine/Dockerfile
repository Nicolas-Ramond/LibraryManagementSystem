FROM redmine:3.4

ENV DIRPATH /home/neo/share/websites/LibraryManagementSystem
USER root
COPY ./themes/flattheme /usr/src/redmine/public/themes/flattheme
RUN chown -R redmine:redmine /usr/src/redmine/public/themes/flattheme

EXPOSE 3000