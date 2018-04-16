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