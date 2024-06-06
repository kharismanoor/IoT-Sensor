<?php
    session_start();
    include "koneksi.php";
    //dapatkan data user dari form register
    $user = [
    	
    	'username' => $_POST['username'],
    	'password' => $_POST['password'],
    	'status' => $_POST['status'],
    ];
  
    //check apakah user dengan username tersebut ada di table users
    $query = "select * from user where username = ? limit 1";
    $stmt = $koneksi->stmt_init();
    $stmt ->prepare($query);
    $stmt->bind_param('s', $user['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    //jika username sudah ada, maka return kembali ke halaman register.
    if($row != null){
    	$_SESSION['error'] = 'Username: '.$user['username'].' yang anda masukkan sudah ada di database.';
    	$_SESSION['password'] = $_POST['password'];
    	$_SESSION['password_confirmation'] = $_POST['password_confirmation'];
    	header("Location: /auth-register-basic.php");
    	return;
    }else{
    	//hash password
    	$password = password_hash($user['password'],PASSWORD_DEFAULT);
    	//username unik. simpan di database.
    	$query = "insert into user (username, password,status) values  (?,?,?)";
    	$stmt = $koneksi->stmt_init();
    	$stmt->prepare($query);
    	$stmt->bind_param('sss', $user['username'],$user['password'], $user['status']);
    	$stmt->execute();
    	$result = $stmt->get_result();
    	var_dump($result);
    	$_SESSION['message']  = 'Berhasil register ke dalam sistem. Silakan login dengan username dan password yang sudah dibuat.';
    	header("Location: login.php");
    }
    ?>