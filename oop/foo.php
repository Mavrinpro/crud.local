<?php 

include 'db.php';

$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$get_id = $_GET['id'];
$min_length = 2;
$max_length = 25;
$limit = 10;
// Create
if (isset($_POST['add'])) {
	
	$sql = ("INSERT INTO users_1 SET name = :name, email = :email");
	$query = $pdo->prepare($sql);
	
	if (empty($name) && empty($email)) {
		header("Location: ?mess=empty");
		return false;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ?mess=email");
		return false;
	}
	if(strlen($name) < $min_length){
		header("Location: ?mess=min_length");
		return false;
	}
	if(strlen($name) > $max_length){
		header("Location: ?mess=max_length");
		return false;
	}
		
	 $query->execute(['name'=>$name, 'email'=>$email]);
	 if ($query) {
			header("Location: ?mess=success&user=$name");
		}else{
			$info = $pdo->errorInfo();
			print_r($info);
		}
}

// Read
 $sql = $pdo->prepare("SELECT * FROM users_1 WHERE flag = 0 ORDER BY `name` ASC LIMIT $limit");
 $sql->execute();
 $result = $sql->fetchAll(PDO::FETCH_OBJ);
 // Update

 if (isset($_POST['edit'])) {
 	$sql = ("UPDATE users_1 SET name=?, email=? WHERE id=?");
 	$query = $pdo->prepare($sql);
 	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ?mess=email");
		return false;
	}
	$query->execute([$name, $email, $get_id]);
	if ($query) {
		header("Location: ?mess=edit&id=$get_id");
	}
 }

 // Delete

 if (isset($_POST['delete'])) {
 	$sql = ("UPDATE users_1 SET  flag = 1 WHERE id = ?");
 	$query = $pdo->prepare($sql);
	$query->execute([$get_id]);
	if ($query) {
		header("Location: ?mess=delete&id=$get_id");
	}
 }