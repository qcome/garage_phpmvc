<?php

/*function getClient($id){
	$connexion=getConnect();
	$req="select * from client where client_id = ".$id;
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	while($result = $res->fetch()){
		echo $result->client_firstname;
	}
	$res->closeCursor();
}*/

function connexionEmployee($user, $pwd){
	$connexion=getConnect();
	$req="select c.cat_name, e.empl_id from employe e INNER JOIN categorie_employe c ON 
			e.empl_catid = c.cat_id where e.empl_identifiant='".$user."' and e.empl_password='".$pwd."'";
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	$ligne=$res->fetch();
	
	$res->closeCursor();
	#si la requete n'a pas de ligne
	if ($ligne == false)
		throw new Exception("login ou mdp incorrect");
	else
		return $ligne;
}

function getClientInterventions($id_client){
	$connexion=getConnect();
	$req="select * from client c LEFT JOIN intervention i ON 
			c.client_id = i.interv_client LEFT JOIN type_intervention t ON
			i.interv_typeid = t.typeinterv_id LEFT JOIN employe e ON
			i.interv_mecanicien = e.empl_id LEFT JOIN etat_facture f ON
			f.etat_facture_char = i.interv_etatfacture
			WHERE c.client_id=".$id_client." ORDER BY i.interv_etatfacture ASC";
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	
	if ($result = $res->fetchAll()) {
		$res->closeCursor();
        return $result;
    }
	$res->closeCursor();
	throw new Exception("Client inconnu au bataillon");
}

function updatePaiementInterventions($id_client, $tab_interventions, $interventionsChecked){
	$connexion=getConnect();
	$req="UPDATE intervention SET interv_etatfacture='P' WHERE interv_id IN (";
	foreach ($interventionsChecked as $intervention){
		$req.= $tab_interventions[$intervention]->interv_id;
		if (next($interventionsChecked)==true) 
			$req.= ",";
		else
			$req.=")";
	}
	$res=$connexion->query($req); 
	$res->closeCursor();
	return $res;
	
}

function updateDiffererInterventions($id_client, $tab_interventions, $interventionsChecked){
	$connexion=getConnect();
	$req="UPDATE intervention SET interv_etatfacture='DF' WHERE interv_id IN (";
	foreach ($interventionsChecked as $intervention){
		$req.= $tab_interventions[$intervention]->interv_id;
		if (next($interventionsChecked)==true) 
			$req.= ",";
		else
			$req.=")";
	}
	$res=$connexion->query($req); 
	$res->closeCursor();
	return $res;
}

function updateDiffereMaxClient($id_client, $diff_input){
	$connexion=getConnect();
	$req="UPDATE client SET client_maxdiff=".$diff_input." WHERE client_id=".$id_client;
	$res=$connexion->query($req); 
	$res->closeCursor();
	return $res;
}

function getClientId($client_name, $client_birthday){
	$connexion=getConnect();
	$req="select client_id from client where client_lastname = '".$client_name."' AND client_birthday = '".$client_birthday."'";
	$res=$connexion->query($req); 
	$result = $res->fetchColumn();
	$res->closeCursor();
	return $result;
}

function getClient($id_client){
	$connexion=getConnect();
	$req="select * from client c WHERE c.client_id=".$id_client;
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	
	if ($result = $res->fetchAll()) {
		$res->closeCursor();
        return $result;
    }
	$res->closeCursor();
	throw new Exception("Client inconnu au bataillon");
}

function insertClient($prenom_client, $nom_client, $adresse_client, $phone_client, $mail_client, $birthday_client, $diff_client){
	$connexion=getConnect(); 
	$req="INSERT INTO client (client_firstname, client_lastname, client_address, client_phonenum, client_mail, client_birthday, client_maxdiff) VALUES 
		('".$prenom_client."', '".$nom_client."', '".$adresse_client."', '".$phone_client."', '".$mail_client."', '".$birthday_client."', '".$diff_client."')";
	$res=$connexion->query($req); 
	$res->closeCursor(); 
}

function getConnect(){
	$connexion=new PDO('mysql:host=localhost;dbname=bd_garage',"root","");
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}


