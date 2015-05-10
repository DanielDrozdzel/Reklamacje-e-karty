<?php
use app\widoki\Widoki as uWidoki;
require_once("widoki.php");

/**
* Wyświetla wynik działania klasy Zmien.
* Zwraca kod HTML będący wynikiem zmianych danych w bazie.
* @see Zmien
*
* @package Widok
* @autor Daniel Drozdzel
*/
class Zmien_view extends uWidoki {

/**
* Tworzy kod HTML z wynikiem działania modelu
* Pobiera wynik działania obiektu warstwy model z referencji obiektu klasy Controller
* @see \app\controller\Controller::getWynikModel()
* Na podstawie tablicy tworzy kod HTML i przekazuje do składowej $wynik
*/
	protected function show() {
		$dane = $this->insert->getWynikModel();
		
		$html = "<p>Zmieniono dane reklamacji nr. ".$dane["id"]." na: </p><table><tr>";
		foreach($dane as $key=>$val) {
			$html .= "<td><a class='hrefs' href='nr=".$dane['id']."'>".strtoupper($key)." : ".ucfirst($val)."</a></td>";
		}
		$html .="</tr></table>";
		$this->wynik = $html;
	
		
	}
}

?>