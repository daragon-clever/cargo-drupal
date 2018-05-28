FROM ruby:2.5-alpine

ADD bundle /tmp/bundle
ENV BUNDLE_APP_CONFIG /tmp/bundle

RUN apk --update --no-cache add openssh-client
ADD .ssh /.ssh
ADD entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh && chmod -R 600 /.ssh/*

ENTRYPOINT ["/entrypoint.sh"]
CMD ["install"]
