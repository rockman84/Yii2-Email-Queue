# Yii2-Email-Queue
Email Queue Module

# How To Install?
---------------
via composer run
```
php composer.phar require sky/emailqueue "*"
```

or add in composer.json to require selection

```
"sky/emailqueue" : "*"
```
#### Web Application
set web Application module at main config file
```
'modules' => [
    'emailqueue' => [
        'class' => 'sky\emailqueue\Module'
    ]
],
```

#### Console Application
set console Application module at main config file
```
'modules' => [
    'emailqueue' => [
        'class' => 'sky\emailqueue\Module'
    ]
],
```

run console for do migration
```
./yii migrate --migrationPath="@sky/emailqueue/migrations"
```

## Module Configuration
- [int] serverID (default 1)
    define your server id
- [array] serverAvaliable
    list of avaliable server to allocation task
- [bool] deleteAfterSend (default false)
    delete data queue after successful send email
- [int] emailSendPerSession (default 60)
    how much email to send every session
- [bool] autoAllocationServer (default true)
    auto allocation task queue to server depend on your `serverAvaliable`
- [mix] mailer
    mailer component
