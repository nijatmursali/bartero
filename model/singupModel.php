<?php

/**
 *
 */
require_once 'config.php';
class singupModel {
	function __construct() {
		$this -> conset = new config();
	}

	public function openDB() {
		$this -> conn = new mysqli($this -> conset -> servername, $this -> conset -> username, $this -> conset -> password, $this -> conset -> dbname);
		if ($this -> conn -> connect_error) {
			die("Connection failed: " . $this -> conn -> connect_error);
			}
			}

	public function closeDB() {
		$this -> conn -> close();
	}

	public function singup($email, $fname, $lname, $mno, $pass) {

		$ccn = mysqli_connect("localhost","root","")or die("connecton error");
		mysqli_select_db($ccn,'barter');

	//	$email = $_POST['Email']
//$fname = $_POST['FirstName']

		$sql = "select * from details where Email= '$email'";
	//	$sql = " SELECT * FROM details WHERE Email= '$email'";
		$rs = mysqli_query($ccn, $sql);
	//	$rs = mysqli_query($sql,$ccn) or die("query error");


		//$sig = 0;

		//while ($row = mysql_fetch_array($rs)) {
			//	if ($email == $row["Email"])
				//$sig = 1;
		//}
		$sig = mysqli_num_rows($rs);

		if($sig==0){
			$sqll = " insert into details(Email, FirstName, LastName, Mob, password) values ('$email','$fname','$lname','$mno','$pass')";
			//$sqll = "INSERT INTO details (Email, FirstName, LastName, Mob, password) VALUES ('$email', '$fname', '$lname', '$mno', '$pass')";
			//$rs = mysql_query($sqll,$ccn) or die("Insertion error");
			mysqli_query($ccn,$sqll);
			echo "<script type='text/javascript'>alert('Qeydiyyatdan keçdiniz.')</script>";

		}else {
			echo "<script type='text/javascript'>alert('User artıq var.')</script>";

		}

	}


	public function login($email, $pass) {
		$this -> openDB();
		$stmt = $this -> conn -> prepare("SELECT * FROM details WHERE Email=? AND password=?");

		$stmt -> bind_param("ss", $email, $pass);
		if ($stmt -> execute()) {
			$res = $stmt -> get_result();
			$this -> closeDB();
			return $res -> fetch_object();

		} else {
			return FALSE;
		}
	}

	//	public function singupA($email, $fname, $lname, $mno, $pass) {
		// $this -> openDB();
//
		// $stmt = $this -> conn -> prepare("SELECT * FROM admin WHERE Email=?");
//
		// $stmt -> bind_param("s", $email);
		// $stmt -> execute();
		// $sig = 0;
//
		// while ($res = $stmt -> get_result()) {
			// if ($name == $res["Name"])
				// $sig = 1;
//
		// }
//
		// $stmt = $this -> conn -> prepare("INSERT INTO admin(Email, FirstName, LastName, MOb, password)VALUES (?,?,?,?,?)");
//
		// $stmt -> bind_param("sssss", $email, $fname, $lname, $mno, $pass);
//
		// if ($sig == 0) {
			// $stmt -> execute();
			// $res = $stmt -> get_result();
			// $this -> closeDB();
		// } else {
			// echo "<script type='text/javascript'>alert('Already Exist!')</script>";
			// include 'view/home.php';
		// }
//
	// }
//
	// public function loginA($email, $pass) {
		// $this -> openDB();
		// $stmt = $this -> conn -> prepare("SELECT * FROM admin WHERE Email=? AND password=?");
//
		// $stmt -> bind_param("ss", $email, $pass);
		// if ($stmt -> execute()) {
			// $res = $stmt -> get_result();
			// $this -> closeDB();
			// return $res -> fetch_object();
//
		// } else {
			// return FALSE;
		// }
//
	// }

	public function logout() {

		session_start();
		session_destroy();
	}

}
?>
