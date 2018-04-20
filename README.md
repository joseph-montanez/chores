
    
## CosmicGrams Chores

This application is a task based application intended to remind its users of tasks, single or reoccurring.

### Supports:
 - Amazon S3 / CloudFront integration - Assets Only
 - SMS Notifications - Nexmo
 - Push Notifications - Pushover
 - RRULE integration - Reoccurring tasks
 - Randomized Task Assignment
 - Assignment of Specific Workers to a Task
 
### TODO (Immediate):
 - If a chore has "&" in the name, XML craps out
 - Add name to "Work" so we do not need to lookup the name of the task
 - Add change password feature in UI, rather than depending on forgot password feature.
 
 
### Missing Features **//TODO** (Important to Least Important)
 - Multiple notification reminders per chore. I.E 30 minutes before.
 - Reassign queued notifications when a task is rescheduled 
 - Easier SMS and Push Notification setup (phone number formatting & Pushover URL displaying)
 - Add confirmation for SMS messages, so SPAM isn't sent to unwanted individuals
 - Round-Robin task assignment
 - Option to delete chore after complete
 - Log Chore activity
 - Implement points system (for completed tasks)
 - Unit Tests

## License AGPLv3

The application is AGPLv3 and commercial licensing is available.

 - **Protects user freedom in the cloud** - If you are running this as a SASS application, then you are required to provide users of this application the source code.
 - **Ensures that derivitave works are also protected by strong copyleft** - You cannot change the license of this application, any modifications of this license must also be under AGPLv3
 - **Ensures source access** - Every user of this application has access to the source code

If you do not agree with the license you are more than welcome to purchase a commercial license.

## How To Setup

### 0. Database Consideration

SQLite is perfectly acceptable to use for this type of system if the usage of this application is low. However please note that if SQLite cannot handle concurrency very well and will lock your entire application processes. I've run into situations where the database locked up for days and when I restarted the processes a huge burst of pending messages where dispatched. This is mostly due to the task runner. Since Laravel 5.6 there is an only one task server option that I will need to play with to see if it resolves this issue.

### 1. Copy .env.example

Copy `.env.example` to `.env` and make any changes needed.


**SQLite Database**

This is optional you can use MySQL, PostgreSQL or another Laravel compatible database.

    touch storage/databases/database.sqlite
    chmod 0770 storage/databases/database.sqlite
    chgrp www-data storage/databases/database.sqlite

**Install Libraries**

    php composer.phar install
    php artisan migrate
    php artisan passport:keys
    php artisan passport:client --password
    php artisan passport:client --personal

### 2. Configure Task Scheduler

A task schedule process needs to be running to, this is built into Laravel itself so this is not unique to the application, but there are scheduled tasks running from this command. This process is used to generate **work**, so if you are adding chores but are not seeing them appear on the schedule, then you are not running the task scheduler as expected.

#### Windows 7+ Instructions

If you want to add a scheduled task you can use `schtasks`. Be sure to change **`PATH-TO-PHP`** and **`PATH-TO-APP`**.

    schtasks /Create /SC MINUTE /MO 1 /TN ChoreScheduler /TR 'C:\PATH-TO-PHP\php.exe C:\PATH-TO-APP\artisan schedule:run'

If you want to delete the scheduled task

    schtasks /Delete /TN ChoreScheduler
    
#### Linux CRON Instructions

If you want to add a scheduled task you can use `crontab`. Be sure to change the paths to be your own.

    * * * * * php /PATH-TO-APP/artisan schedule:run >> /dev/null 2>&1

#### MacOS Launchd Instructions

You can still use CRON on MacOS, but Launchd is the defacto and more powerful than CRON. I'd recommend Launchd over CRON if you are using MacOS. 

You will need to edit `com.cosmicgrams.chores.schedule.plist` and change the path to artisan to your own installation path.

    cp com.cosmicgrams.chores.schedule.plist ~/Library/LaunchAgents
    launchctl load -w ~/Library/LaunchAgents/com.cosmicgrams.chores.schedule.plist
    
If you want to delete the scheduled task

    launchctl unload -w ~/Library/LaunchAgents/com.cosmicgrams.chores.schedule.plist
    rm ~/Library/LaunchAgents/com.cosmicgrams.chores.schedule.plist
 
### 3. Queue Support (SMS / Emails)

In order to receive notifications via Email, SMS, or Push Notifications, then you'll need to also setup a Laravel `queue`. In this example 

#### Command Line

The command is standard in Laravel, but due to the laravel PushOver, retries does not work as expected and the command  line addition to `--tries` is needed.

    php artisan queue:work --tries=3


#### Supervisord 3.x

I am showing how to enable the process to keep running with Supervisord:

file: `/etc/supervisor/conf.d/chores.conf`

    [program:chores-laravel-worker]
    command=php /home/chores/artisan queue:work --tries=3
    autostart=true
    autorestart=true
    user=chores
    redirect_stderr=true
    stdout_logfile=/home/chores/storage/logs/worker.log

Starting the command with supervisord:

    supervisorctl reread
    supervisorctl update
    supervisorctl start chores-laravel-worker
