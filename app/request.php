<?php
namespace app\request;

class RequestException extends \Exception {}

/**
*  Tworzy obiekt żądania reklamacji.
*  Klasa po przesłaniu danych z pliku reklamacje.html tworzy obiekt żądania.
*  Przechowuje w składowej tablice wartości przesłanych danych w formie klucz: wartość.
*  Określa cel żadania na podstawie przesłanych danych.
* 
* @package main
*  @author Daniel Drozdzel.
*/	
class Request {

/**
* Przechowuje tablicę wartości żadanią. 
* Składowa prywatna przechowuje tablicę klucz:wartość przesłanych danych żądania.
* Wartość ustanawiana funkcją init().
* 
* @var array  tablica parametrów żądania.
*/	
	private $properties = null;
	
/**
* Przechowuje określony kierunek działań dla żądania.
* Składowa prywatna przechowuje kierunek dalszych działań aplikacji dla klasy controller.
* Wartość ustanawiana funkcją getDestination().
* 
* @var string cel żądania.
*/		
	private $destination;
	
	
/**
* Konstruktor klasy Request.
* Konstruktor klasy Request w trakcie konkretyzacji obiektu wywołuje metodę init().
* Jeśli klasa jest testowana, konstruktor wywołany z parametrem $testmode
*
* @param  $testmode  null/string   string tylko jeśli testowany
*/			
	public function __construct($testmode) {
		$this->init($testmode);	
	}


/**
* Pobiera przesłane z pliku reklamacje.html dane żądania.
* Pobiera przesłane dane i po zmianie na małe litery wartości zapisuje je w składowej $properties.
* Argument wywołania testmode został dodany na potrzeby testowania. W przypadku przeprowadzania testów zapisuje w składowej $properties 
* testową tablicę, w której wartość argumentu $testmode przypisana zostaje do klucza "sprawdz"
*
* @param  $testmode  null/string   string tylko jeśli testowany
*
*/		
	private function init($testmode) {
		if($testmode === null) {
		$tab = $_REQUEST;
		foreach($tab as &$value) {
			$value = strtolower($value);
		}
		$this->properties = $tab;
		} else if($testmode === "pokaz") {
			$this->properties = array("nr" => 1);
		} else {
		$this->properties = array("imie"=>"daniel", "sprawdz"=> $testmode);
		}
	}

/**
* Pobiera wartość wybranego parametru żądania wg. klucza.
* Metoda pobiera wartość wybranego parametru żądania na podstawie klucza podanego w wywołaniu metody
* Jeśli klucz istnieje zwraca wartość, jeśli nie zrzuca wyjątek.
* Wykorzystywana przez metodę getProp() obiektu klasy Controllera.
* @see \app\controller\Controller::getProp()
* 
* @param $key string klucz dla parametru
* @return string jeśli warunek prawdziwy
*/		
	public function getProperty($key) {
		if(isset($this->properties[$key])) {
			return $this->properties[$key];
		} else {
			throw new RequestException("Szukany parametr nie istnieje.");
		
		}
	}
	
/**	
* Zwraca tablicę parametrów żądania. 
* Zwraca tablicę parametrów żądania przechowywane w składowej $properties
* Jeśli tablica nie istnieje zrzuca wyjątek.
* Wykorzystywane przez metodę getAll() obiektu klasy Controllera
* @see \app\controller\Controller::getAll()
* 
* @return array jeśli warunek prawdziwy
*/		
	public function getProperties() {
		if(isset($this->properties)) {
			return $this->properties;
		} else {
			throw new RequestException("Nie przesłano żadnych danych.");
		}
	}
	
/**	
* Określa kierunek działania aplikacji na podstawie żądania.
* Jeśli istnieje parametr o kluczu "sprawdz" w tablicy składowej $properties metoda pobiera jego wartość i zapisuje w składowej 
* $destination. Jeśli nie istnieje zwraca string "Pokaz". Wykorzystywana przez metodę findDestination() obiektu klasy Controller
* @see \app\controller\Controller::findDestination()
* 
* @return string  cel żądania
*/		
	public function getDestination() {
		if(isset($this->properties["sprawdz"])) {
			  $this->destination = $this->properties["sprawdz"];
			  return $this->destination;
		} else  {
			return "pokaz";
		}
	}	
}




	
	
		
		
	
	
?>