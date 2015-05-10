<?php
/**
* Obsługuje wyjątek przekazany przez obiekty klasy Controller.
* Obiekt klasy Error przyjmuje w wywołaniu referencje obiektu wyjątku przekazaną przez klasę Controller
* i zapisuje okoliczności wywołania wyjątku aplikacji w pliku tekstowym "error_log".
* Obiekty klasy Error w aplikacji wywoływane są tylko z poziomu konstruktora obiektu klasy Controller
* @see \app\controller\Controller::__construct() Konstruktor Controller
*
* @package error
* @author Daniel Drozdzel
*/

class Error {
/**
* Prywatna zmienna $err przechowuje referencję obiektu wyjątku przekazany przez konstruktora klasy.
* @var object  obiekt klasy Exception.
*
*/
	private $err;
	
/**
*  Konstruktor klasy Error.
*  Przyjmuje w wywołaniu referencję obiektu klasy Exception przekazaną przez obiekt klasy Controller.
*  Zapisuje referencję obiektu Exception w zmiennej $err oraz wywołuje funkcję ErrorLog.
*  @param $error obiekt Exception.
*/	
	public function __construct(Exception $error) {
		$this->err = $error;
		$this->ErrorLog();
	}
	
/**
*	Zapisuje okoliczności zrzecenia wyjątku w pliku tekstowym.
*   Metoda pobiera referencję obiektu wyjątku ze składowej $err i wraz z datą zapisuje okoliczności 
*   jego wystąpienia jako string w pliku tekstowym error_log.txt. Jeśli plik tekstowy nie istnieje
*   zostaje utworzony. Na potrzeby testów jeśli dane zostaną zapisane w pliku tekstowym zwraca true,
*	w przeciwnym wypadku zwraca false.
*
*  @return bool  potwierdzenie/wystąpienie błędu
*/		

	public function ErrorLog() {
		$erka = date("c")." -> ";
		$erka .= $this->err->__toString()."\r\n";
		if(file_put_contents('error/error_log.txt', $erka, FILE_APPEND)) {
			return true;
		} else {
			return false;
		}
	}
	
	
}
	
	
	
	
	







?>