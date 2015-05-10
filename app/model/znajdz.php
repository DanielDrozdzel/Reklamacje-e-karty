<?php
use app\model\Model as uModel;

require_once("model.php");

class ZnajdzException extends Exception {}

/**
* Odnajduje dane zapisane w bazie danych.
* Klasa warstwy modelowej odnajduje dane zapisane w bazie danych 
* na podstawie wyselekcjowanych, szukanych parametrów
* i zapisuje wynik działania w składowej $wynik.
* @see \app\model\Model::$wynik
*
* @package Model
* @author Daniel Drozdzel
*/	
class Znajdz extends uModel {

/**
* Przechowuje tablicę do stworzenia zapytania.  
* Przechowuje wyselekcjonowaną tablicę z parametrami do stworzenia zapytania w bazie danych.
* 
* @var array  tablica zapytania
*/
	private $searched;
	
/**
* Przechowuje zapytanie.  
* Przechowuje zapytanie na podstawie danych przetworzonych z tablicy z parametrami.
* 
* @var string  zapytanie SQL
*/
	private $zapytanie;
	
/**
* Selekcjonuje parametry do stworzenia zapytania.
* Pobiera tablicę parametrow za pomocą metody getProps().
* @see \app\model\Model::getProps()
* Następnie odrzuca klucze z pustymi wartościami. Zwraca filtrowaną tablicę 
* i zapisuje w składowej $searched. Wywoływana w metodzie go().
* 
*/	
	private function selection() {
		$dn = $this->getProps();
		$tablica = array_filter($dn);	 
		$this->searched = $tablica;
	}

/**
*  Odnajduje i zwraca dane zapisane w bazie danych.
*  Metoda łączy się z klasą Baza z, której pobiera referencję obiektu PDO połączenia z bazą.
*  @see Baza
*  Wykonuje zapytanie o wyszukwania wierszy na podstawie wyselekcjonowanej tablicy parametrów
*  z metody selection() przekazuje do składowej $wynik.
*  W przypadku niepowodzenia zapytania zrzuca wyjątek.
* 
*/		
	protected function go() {
		Baza::getBaza();
		$db = Baza::getPDO();
		
		$this->selection();

		$tab = $this->searched;
	
		$zapytanie = "Select * FROM reklamacje";
		if(!empty(array_values($tab))) {
				$zapytanie .= " where ";
		} 
			
		foreach($tab as $key => $value) {
			 if ($value === end($tab)) {
				$zapytanie .= $key." LIKE '%".$value."%' ;";
			} else {
				$zapytanie .= $key. " LIKE '%".$value."%' AND ";
			}
		}
		
		$this->zapytanie = $zapytanie;
		
		$pytanie = $db->query($zapytanie);
		$wynik = $pytanie->fetchAll(PDO::FETCH_ASSOC);
		
		if(empty($wynik)) {
			$str = "Poszukiwana reklamacja, gdzie: <br> ";
			foreach($tab as $key=>$val) {
				$str .= strtoupper($key)." : ".ucfirst($val)." <br>";
			}
			$str .= "nie została odnaleziona.";
			
			throw new ZnajdzException($str);
		}
		
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