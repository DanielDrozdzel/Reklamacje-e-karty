<?php
require_once("Auth.php");  //Do poprawnego logowania skrypt wymaga zainstalowania pakietu PEAR::Auth
session_start();

$options = array(  //na potrzeby demonstracyjne hasło i login zapisano w prostej tablicy, a nie w bazie danych :)
    'users' => array(
    'admin' => 'admin1'  //login i hasło
    )
);

$a = new Auth('Array', $options);
$a->setShowLogin(false);
$a->start();

if ($a->checkAuth()) {
    if ((isset($_POST['username'])) && ($_POST['password'])) {  //Jeśli dane są poprawne następuje logowanie do app reklamacji
		$_SESSION['uzyt'] = $_POST['password'];  //utworzenie zmiennej sesji     
		 header("Location: reklamacje.php");  
    } else {  //po wylogowaniu 
		unset($_SESSION['uzyt']);  //odwołanie zmiennej sesji
		session_destroy();    //znieszczenie sesji
		header("Location: reklamacje.php?i=logout");	//ponowne wywołanie formularza loginu z żądaniem GET o wartości "logout"
    }
} else {
    header("Location: reklamacje.php?i=error"); //w przypadku nieprawidłowego loginu lub hasła ponowne wywołanie formularza loginu z żadniem GET o wartości "Error"
}


?>