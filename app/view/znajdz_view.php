<?php
use app\widoki\Widoki as uWidoki;
require_once("widoki.php");

/**
* Wyświetla wynik działania klasy znajdz.
* Zwraca kod HTML będący wynikiem szukania danych w bazie.
* @see Znajdz
*
* @package Widok
* @autor Daniel Drozdzel
*/
class Znajdz_view extends uWidoki {


/**
* Tworzy kod HTML z wynikiem działania modelu.
* Pobiera wynik działania obiektu warstwy model oraz listę parametrów żadania referencji obiektu klasy Controller.
* @see \app\controller\Controller::getWynikModel()
* @see \app\controller\Controller::getAll()
*
* Na podstawie tablicy tworzy kod HTML i przekazuje do składowej $wynik.
*/
	protected function show() {
		$dane = $this->insert->getWynikModel();
		$keys = $this->insert->getAll();
		array_pop($keys);


		
		$html = "<table>";
		$html .= "<tr class='column'>";
		
		foreach($keys as $key=>$val) {
			$html.= "<td>".strtoupper($key)."</td>";
		}
		$html .="</tr>";
		foreach($dane as $row) {
		$html .= '<tr class="rows">';
			foreach ($row as $key=>$val) {
				$html .= "<td><a class='hrefs' href='nr=".$row["id"]."'>".ucfirst($val)."</a></td>";
			}
		$html .= "</tr>";
		}
		$html .= "</table>";
		
		$this->wynik = $html;
		
		
	}
}
		
	
?>