<?php
	header( 'content-type: text/html; charset=utf-8' );
	extract($_POST);
	$dbConn = new mysqli("localhost", "madbinc", "futrinervi46","my_madbinc");
	if (!$dbConn) {
		die("Impossibile connettersi: " . mysql_error());
	}
	$dbConn->set_charset("utf8");
	$output1="";
	$esitoOp = "";
	session_start();
	
	$cm = $_SESSION["cm"];
	$risultato1= $dbConn->query("SELECT codice_sensore, marca_sensore, valore, codice_errore, tipo FROM elenco_sensori WHERE codice_sens = '$cm';");
	if(!$risultato1){
		die("Impossibile eseguire la query: " . mysql_error());
	}
	while(($row1 = $risultato1->fetch_assoc()) != NULL){
		$output1.="<tr>";
		$output1.="<td> <input type=\"radio\" name=\"scelta1\" value=\"$row1[codice_opera]\"> </td>";
		foreach ($row1 as $key1 => $value1) {     
			$output1.="<td class=\"dato\">$value1</td>";
		}
		$output1.="</tr>";
	}
	if(isset($inserisci_opera)) {
		$_SESSION["azione"]="insert1";
		$_SESSION["co1"]=null;
		header("Location: Inserimento-Modifica-Opera.php");
	}
	elseif(isset($elimina_opera)) {
		$codice_opera=$scelta1;
		$risultato2= $dbConn->query("DELETE FROM elenco_sensori WHERE codice_sensore = '$codice_opera';");
		if(!$risultato2){
			die("Impossibile eseguire la query: " . mysql_error());
		}
		$esitoOp="<p>Opera eliminata</p>";
		header("Location: Gestione-Opere.php");
	} elseif(isset($modifica_opera)) {
		$_SESSION["azione"]="update";
		$_SESSION["co1"]=$scelta1;
		header("Location: Inserimento-Modifica-Opera.php");
	}
	$dbConn->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina Gestione Opere</title>
<style type="text/css">
body {
	background-color: #EDEDED;
}
h2 {
	font-family: Arial;
	font-size: 40px;
	color: black;
}
table,tr,td {
	text-align: center;
	margin-left: 1%;
	border: 1px solid black;
}
p {
	font-family: Georgia;
	font-size: 25px;
	color: black;
}
td.dato {
	font-family: "Times New Roman";
	font-size: 15px;
	color: black;
	border: 1px solid black;
}
table.contenitore_uno,tr.contenitore_uno ,td.contenitore_uno  {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	margin-top: -2%;
}
input.bottone {
	font-family: Georgia;
	font-size: 25px;
	font-weight: bold;
	color: black;
	background-color: #EEE8AA;
	text-align: center;
	border: 1px solid black;
	margin-top: 3%;
	margin-left: 2%;
}
input.bottone:hover {
	border: 2px solid black;
}
</style>
</head>

<body>
<form action="Gestione-Opere.php" method="post">
<h2> &nbsp; ELENCO SENSORI</h2>
<?php print("$esitoOp"); ?>
<table class="contenitore_uno"><tr class="contenitore_uno"><td class="contenitore_uno">
	<table>
		<tr>
			<td width="5"></td>
			<td width="180"><p>Codice </p></td>
			<td width="170"><p>Marca</p></td>
			<td width="300"><p>Descrizione</p></td>
            <td width="300"><p>Errori</p></td>
            <td width="300"><p>Modello</p></td>
		</tr>
		<?php 
			print($output1); ?>
	</table>
</td></tr></table>
</br>
<input type="submit" value="INSERISCI SENSORE" name="inserisci_opera" class="bottone"/>
<input type="submit" value="MODIFICA SENSORE" name="modifica_opera" class="bottone"/>
<input type="submit" value="ELIMINA SENSORE" name="elimina_opera" class="bottone"/>
<input type="button" value="TORNA ALLA HOME" name="torna_alla_home" onclick="document.location.href='index.php'" class="bottone" style="margin-top: 20%; margin-left: 75%"/>
</form>
</body>
</html>
