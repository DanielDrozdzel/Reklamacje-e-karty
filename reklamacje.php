<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset = "utf8">
	<title>Reklamacje</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="script/skrypty.js"></script>
	<script type="text/javascript" src="script/zebra_datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" href="styles/default.css" type="text/css">
	
  </head>
  <body>
<?php
	if(!isset($_SESSION['uzyt'])) {  //jeśli nie istnieje zmienna sesji wyświetla formularz logowania
?>
	<div id="login">
	<p> Login: admin, hasło: admin1 :) </p>
		<form action="log.php" method="post" id="log_form" name="log_form">
			<p> Login: <input type="text" name="username" required="required" /> </p>
            <p> Hasło: <input type="password" name="password" required="required" /> </p>
            <input type="submit" value="Zaloguj" />
		</form>
<?php
	if(isset($_GET['i'])) {  //jeśli istnieje żądanie GET['i']  
		if($_GET['i'] == "error") {   //o wartości "error"
			print "<p> Nieprawidłowe dane </p>";
		} else if($_GET['i'] == "logout")  //o wartości "logout"
			print "<p> Wylogowałeś się </p>";
	}
?>
	</div>	

<?php
	} else { //jeśli istnieje zmienna sesji
?>
	<div id="logout"> Wyloguj</div>
	  <div id="kontener">
		<div id="naglowek">
			<p> REKLAMACJE </p>
			
		</div>
		<div id="formularz">
		  <form name="form_rek" id="form_rek" action="controller.php" method="post">
		    <div id="jednostkowe">
			  <p> ID: <input type="text" name="id" id="rek_id" tabindex="1" size="3" value="" /> </p>
		      <p> Data: <input type="text" class = "Data" id="data" tabindex="2" name="data" size="10" value="" /> </p>
		      <p> Imię: <input type="text" id="imie" name="imie" tabindex="3" size="20" /> </p>
		   	  <p> Nazwisko: <input type="text" id="nazwisko" name="nazwisko" tabindex="4" size="20" /> </p>
			  <p> E-Karta: <input type="text" class="Karta" name="karta" tabindex="5" size="11" /> </p>
			  <p> Wartość: <input type="text" class="Kwota" name="kwota" tabindex="6" size="6" /> </p>
			  <p> Stan: <input type="text" id="stan" name="stan" tabindex="7" size="10" /> </p>
		    </div>
		    <p> 
		      Miejsce: MPS Plac Wolności<input type="radio" id="MPS" name="miejsce" tabindex="8" value="MPS" checked="checked" /> 
			  ZTZ Dworzec <input type="radio" id="ZTZ" name="miejsce"  value="ZTZ" />
		      Wszystko <input type="radio" id="All" name="miejsce" value="" />
	        </p>
		   <p> 
		      Dodatkowe info: <textarea rows="3" tabindex="9" cols="20" name="ekstra"></textarea>
		   </p>
		   <p> 
			 <input type="submit" value="Zapisz" tabindex="10" name="sprawdz" /> 
			 <input type="submit" value="Znajdz" tabindex="11" name="sprawdz" /> 
		   </p>
		  </form>
	    </div>
	  <div id="wyniki">
	  </div>
	</div>
	<?php } ?>
  </body>
</html>
	

