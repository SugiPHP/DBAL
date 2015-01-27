SugiPHP.DBAL
============

SugiPHP database abstraction layer extends PDO and gives you:

* Lazy database connection. This means that creating a PDO instance (SugiPHP\DBAL\Connection)
will not establish a connection to the DB. The connection will occur only if you use a method
that requires a connection.

* TODO: Fire 'before' and 'after' events on several methods, giving you the ability to log
statements and profile them.
