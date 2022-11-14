<?php session_start();  
    $pass = 12345;
    if(isset($_POST['sessionstop'])){  
        unset($_SESSION['pass']);  
        session_destroy();  
    }  
    if(!isset($_POST['pass'])){  
        if(!isset($_SESSION['pass'])){  
            header('Content-Type: text/html; charset=utf-8');  
            die("Geben Sie Password<br> 
                <form method='POST' action=''> 
                    <input type='text' name='pass'> 
                    <input type='submit' value='Senden'> 
                </form> ");  
        }  
        else {  
            if($_SESSION['pass'] != $pass){  
                header('Content-Type: text/html; charset=utf-8');  
                die("Falsches Passwort<br>Geben Sie Password<br> 
                    <form method='POST' action=''> 
                        <input type='text' name='pass'> 
                        <input type='submit' value='Senden'> 
                    </form>");  
            }  
        }  
    }  
    else {  
        $_SESSION['pass'] = $_POST['pass'];  
    }  
    if($_SESSION['pass'] != $pass){  
        header('Content-Type: text/html; charset=utf-8');  
        die("Falsches Passwort<br>Geben Sie Password<br> 
            <form method='POST' action=''> 
                <input type='text' name='pass'> 
                <input type='submit' value='Senden'> 
            </form>");  
    }  
?>  
<br>  
<form method="post" action="" style="margin-left:15px;">  
    <input type="hidden" name="sessionstop">  
    <input type="submit" value="Ausgang">  
</form>  
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<title>Test</title>
</head>
<body>
<div class="container-fluid">
<nav id="angrif" class="navbar navbar-expand-lg navbar-light bg-light mb-2"></nav>
<div class="container-fluid">
    <div class="row mb-3">
        <div id="userDataBlock" class="col-md-4 themed-grid-col"></div>
		<div class="col-md-8 themed-grid-col">
		  <div class="pb-3 w-50 mx-auto">
            <button id="user_rechnungen" type="button" value="" class="btn btn-primary" onclick="execute('jsonParse.php?suche=user_rechnungen&param=' + this.value); ergebnisse(this.id);"></button>
		  </div>
		  <div class="row">
			<div id="rechnung1" class="col-md-6 themed-grid-col">Hier wird ein randomischer Artikel</div>
			<div id="rechnung2" class="col-md-6 themed-grid-col">Und hier ist der zweite</div>
		  </div>
          <div class="pb-3 w-50 mx-auto">
            <br><hr>
            Suche nach Daten in artikel-API mit Searchparameter: kundennummer und in auftraege-API mit Searchparameter: name_de<hr>
            <div class="form-group">
                <label for="artikel">Artikel. Geben Sie bitte Kundennummer für Artikel (z.B. 10000)</label>
                <input type="text" class="form-control" id="artikel" placeholder="Kundennummer">
                <label for="auftraege">Aufträge. Geben Sie bitte Kundenname für Aufträge (z.B. Shopware Test)</label>
                <input type="text" class="form-control" id="auftraege" placeholder="Name">
            </div>
            <button id="suchen" type="button" class="btn btn-primary" onclick="execute('jsonParse.php?suche=search&artikel=' + document.getElementById('artikel').value + '&auftraege=' + document.getElementById('auftraege').value); ergebnisse(this.id);">Artikel und Aufträge Suchen</button>
		  </div>
		</div>
        <div id="artikelAuftraege" class="col-md-12 themed-grid-col bg-dark text-white">Hier werden artikel-API und auftraege-API Daten</div>
	</div>
</div>
</div>
<script src="js/script.js"></script>
</body>
</html>