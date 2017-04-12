# dirty-deetz
Posts pictures to Instagram automatically. https://instagram.com/samepictureofdirtydeetz

## Schedule a cron task (automated task) on a Linux system

#### First open crontab

```
crontab -e
```
#### Edit the cron file and input when you want the script to run

A '\*' denotes running every time, e.g. a '\*' in the hour field will run the script every hour.

```
# .---------------- minute (0 - 59) 
# |  .------------- hour (0 - 23)
# |  |  .---------- day of month (1 - 31)
# |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ... 
# |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7)  OR sun,mon,tue,wed,thu,fri,sat 
# |  |  |  |  |
# *  *  *  *  *  command to be executed

  30 3  *  *  *  php /my/name/is/jeff/dirtydeetz.php
```
