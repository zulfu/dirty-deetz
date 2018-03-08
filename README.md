# Script to post Aditya's face on Instagram every day (only if he forgets)
Identifies as an android version 4 Instagram client. 
The script checks every day at 11:59 if a picture has been posted, otherwise it will post.

### Installation
```
git clone https://github.com/andrewhu/dirtydeetz.git
apt install php php-curl -y
cd dirtydeetz && php dirtydeetz.php 
```
### Scheduling a crontab
Open the crontab file:
```
crontab -e
```
Add these lines to the crontab file:
```
# .---------------- minute (0 - 59) 
# |  .------------- hour (0 - 23)
# |  |   .---------- day of month (1 - 31)
# |  |   |  .------- month (1 - 12) OR jan,feb,mar,apr ... 
# |  |   |  |  .---- day of week (0 - 6) (Sunday=0 or 7)  OR sun,mon,tue,wed,thu,fri,sat 
# |  |   |  |  |
# *  *   *  *  *  command to be executed

  59 23  *  *  *  php /my/name/is/jeff/dirtydeetz.php
```

## Example
https://instagram.com/samepictureofdirtydeetz
