<?php

require_once("model.php");
use app\model\Model as uModel;

class PokazException extends Exception {}

/**
* Zwraca tablicę danych z bazy danych o wybranym ID reklamacji.
* Klasa warstwy modelowej zwraca tablice danych z zapytania bazy danych o wybranym ID reklamacji
* i zapisuje wynik działania w składowej $wynik.
* @see \app\model\Model::$wynik
*
* @package Model
* @author Daniel Drozdzel
*/	
class Pokaz extends uModel {

	/**
* Przechowuje zapytanie.  
* Przechowuje zapytanie na podstawie danych przetworzonych z tablicy z parametrami.
* 
* @var string  zapytanie SQL
*/
	private $zapytanie;
	
/**
*  Sprawdza zapytanie w bazie danych i zwraca wynik.
*  Metoda łączy się z klasą Baza z, której pobiera referencję obiektu PDO połączenia z bazą.
*  @see Baza
*  Wykonuje zapytanie o zwrot danych z wybranym ID reklamacji i przekazuje do składowej $wynik.
*  W przypadku niepowodzenia zapytania zrzuca wyjątek.
* 
*/	
	protected function go() {
		Baza::getBaza();
		$db = Baza::getPDO();
		
		$dane = $this->getProps();
	
		
		$zapytanie = "Select * FROM reklamacje where id='".$dane["nr"]."';";
		$this->zapytanie = $zapytanie;

		$pytanie = $db->query($zapytanie);
		if(!$pytanie) {
			throw new PokazException("Nie znaleziono reklamacji o podanym numerze");
		}
		$wynik = $pytanie->fetch(PDO::FETCH_ASSOC);
		
		$this->wynik = $wynik;
	}
	
	/**
*  Zwraca string zapytania SQL
*  Zwraca string z zapytanie SQL z metody go().
*  Metoda powstała na potrzeby testowania.
*  @return Zapytanie string 
* 
*/	
	public function getZapytanie () {
		return $this->zapytanie;
	}
}
?>
	