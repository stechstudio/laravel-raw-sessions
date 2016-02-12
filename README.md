Raw PHP session handler for Laravel
====================

As of version 4.1.0 Laravel has removed the native session handler, and made it simply an alias for their file handler.

http://wiki.laravel.io/Changelog_(Laravel_4)#Version_4.1.0

This handler gives that back.

Why would you want this?
====================

Really you shouldn't want this. Laravel's own session management has some very cool advantages, and you should really use it. 

Except when you can't.

Sometimes you may have a separate non-Laravel PHP app running on the same domain, that needs full session sharing. In our case, it was a legacy app that was being refactored in Laravel, but needed complete session sharing in the meantime.

Setup
====================

First off add the composer dependency:

    "require": {
        "stechstudio/laravel-raw-sessions" : "0.1.*"

Then of course update composer:

    composer update

Now add the service provider to the array in `config/app.php`:

    'providers' => array(
        ...
        'STS\Session\LaravelRawSessionServiceProvider',

In `config/session.php` set the `driver` to `raw`:

    'driver' => 'raw',
    
And finally, make sure in that same file you turn off encryption. The only way we can have PHP manage the session is to tell Laravel not to encrypt it.

    'encrypt' => false,

That's it! All your Laravel `Session` calls will be reading and writing to the raw `$_SESSION` array.

Namespace the session
====================

You may wish to avoid polluting the root `$_SESSION` array, if you are sharing the session with other apps.

To change this, specify a `namespace` param in `config/session.php`:

    'driver' => 'raw',
    'namespace' => 'mynamespace',

This will cause Laravel to store all its session data under `$_SESSION['mynamespace']`. 
