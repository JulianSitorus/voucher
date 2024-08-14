<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/createvoucher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <title>Voucher</title>
</head>
<body>
    
    <header>
        <div class="user-profile">
            <i class="fa-solid fa-circle-user"></i>
            <div class="name-email">
                <p class="name" style="font-size:17px">Name</p>
                <p class="gmail">voucher@gmail.com</p>
            </div>
        </div>

        <!-- <div class="judul">
            <h3>Dashboard Admin</h3>
        </div> -->

        <div class="history-button">
            <button onclick="location.href='dashboard'"><i class="fa-solid fa-house"></i> Dashboard</button>
        </div>
    </header>

    <div class="sidebar-main">
        <div class="main">            
            <div class="table-box">

            <h1 style="font-size: 22px"><i class="fa-solid fa-square-plus"></i> Create Voucher</h1>
            <div class="separator"></div>
            <!-- <button class="back" onclick="location.href='dashboard'">Back</button> -->

                <form action="create_voucher/store" method="POST" enctype="multipart/form-data">
                @csrf

                    <!-- nama -->
                    <input id="nama" type="text" name="nama" pattern=".*\S+.*" placeholder=" Name" required
                    oninvalid="this.setCustomValidity('Nama voucher belum terisi!')" onInput="this.setCustomValidity('')" title="Silahkan masukkan nama voucher"><br>

                    <!-- kategori -->
                    <select name="kategori" id="kategori" required
                    oninvalid="this.setCustomValidity('Kategori belum terisi!')" 
                    onInput="this.setCustomValidity('')" title="Silahkan pilih kategori">
                        <option value="" disabled selected>Category</option>
                        <option value="Food">Food</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Electronic">Electronic</option> 
                        <option value="Travelling">Travelling</option> 
                    </select><br>

                    <!-- status -->
                    <input id="status" type="text" name="status" pattern=".*\S+.*" placeholder=" Status" required
                    oninvalid="this.setCustomValidity('status voucher belum terisi!')" onInput="this.setCustomValidity('')" title="Silahkan masukkan status voucher"><br>

                    <!-- foto -->
                    <label for="foto">Foto</label>                
                        <input id="foto" type="file" name="foto" accept="image/*"required
                            onchange="checkFileSize(this)">

                    <div id="fotoContainer" style="display:none;"><img src="" id="outputfoto" width="180"></div>  
                        
                    <input class="simpan" type="submit" name="submit" value="Submit">
                    
                    <br>

                </div>    
            
            </form>
            
        </div>

    </div>
    <script>
        function checkFileSize(input) {
            if (input.files.length > 0) {
                var fileSize = input.files[0].size / 1024; // Ukuran dalam KB
                if (fileSize > 1024) { // Maksimal 1 MB (1024 KB)
                    alert('Ukuran file tidak bisa melebihi batas maksimum (1 MB)');
                    input.value = ''; // Reset input file
                    document.getElementById('fotoContainer').style.display = 'none'; // Sembunyikan gambar
                } else {
                    document.getElementById('fotoContainer').style.display = 'block'; // Tampilkan gambar
                    document.getElementById('outputfoto').src = window.URL.createObjectURL(input.files[0]);
                }
            }
        }
    </script>


</body>
</html>