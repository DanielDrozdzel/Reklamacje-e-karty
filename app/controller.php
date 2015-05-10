<?php
namespace app\controller;

require_once("request.php");
use app\request\Request as uRequest;

class ConException extends \Exception {}

/**
* Kontroler aplikacji reklamacje.
* Na podstawie przesłanego żądania określa jaki model zapisania albo pozyskiwania danych z bazych danych użyje aplikacja oraz
* który widok interfejsu zostanie jej przypisany. 
* 
* @package main
* @author Daniel Drozdzel
*/
class controller {

/**
* Zawiera referencję obiektu klasy Request.
* Referencje obiektów przypisane metodą addRequest.
*
* @var object Reuqest
*/
	private $requests;
	
	
/**
* Przechowuje wynik działania warstwy modelowej.
* Przechowuje wynik działania aplikacji w warstwie modelowej. Ustanowione metodą setWynikModel().
*
* @var array  wynik Model
*/	
	private $wynikModel;
	
/**
* Przechowuje wynik działania warstwy widoku.
* Przechowuje wynik dla działania aplikacji w warstwie widoku ustanowiony metodą setWynikWidok().
*
* @var string  wynik Widok
*/	
	private $wynikWidok;
	
/**
* Konstruktor klasy Controller
* Wywołuje metody odpowiedzielna za pozyskanie żądania, modelu, widoku oraz przekazania danych wyjściowych aplikacji
* do jego interfejsu webowego. W przypadku zrzucenia wyjątku w systemie przekazuje jego komunikat do interfejsu, 
* oraz wywołuje obiekt klasy Error, któremu przekazuje referencję do obiektu wyjątku.
* Jeśli klasa jest testowana, konstruktor wywołany z parametrem $testmode
*
* @param  $testmode  null/string   string tylko jeśli testowany
*
* @see Error
*/		
	public function __construct($testmode = null) {
	try{
		$this->addRequest($testmode);
		$this->getModel();
		$this->getView();
		$this->getWynikWidok();
	} catch (\Exception $e) {
		if($testmode == null) {
		print "<div class='error'>". $e->getMessage()."</span>";
		}
		require_once("error/error.php");
		$er = new \Error($e);
		
	}
	}
	
/**
* Tworzy obiekt Request i dodaje jego referencję do składowej $requests.
* Tworzy nowy obiekt Request i przekazuje jego referencje do składowej $request.
* Zrzuca wyjątek w przypadku niepowodzenia.
* Jeśli klasa jest testowana, obiekt wywołany z parametrem $testmode
*
* @param  $testmode  null/string   string tylko jeśli testowany
* 
* @see \app\Request\Request
*/		
	private function addRequest($testmode) {
	$request = new uRequest($testmode);
	if(!class_exists(get_class($request))) {
			throw new ConException("Błąd kontrolera aplikacji");
	}
	$this->requests = $request;
	}	

/**
* Pobiera kierunek działania aplikacji z referencji obiektu Request.
* Z zapisanej w składowej $requests referencji obiektu Request pobiera dalszy kierunek działania aplikacji.
* @see \app\Request\Request::getDestination().
* Wywoływana z wnętrza metod getView() oraz getModel().
* 
* @return string  cel żądania
*/	
	public function findDestination() {
		return $this->requests->getDestination();	
	}
	
/**
* Pobiera wszystkie parametry żądania referencji obiektu Request.
* Z zapisanej w składowej $request referencji obiektu Request  
* pobiera wszystkie parametry żadąnia obiektu wykorzystując metodę getProperties().
* @see \app\Request\Request::getProperties()
* Wywoływana przez obiekty warstwy aplikacji oraz warstwy widoku.
* 
* @return array  tablica parametrów żądania
*/		
	public function getAll() {
		return $this->requests->getProperties();
	}
	
/**
* Zwraca wybraną wartość parametru żądania wg. klucza.
* Z zapisanej w składowej $request referencji obiektu Request pobiera wartość wg. wywołanego w metodzie klucza.
* @see \app\Request\Request::getProperty()
*
* @param string  klucz
* @return string  wartość wg. klucza
*/		
	public function getProp($key) {
		return $this->requests->getProperty($key);
	}
	
/**
* Sprawdza istnienie pliku z klasą wartstwy widoku lub modelu.
* Na podstawie parametrów wywołania sprawdza czy istnieje plik z nazwą odpowiadającą nazwie klasy oraz sama klasa.
* W obu przypadkach jesli nie istnieją metoda zrzuca wyjątek. Wywoływana w metodach: getModel() oraz getView().
*
* @param $name string  nazwa klasy
* @param $name_req string  ścieżka do klasy
* @return object  klasa modelu lub widoku
*/	
	private function check($name, $name_req) {
		if(file_exists($name_req)) {
			require_once($name_req);
		} else {
			throw new ConException("Żądany plik z klasą ".$name." nie istnieje");
		}
		
		if(class_exists($name)) {
			return new $name($this);
		} else {
			throw new ConException("Żądana klasa ".$name." nie istnieje");
		}
	}

/**
* Wybiera klasę warstwy modelu.
* Na podstawie stringu pozyskanego z metody findDestination() wybiera pożądana klasą warstwy modelowej oraz 
* wywołuje jego obiekt wywołaniem metody check(). 
*/		
	private function getModel() {
		$name = strtolower($this->findDestination());	
		$name_req = "model/".$name.".php";
		$this->check($name, $name_req);
	}

/**
* Wybiera klasę warstwy widoku.
* Na podstawie stringu pozyskanego z metody findDestination() wybiera pożądana klasą warstwy widoku oraz 
* wywołuje jego obiekt wywołaniem metody check(). 
*/		
	private function getView() {
		$name = strtolower($this->findDestination());
		$name.= "_view";
		$name_req = "view/".$name.".php";
		$this->check($name, $name_req);
	}
	
/**
* Ustawia wynik działania warstwy modelowej w składowej $wynikModel.
* Wywoływana w obiektach klasy warstwy modelowej zapisuje wynik iego działania w składowej $wynikModel.
* @uses \app\model\Model::setWynik().
*
* @param array  tablica wyniku modelu
*/		
	public function setWynikModel(array $wynik) {
		$this->wynikModel = $wynik;
	}

/**
* Zwraca wartość składowej $wynikModel.
* Wywoływana w obiektach klasy warstwy widoku zwraca tablicę z wartościami ze składowej $wynikModel.
* @see \app\widoki\Widoki::show()
*
* @return array  wynik model
*/		
	public function getWynikModel() {
		return $this->wynikModel;
	}

	
/**
* Ustawia wynik działania warstwy widoku w składowej $wynikWidok.
* Wywoływana w obiektach klasy warstwy widoku zapisuje wynik iego działania w składowej $wynikModel.
* @uses \app\widoki\Widoki::setWynik()
*
* @param string  wynik Widok
*/		
	public function setWynikWidok($wynik) {
		$this->wynikWidok = $wynik;
	}

/**
* Wyświetla wynik działania aplikacji.
* Pobiera wynik działania warstwy modelowej ze składowej $wynikWidok i wyświetla go w interfejsie aplikacji.
* 
*/	
	private function getWynikWidok() {
		print $this->wynikWidok;
	}
}

session_start();
if(isset($_SESSION["uzyt"])) {
	$nw= new Controller();
}
	
?>