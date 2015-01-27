SugiPHP.DBAL
============

SugiPHP database abstraction layer extends PDO and gives you:

* Lazy database connection, which means that creating a Connection instance (PDO instance) will not
connect automatically to the DB. The connection will occur only if you use a method that requires
a connection.

* TODO: Fire 'before' and 'after' events on several methods, giving you the ability to log statement
and profile them.
