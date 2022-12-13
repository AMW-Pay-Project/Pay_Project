<?php

	ob_start();
	
	require_once('./config.php');
	
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
        <title>Strona główna</title>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="images/logo.png" style="float:left;" height="150px">
                <p class="napisLogo">AMW</p>
                <p class="napisLogo">Pay</p>
                <p class="napisLogo">Project</p>
            </div>
			
			<?php
			
				if(isset($_SESSION['LOGGED'])) {
					
					$query = $mySQL->prepare("SELECT `name`, `surname` FROM `users` WHERE `id`=:one");
					$query->bindValue(":one", $_SESSION['USER_ID'], PDO::PARAM_INT);
					$query->execute();
					
					$fetch = $query->fetch();
					
					echo '<div class="login">
						Witaj '.$fetch['name'].' '.$fetch['surname'].' &nbsp;&nbsp;&nbsp; <a href="logout.php"><button id="zaloguj">Wyloguj się</button></a>
					</div>';
					
					echo '<div class="konto">
						<a href="konto.html" class="navL"><p class="nav">Konto</p></a>
					</div>
					<div class="transakcje">
						<a href="transakcje.html" class="navL"><p class="nav">Transakcje</p></a>
					</div>
					<div class="historia">
						<a href="historia.html" class="navL"><p class="nav">Historia</p></a>
					</div>
					<div class="portfel">
						<a href="portfel.html" class="navL"><p class="nav">Portfel</p></a>
					</div>
					<div class="ustawienia">
						<a href="ustawienia.html" class="navL"><p class="nav">Ustawienia</p></a>
					</div>';

					
				} else {
					
					echo '<div class="login">
						<a href="register.php"><button id="zaloz">Załóż konto</button></a>
						<a href="login.php"><button id="zaloguj">Zaloguj się</button></a>
					</div>';
					
					echo '<div class="konto">
						<a href="index.php" class="navL"><p class="nav">Strona główna</p></a>
					</div>
					<div class="transakcje">
						<a href="#" class="navL"><p class="nav">Informacje</p></a>
					</div>
					<div class="historia">
						<a href="#" class="navL"><p class="nav">Oferty</p></a>
					</div>
					<div class="portfel">
						<a href="#" class="navL"><p class="nav">O nas</p></a>
					</div>
					<div class="ustawienia">
						<a href="#" class="navL"><p class="nav">Kontakt</p></a>
					</div>';
					
				}
			
			?>
            <div class="mainL">
                <p id="masz">MASZ TO OD ZARAZ</p>
                <p id="oferta">Z naszą ofertą <b>wykonasz</b> dowolną transakcję w internecie</p>
                <p><a id="wiecej" href="wiecej.html">Więcej</a></p>
            </div>
            <div class="mainR">
                <img src="images/GigaOgrod.png" style="float:left;" height="400px">
            </div>
            <div class="info1">
                <p>Przykładowa informacja nr 1</p>
                <p>Przykładowa informacja nr 1</p>
                <p>Przykładowa informacja nr 1</p>
                <p>Przykładowa informacja nr 1</p>
            </div>
            <div class="info2">
                <p>Przykładowa informacja nr 2</p>
            </div>
            <div class="info3">
                <p>Przykładowa informacja nr 3</p>
            </div>
            <div class="stopka1">
                <p>Polityka prywatności</p>
            </div>
            <div class="stopka2">
                <p>Regulamin strony internetowej</p>
            </div>
            <div class="stopka3">

            </div>
            <div class="stopka4">
                <p>Infolinia (czynna 24h na dobę): <a id="numer">213 769 666</a></p>
            </div>
            <div class="stopkaD">
                <p>&copy; 2022 PP Polska</p>
            </div>
          </div>
    </body>
</html>

<?php

	ob_end_flush();
	
?>