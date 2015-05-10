<?php

require_once("model.php");
use app\model\Model as uModel;

class ZapiszException extends Exception {}



/**
* Zapisuje dane w bazie danych.
* Klasa warstwy modelowej zapisuje tablice danych z żądania
* i zapisuje wynik działania w składowej $wynik.
* @see \app\model\Model::$wynik
*
* @package Model
* @author Daniel Drozdzel
*/	
class Zapisz extends uModel {

/**
*  Zapisuje dane w bazie danych i zwraca wynik.
*  Metoda łączy się z klasą Baza z, której pobiera referencje obiektu PDO połączenia z bazą.
*  @see Baza
*  Wykonuje zapytanie o zapisanie danych w tabeli reklamacji. Zwraca wynik uzupełniony o przyznany ID reklamacji.
*  W przypadku niepowodzenia zapytania metoda zrzuca wyjątek.
*/			
		protected function go() {
			Baza::getBaza();
			$db = Baza::getPDO();
		
			$zapytanie = "INSERT INTO reklamacje(data, imie, nazwisko, karta, kwota, stan, miejsce, ekstra) VALUES (
							:data, :imie, :nazwisko, :karta, :kwota, :stan, :miejsce, :ekstra)";
			
			$stworz = $db->prepare($zapytanie);
			
			$dane = $this->getProps();

			$tablica_danych = array();
			foreach($dane as $key=>$val) {
				$tablica_danych[":".$key] = $val;
			}
		
			$stworz->execute($tablica_danych);
				
			if(!$stworz) {
				throw new ZapiszException("Nie udalo się zapisać reklamacji");
			}
				
			$ide = $db->lastInsertId();
			$tab_id = array("id" =>	$ide);
			$dane = $tab_id + $dane;
		
			$this->wynik = $dane;
			
		}
}




	
	
?>

