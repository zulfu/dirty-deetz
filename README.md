# Script to post Aditya's face on Instagram every day (only if he forgets)
Identifies as an android version 4 Instagram client. 
The script checks every day at 11:59 if a picture has been posted, otherwise it will post.

### Installation
```
Linux/Debian:
git clone https://github.com/andrewhu/dirtydeetz.git
chmod 755 dirtydeetz && chmod 644 dirtydeetz/*
cd dirtydeetz && php dirtydeetz.php 
```
### Scheduling a crontab (automated task)
Open the crontab file:
```
crontab -e
```
Add this line to the crontab file:
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

A `*` denotes running every time, e.g. a `*` in the hour field will run the script every hour. The example above will run `dirtydeetz.php` at 23:59 (11:59 PM) every day of the month, every month, every day of the week.
### Reminders
- Remember to set the correct timezone on the machine you are running

## Example
https://instagram.com/samepictureofdirtydeetz
