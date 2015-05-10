<?php
use app\model\Model as uModel;
require_once("model.php");

class ZmienException extends Exception{}


/**
* Zmienia dane zapisane w bazie danych.
* Klasa warstwy modelowej zmienia daną reklamację o wskazanym ID zapisaną w bazie danych 
* i zapisuje wynik działania w składowej $wynik.
* @see \app\model\Model::$wynik
*
* @package Model
* @author Daniel Drozdzel
*/	
class Zmien extends uModel {

/**
*  Zmienia dane zapisane w bazie danych i zwraca wynik.
*  Metoda łączy się z klasą Baza z, której pobiera referencję obiektu PDO połączenia z bazą.
*  @see Baza
*  Wykonuje zapytanie o zmianę danych z wybranym ID reklamacji i przekazuje do składowej $wynik.
*  W przypadku niepowodzenia zapytania zrzuca wyjątek.
* 
*/	
	
		protected function go() {
		Baza::getBaza();
		$db = Baza::getPDO();
				$zapytanie = "UPDATE reklamacje SET data = :data, imie = :imie, nazwisko = :nazwisko, karta = :karta, kwota = :kwota, stan = :stan,
				miejsce = :miejsce, ekstra = :ekstra where id= :id;";
			
			$stworz = $db->prepare($zapytanie);
			
			$dane = $this->getProps();
			
			$tablica_danych = array();
			foreach($dane as $key=>$val) {
				$tablica_danych[":".strtolower($key)] = $val;
			}

			$stworz->execute($tablica_danych);
				
			if(!$stworz) {
				throw new ZmienException ("Nie udało się zmienić reklamacji");
			}
	
			$this->wynik = $dane;
		}
}




	
	
?>

