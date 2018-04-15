<?php
	header( 'content-type: text/html; charset=utf-8' );
	extract($_POST);
	$dbConn = new mysqli("localhost", "madbinc", "futrinervi46","my_madbinc");
	if (!$dbConn) {
		die("Impossibile connettersi: " . mysql_error());
	}
	$dbConn->set_charset("utf8");
	$output="";
	$esitoOp = "";
	session_start();
	
	$risultato= $dbConn->query("SELECT codice_proprieta,nome,citta FROM elenco_proprieta;");
	if(!$risultato){
		die("Impossibile eseguire la query: " . mysql_error());
	}
	while(($row = $risultato->fetch_assoc()) != NULL){
		$output.="<tr>";
		$output.="<td> <input type=\"radio\" name=\"scelta\" value=\"$row[codice_proprieta]\"> </td>";
		foreach ($row as $key => $value) {
			$output.="<td class=\"dato\">$value</td>";
		}
		$output.="</tr>";
	}
	if(isset($elenco_sensori)) {
		$_SESSION["cm"]=$scelta;
		header("Location: Gestione-sensori.php");
	}
	if(isset($inserisci_proprieta)) {
		$_SESSION["azione"]="insert";
		$_SESSION["cm1"]=null;
		header("Location: Inserimento-Modifica-Museo.php");
	}
	elseif(isset($elimina_proprieta)) {
		$codice_museo=$scelta;
		$risultato2= $dbConn->query("DELETE FROM elenco_sensori WHERE codice_propieta = '$codice_proprieta';");
		$risultato3= $dbConn->query("DELETE FROM elenco_proprieta WHERE codice_proprieta = '$codice_proprieta';");
		if(!$risultato2){
			die("Impossibile eseguire la query: " . mysql_error());
		}
		if(!$risultato3){
			die("Impossibile eseguire la query: " . mysql_error());
		}
		$esitoOp="<h6>Museo eliminato</h6>";
		header("Location: gestioneproprieta_admin.php");
	} elseif(isset($modifica_proprieta)) {
		$_SESSION["azione"]="update";
		$_SESSION["cm1"]=$scelta;
		header("Location: Inserimento-Modifica-Museo.php");
	}
	$dbConn->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina Gestione Contesto</title>
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
p.colonne {
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
<form action="Gestione-sensori.php" method="post">
<h2> &nbsp; ELENCO CONTESTO</h2>
<?php print("$esitoOp"); ?>
<table class="contenitore_uno"><tr class="contenitore_uno"><td class="contenitore_uno">
	<table>
		<tr>
			<td width="5"></td>
			<td width="185"><p class="colonne">Codice Contesto</p></td>
			<td width="165"><p class="colonne">Nome</p></td>
			<td width="330"><p class="colonne">Città</p></td>
		</tr>
		<tr>
		<?php
			print($output);
		?>
		</tr>
	</table>
</td></tr></table>
<input type="submit" value="ELENCO SENSORI" name="elenco_opere" class="bottone"/></br>
<input type="button" value="TORNA ALLA HOME" name="torna_alla_home" onclick="document.location.href='index.php'" class="bottone" style="margin-top: 15%; margin-left: 77%"/>
</form>
</body>
</html>
