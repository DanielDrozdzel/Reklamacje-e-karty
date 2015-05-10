<?php
use app\widoki\Widoki as uWidoki;
require_once("widoki.php");


/**
* Wyświetla wynik działania klasy Pokaz.
* Zwraca kod HTML będący wynikiem tworzenia formularza zmian danych.
* @see Pokaz
*
* @package Widok
* @auhtor Daniel Drozdzel
*/
class Pokaz_view extends uWidoki {

/**
* Tworzy kod HTML z wynikiem działania modelu.
* Pobiera wynik działania obiektu warstwy model z referencji obiektu klasy Controller.
* @see \app\controller\Controller::getWynikModel()
*
* Na podstawie tablicy tworzy kod HTML formularza i przekazuje do składowej $wynik.
*/
	protected function show() {
		$dane = $this->insert->getWynikModel();
		
		$html = "<div id='popraw'><p style='text-align:center'> REKLAMACJA NR.".$dane["id"];
		$html .= "<form name='form_zmien' id='form_zmien' action='controller.php' method='POST'>";
		
		foreach($dane as $key=>$val) {
			if($key === "id") {
				$html .= "<p>".strtoupper($key).": <input type='text' id='".$key."' name='".$key."' size='20' value='".$val."' readonly='readonly'/></p> ";
			} else if($key ==="ekstra") {
				$html .= "<p>Ekstra: <textarea rows='3' cols='20' name='ekstra'>".$val."</textarea><p>";
			} else {
				$key = ucfirst($key);
				$val = ucfirst($val);
				$html .= "<p>".$key.": <input type='text' class='".$key."' name='".$key."' size='20' value='".$val."' /></p> ";
			}
		}
		$html .= "<p style='text-align: center;'><input type='submit' value='Zmien' name='sprawdz'><p></form></div>";
		
		$this->wynik = $html;	
	}
}

?>