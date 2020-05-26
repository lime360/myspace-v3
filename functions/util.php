<?php
//get rank. returns rank as a string
function getRank($username, $connection) {
	
}

//get if user session has the rank "banned"
function ifBanned($username) {
	
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function validateCSS($validate) {
	$searchVal = array("<", ">", "<?php", "?>", "behavior: url"); 
	$replaceVal = array("", "", "", "", "", ""); 
	$validated = str_replace($searchVal, $replaceVal, $validate); 
    return $validated;
}

function getID($user, $connection) {
	$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->bind_param("s", $user);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) return('error');
	while($row = $result->fetch_assoc()) {
		$id = $row['id'];
	} 
	$stmt->close();
	return $id;
}

function getPFP($user, $connection) {
	$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->bind_param("s", $user);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) return('error');
	while($row = $result->fetch_assoc()) {
		$pfp = $row['pfp'];
	} 
	$stmt->close();
	return $pfp;
}
?>