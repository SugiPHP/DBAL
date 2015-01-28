SugiPHP.DBAL
============

SugiPHP database abstraction layer extends PDO and gives you:

* Lazy database connection. This means that creating a PDO instance (SugiPHP\DBAL\Connection)
will not establish a connection to the DB. The connection will occur only if you use a method
that requires a connection. If (for some reason) you don't wish to use this feature, call connect()
method right after the object creation.

* Add an event listener (callable) for some PDO methods, giving you the ability to log statements
and profile them.
