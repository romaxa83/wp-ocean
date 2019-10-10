#!/bin/bash

php /var/www/html/yii migrate/up --interactive=0
php /var/www/html/yii sitemap --interactive=0

send_notification()
{
  NOTIFICATION_CONTENT="Deploy to 5okean.com finished at $(date +%d_%m_%Y_%H_%M)"
  curl -X POST -H 'Content-type: application/json' --data "{\"text\": \"${NOTIFICATION_CONTENT}\", \"channel\": \"#devtalk\", \"username\": \"gitlab\", \"icon_emoji\": \":biohazard_sign:\"}" "https://hooks.slack.com/services/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"
  echo -e "Slack notification sent to channel #devtalk"
}

send_notification