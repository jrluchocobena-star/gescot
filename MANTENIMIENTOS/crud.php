<?php
$action = $_POST['action'];
$crud = new Crud();

if ($action == 'create') {
	$name = $_POST['name'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$age = $_POST['age'];
	$birthday = $_POST['birthday'];
	
	$data = $crud->create($name,$lastname,$email,$age,$birthday);
	echo $data;
}elseif ($action == 'read') {
	$data = $crud->read();
	echo $data;
}elseif ($action == 'edit') {
	$id = $_POST['id'];
	$data = $crud->edit($id);
	echo $data;
}elseif ($action == 'delete') {
	$id = $_POST['id'];
	$data = $crud->delete($id);
	echo $data;
}elseif ($action == 'update') {
	$id_p = $_POST['id_p'];
	$name = $_POST['name'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$age = $_POST['age'];
	$birthday = $_POST['birthday'];
	$data = $crud->update($id_p,$name,$lastname,$email,$age,$birthday);
	echo $data;
}

/**
* 
*/
class Crud{
	public $conn = null;
	function __construct(){
		$this->conn = new mysqli('localhost','root','','GESCOT');
	}
	
	function create($name,$lastname,$email,$age,$birthday){
		$con = $this->conn->query("INSERT INTO persona(name,lastname,email,age,birthday) VALUES('".$name."','".$lastname."','".$email."',".$age.",'".$birthday."')");
		if ($con) {
			return 'true';
		}else{
			return 'false';
		}
	}

	function read(){
		$table = "<table class='table'>
					<tr>
						<th>Name</th>
						<th>Lastname</th>
						<th>E-mail</th>
						<th>Age</th>
						<th>Birthday</th>
						<th>Opciones</th>
					</tr>";
		$res = $this->conn->query("SELECT * FROM persona");
		if ($res->num_rows > 0) {
			while ($row = $res->fetch_array()) {
				$table .= "<tr>";
				$table .= "<td>".$row['name']."</td>";
				$table .= "<td>".$row['lastname']."</td>";
				$table .= "<td>".$row['email']."</td>";
				$table .= "<td>".$row['age']."</td>";
				$table .= "<td>".$row['birthday']."</td>";
				$table .= "<td>
							<a href='#' onclick='delete_row(".$row['id'].");return false'>Eliminar</a>
							<a href='#' onclick='edit_row(".$row['id'].");return false'>Editar</a></td>";
				$table .= "</tr>";
			}
			$table.="</table>";
			return $table;
		}else{
			$table.="</table>";
			return $table;
		}
	}

	function edit($id){
		$jsondata = array();
		$res = $this->conn->query("SELECT * FROM persona WHERE id=".$id);
		while ($row = $res->fetch_array()){
			$jsondata['id'] = $row['id'];
			$jsondata['name'] = $row['name'];
			$jsondata['lastname'] = $row['lastname'];
			$jsondata['email'] = $row['email'];
			$jsondata['age'] = $row['age'];
			$jsondata['birthday'] = $row['birthday'];
			header('Content-type: application/json; charset=utf-8');
    		return json_encode($jsondata);
    		exit();
		}
	}
	function delete($id){
		$con = $this->conn->query("DELETE FROM persona WHERE id=".$id);
		if ($con) {
			return "true";
		}else{
			return "false";
		}
	}

	function update($id_p,$name,$lastname,$email,$age,$birthday){
		$con = $this->conn->query("UPDATE persona SET name='".$name."', lastname='".$lastname."', email='".$email."', age=".$age.", birthday='".$birthday."' WHERE id=".$id_p);
		if ($con) {
			return 'true';
		}else{
			return 'false';
		}
	}
}
?>