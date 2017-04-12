# dirty-deetz
Mark Zuckerberg smells bad and doesn't support posting images through the official [Instagram API](https://www.instagram.com/developer/), so this script spoofs the request by identifying as a [version 4 Instagram client](https://youtu.be/dQw4w9WgXcQ).

To run:
`git clone https://github.com/andrewhu/dirtydeetz.git && php dirtydeetz/dirtydeetz.php`
Make sure the script has the right permissions. `-rwxr-xr-x` for the folder (755) and `-rw-r--r--` for the script (644)

### Schedule a cron task (automated task) on a Linux system

```
crontab -e
```
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

A `*` denotes running every time, e.g. a `*` in the hour field will run the script every hour. The example below will run `dirtydeetz.php` at 23:59 (11:59 PM) every day of the month, every month, every day of the week.
### Reminders
- Remember to set the correct timezone on the machine you are running

## Example
https://instagram.com/samepictureofdirtydeetz
