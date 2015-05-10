<?php
namespace app\widoki;
use app\controller\Controller as uController;

class WidokiException extends \Exception{}

/**
* Wspólna klasa abstrakcyjna dla klas warstwy widoku.
* Przechowuje referencję do obiektu klasy Controller 
* i zwraca dane przetworzone w obiektach klas warstwy widoku.
*
* @package Widok
* @author Daniel Drozdzel
*/	
abstract class Widoki {

/**
* Przechowuje refencje do obiektu klasy Controller.
* Chroniona składowa przechowuje refernecję do obiektu klasy Controller, który wywołał ten widok.
* @see \app\controller\Controller
*
* @var object  Controller
*/
	protected $insert;
	
/**
* Przechowuje wynik działania klas widoku.
* Przechowuje kod HTML ustanawianych metodą show() w klasach widoku.
* 
* @var array  tablica wyników metody show()
*/		
	protected $wynik;

/**
* Konstruktor klas warstwy widoku.
* Przyjmuje w wywołaniu referencję obiektu klasy Controller i wywołuje metode addInsert().
* Wywołuje również metody show() oraz setWynik().
*
* @param $nw  obiekt klasy Controller
*/
	public function __construct(uController $nw) {
		$this->addInsert($nw);
		$this->show();
		$this->setWynik();	
	}
		
/**
* Przekazuje referencję obiektu klasy Controller do składowej $insert.
* Przyjmuje w wywołaniu referencję obiektu klasy Controller i przekazuje ją do składowej $insert.
* Jeśli obiekt w wywołaniu nie jest obiektem typu Controller zrzuca wyjątek.
*
* @param $nw  obiekt klasy Controller
*
*/		
	private function addInsert(uController $control) {
		if(! ($control instanceOf uController)) {
			throw new WidokiException("Błąd warstwy widoku aplikacji");
		}
		$this->insert = $control;		
	}


/**
* Ustawia w składowej $wynikModel klasy Controller wynik działania warstwy widoku.
* Pobiera wynik działania obiektu warstwy widoku ze składowej $wynik i przekazuje
* go do składowej $wynikModel referencji obiektu klasy Controller.
*
*/		
	protected function setWynik() {
		$this->insert->setWynikWidok($this->wynik);
	}
	
/**
* Wymusza użycie metody w klasach pochodnych
* 
*/		
	abstract protected function show();
	
	
}
	
	
	







?>