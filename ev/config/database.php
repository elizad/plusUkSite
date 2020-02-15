<?php
class Database {
	private static $db 		= 'facebook_all_events';
	private static $host 	= 'localhost';
	private static $user 	= 'smlr7wgdmep';
	private static $pass 	= 'Clujnapoca1!';

	private static $cont = null;

	public function __construct() {
		exit('Init function is not allowed');
	}

	public static function connect() {
		// One connection through whole application
		if (null == self::$cont) {
			try {
				self::$cont = new PDO('mysql:host=' . self::$host . ';' . 'dbname=' . self::$db, self::$user, self::$pass);
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		return self::$cont;
	}

	public static function disconnect() {
		self::$cont = null;
	}
}
