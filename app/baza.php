<?php

class BazaException extends Exception {}


/**
* Tworzy obiekt PDO będący połączeniem z bazą danych reklamacje.sqlite.
* Klasa Baza tworzy obiekt własnej instancji i przechowuje jego referencje w swojej statycznej składowej $baza.
* Obiekt tej instancji tworzy i przechowuje w zmiennej statycznej $PDO referencje obiektu klasy PDO, który łączą się
* z bazą danych reklamacje.sqlite. Jeśli baza danych nie istnieje, jej plik zostaje utworzony przez konstruktor tej klasy.
* 
* @package main
* @author Daniel Drozdzel
* 
*/
class Baza {

/**
*  Przechowuje instancję własnej klasy.
*  Przechowuje referencję własnego obiektu. Wartość ustanawiana metodą getBaza().
*  
*  @var object Baza
*/	
  private static $baza = null;
  
/**
*  Przechowuje instancję obiektu PDO
*  Przechowuje referencję obiektu PDO. Wartość ustanawiana metodą createPDO().
*  @var object PDO
*/	
  private static $PDO ;

/**
*  Prywatny konstruktor klasy Baza
*  Wywołuje metodę createPDO() oraz metodę stworzBaze();
*  Obiekt Baza jest niemożliwy do skonkretyzowania spoza niej samej.
*/	
  private function __construct() {
		self::createPDO();
		self::stworzBaze();
}

/**
*  Tworzy obiekt PDO.
*  Tworzy obiekt PDO z połączeniem z bazą danych reklamacje.sqlite
*  Zapisuje referencję obiektu w składowej $PDO. Wywoływana przez konstruktor klasy. 
*/	
 private static function createPDO() {
	    $db = new PDO("sqlite:reklamacja.sqlite");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		self::$PDO = $db;
 } 
 
/**
*  Tworzący tabelę bazy danych reklamacje.
*  W przypadku braku referencji obiektu PDO w składowej $PDO zrzuca wyjątek.
*  W przeciwnym wypadku jeśli plik z bazą danych nie istnieje tworzy go wraz z główną tabelą reklamacje. 
*  
*/	
 private static function stworzBaze() {
	 if(!empty(self::$PDO instanceof PDO)) {
			self::$PDO->exec("create table if not exists reklamacje(id INTEGER PRIMARY KEY, data TEXT, imie VARCHAR(50), 
							nazwisko VARCHAR(100), karta VARCHAR(11), kwota VARCHAR(6), stan VARCHAR (10), miejsce VARCHAR(4), ekstra TEXT)");
	 } else {
		 throw new BazaException("Błąd bazy danych");
	 }
}

/**
*  Pobiera referencję obiektu PDO ze składowej $PDO.
*  Metoda pobiera referencję obiektu PDO przechowywany w składowej $PDO. 
*  Zwraca uchwyt tego obiektu. W przypadku braku zrzuca wyjątek.
*  
*  @return object PDO
*/	
  public static function getPDO() { 
	  if(empty(self::$PDO instanceof PDO)) {
		 throw new BazaException("Błąd bazy danych");
	  } else {
	return self::$PDO;
    }
  }
	
	
/**
*  Tworzy instancję własnej klasnej
*  Jeśli składowa $baza jest pusta, metoda tworzy nowy obiekt klasy Baza i zapisuje jego referencję
*  w składowej $baza. Zwraca uchwyt tego obiektu.
*
*  @return object $Baza
*/		
  public static function getBaza() {
	if(!(self::$baza instanceof Baza)) {
			self::$baza = new Baza();
	}
	return self::$baza;
  }
}


?>