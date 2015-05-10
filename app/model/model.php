<?php
namespace app\model;
//pamietaj zeby zmienic adres na wzgledny ..!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
require_once("c:\\wamp\\www\\reklamacje\\app\\baza.php");
use app\controller\Controller as uController;

class ModelException extends \Exception {}

/**
* Wspólna klasa abstrakcyjna dla klas warstwy modelowej.
* Przechowuje referencję do obiektu klasy Controller 
* i zwraca dane przetworzone w obiektach klas warstwy modelowej.
*
* @package Model
* @author Daniel Drozdzel
*/
abstract class Model {

/**
* Przechowuje refencje do obiektu klasy Controller.
* Chroniona składowa przechowuje refernecję do obiektu klasy Controller, który wywołał ten model.
* @see \app\controller\Controller
*
* @var object  Controller
*/
	protected $insert;
		
/**
* Przechowuje wynik działania klas modelowych.
* Przechowuje tablicę wartości ustanawianych metodą go() w klasach modelowych. 
* 
* @var array  tablica wyników metody go()
*/	
	protected $wynik;

/**
* Wymusza użycie metody w klasach pochodnych.
*/		
	abstract protected function go();

/**
* Konstruktor klas warstwy modelowej.
* Przyjmuje w wywołaniu referencję obiektu klasy Controller i wywołuje metode addInsert() z użyciem tej referencji.
* Wywołuje również metody go() oraz setWynik().
*
* @param $nw  obiekt klasy Controller.
*
*/
	public function __construct(uController $nw) {
				$this->addInsert($nw);
				$this->go();
				$this->setWynik();
		}

/**
* Przekazuje referencję obiektu klasy Controller do składowej $insert.
* Przyjmuje w wywołaniu referencje obiektu klasy Controller i przekazuje ją do składowej $insert.
* Jeśli obiekt w wywołaniu nie jest obiektem typu Controller zrzuca wyjątek.
*
* @param $nw  obiekt klasy Controller
*
*/	
	private function addInsert(uController $control) {
	  if(!($control instanceof uController)) {
			throw new ModelException("Błąd warstwy modelowej aplikacji");
	  }
	  $this->insert = $control;	
	}
	
/**
* Przetwarza parametry żądania.
* Pobiera parametry żądania z referencji obiektu klasy Controller metodą getAll().
* @see \app\controller\Controller::getAll()
* Jeśli celem żadania jest zapisanie danych usuwa pierwszą i ostatnią pozycję w tablicy, 
* Jeśli znalezienie lub zmienienie danych usuwa ostatnią pozycję.
* jeśli nie zwraca całą tablicę bez przekształceń.
*
* @return $props  tablica parametrów
*/	
	
	protected function getProps() {
		$props = $this->insert->getAll();
		$dest = $this->insert->findDestination();
		
		switch($dest) {
		  case("zapisz"):
			array_pop($props);
			array_shift($props);
			return $props;
			break;
		  case("znajdz"):
		  case("zmien"):
			array_pop($props);
			return $props;
			break;
		  default:
			return $props;
			break;
		}
	}
	
/**
* Ustawia w składowej $wynikModel klasy Controller wynik działania wartstwy modelowej.
* Pobiera wynik działania obiektu wartstwy modelowej ze składowej $wynik i przekazuje
* go do referencji obiektu klasy Controller do składowej $wynikModel.
*
*/		
	private function setWynik() {
		$this->insert->setWynikModel($this->wynik);
	}
	
	
}




		

	









?>