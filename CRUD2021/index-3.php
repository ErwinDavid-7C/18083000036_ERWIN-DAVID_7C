<?php
session_start();
// Jika tidak bisa login maka balik ke login.php
// jika masuk ke halaman ini melalui url, maka langsung menuju halaman login
if (!isset($_SESSION['login'])) {
    header('location:login-3.php');
    exit;
}
    //Koneksi Database
    $server ="localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //Jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //Pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //Data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE tmhs set
                                                nim = '$_POST[tnim]',
                                                nama = '$_POST[tnama]',
                                                alamat = '$_POST[talamat]',
                                                prodi = '$_POST[tprodi]'
                                             WHERE id_mhs = '$_GET[id]' 
                                           ");
            if($edit) //Jika edit sukses
            {
                echo "<script>
                        alert('Edit data sukses!');
                        document.location='index-3.php';
                    </script>";
            }
            else 
            {
                echo "<script>
                        alert('Edit data GAGAl!');
                        document.location='index-3.php';
                    </script>";   
            }
        }
        else
        {
            //Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
                                         VALUES ('$_POST[tnim]', 
                                                '$_POST[tnama]', 
                                                '$_POST[talamat]', 
                                                '$_POST[tprodi]')
                                        ");
            if($simpan)
            {
                echo "<script>
                        alert('Simpan data sukses!');
                        document.location='index-3.php';
                    </script>";
            }
            else 
            {
                echo "<script>
                        alert('Simpan data GAGAl!');
                        document.location='index-3.php';
                    </script>";   
            }
        }


        
    }


    //Pengujian jika tombol Edit/Hapus diklik
    if(isset($_GET['hal']))
    {
        //Pengujian edit data
        if($_GET['hal'] == "edit")
        {
            //Tampilkan data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //Jika data ditemukan, maka data ditampung ke dalam variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //Persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus data sukses!');
                        document.location='index-3.php';
                    </script>"; 
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD 2021 PHP & MySQL + Booststarp</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
        <div class="container">
            <a class="navbar-brand" href="index-2.php">ERWIN DAVID | CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="logout-3.php">Log out</a>
                    </li>
                   
                   
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->
   

<div class="container">
    
    <h1 class="text-center">DATA MAHASISWA FTI UNMER MALANG</h1>
    <h2 class="text-center">(UTS CRUD)</h2>

    <!-- AWal Card Form -->
     
    <div class="card mt-5">
    <div class="card-header bg-primary text-white">
        
    
   <!-- Navbar -->

   <nav class="navbar sticky-top navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand"></a>
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</nav>

    <!-- Close Navbar -->
   <div class="card mt-3">
    <div class="card-header bg-success text-white">
        DAFTAR MAHASISWA
    </div>
    <div class="card-body">
      
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Program Studi</th>
            
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                while($data = mysqli_fetch_array($tampil)) :

            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nim']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['alamat']?></td>
                <td><?=$data['prodi']?></td>
            
            </tr>
            <?php endwhile; //penutup perulangan while ?>
        </table>

    </div>
    </div>
    <!-- Akhir Card Table -->

</div>

<script type="text/javascript" src="css/bootstrap.min.js"></script>
</body>
</html>