<?php
    //akses file koneksi database
    include('koneksi.php');
    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $username = mysqli_real_escape_string($koneksi, $user);
        $password = mysqli_real_escape_string($koneksi, $pass);
        //cek username dan password
        $sql="select `id`, `status` from `user` 
                where `username`='$username' and
               `password`='$password'";
        $query = mysqli_query($koneksi, $sql);
        $jumlah = mysqli_num_rows($query);
        if(empty($user)){
            header("Location:auth-login-basic.php?gagal=userKosong");
        }else if(empty($pass)){
            header("Location:auth-login-basic.php?gagal=passKosong");
        }else if($jumlah==0){
            header("Location:auth-login-basic.php?gagal=userpassSalah");
        }else{
            session_start();
            //get data
            while($data = mysqli_fetch_row($query)){
                $id = $data[0]; //1
                $status = $data[1]; //speradmin
                $_SESSION['id']=$id;
                $_SESSION['status']=$status;
                header("Location:index.php");
            }           
        }
    }
?>
