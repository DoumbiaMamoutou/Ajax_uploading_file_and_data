<?php

	$data = new PDO("mysql:host=localhost;dbname=td_php", "root", "");
	
	$commune = $data->prepare("SELECT * FROM commune");
	$commune->execute(array());
	$liste_commune = $commune->fetchAll();

	$ville = $data->prepare("SELECT * FROM ville");
	$ville->execute(array());
	$liste_ville = $ville->fetchAll();

	$error = [];

	if (!empty($_POST)) {
		$uploadedFile = '';
		if (!empty($_FILES["photo"]["type"])) {
			$fileName = $_FILES['photo']['name'];
			$valid_extensions = array("jpeg", 'jpg', "png");
			$temporary = explode(".", $_FILES["photo"]["name"]);
			$file_extension = end($temporary);

			if ((($_FILES["photo"]["type"] == "image/png") || ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
				$sourcePath = $_FILES['photo']['tmp_name'];
				$targetPath = "../images/" .$fileName;
				if (move_uploaded_file($sourcePath, $targetPath)) {
					$uploadedFile = $fileName;
				}
			}
		}
		$name = checkInput($_POST['name']);
		$lastname = checkInput($_POST['lastname']);
		$birth = checkInput($_POST['birth']);
		$contact = checkInput($_POST['contact']);
		$email = checkInput($_POST['email']);
		$ville = checkInput($_POST['ville']);
		$commune = checkInput($_POST['commune']);
		$commentaire = checkInput($_POST['commentaire']);
		$school = checkInput($_POST['school']);

		if (empty($name) && empty($lastname) && empty($birth) && empty($contact) && empty($email) && empty($ville) && empty($commune) && empty($school) && empty($commentaire)) {
			$error[] = "Erreur !";
		}
		else
        {
            $data->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$query = $data->prepare("INSERT INTO users (name, lastname, birth, contact, email, ville, commune, school, commentaire, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$result = $query->execute(array($name,$lastname,$birth,$contact,$email,$ville,$commune,$school,$commentaire,$uploadedFile));
		}
		echo $query?'ok':'err';	
		//echo json_encode($result);	
	}

	function checkInput($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
