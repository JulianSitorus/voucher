<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
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
        <a href="/profile" style="text-decoration: none; color: inherit;">
            <div class="user-profile" style="cursor: pointer;">
                <i class="fa-solid fa-circle-user"></i>
                <div class="name-email">
                    <p class="name" style="font-size:17px">{{ Auth::user()->name }}</p>
                    <p class="gmail">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </a>

        <!-- <div class="history-button">
            <button onclick="location.href='voucher_food'"><i class="fa-solid fa-house"></i> Menu</button>
        </div> -->
    </header>

    <div class="sidebar-main">
        <div class="main">
            <h1 style="font-size: 22px"> <i class="fa-solid fa-user-gear"></i> Dashboard Admin</h1>
            <div class="separator"></div>

            <div class="table-box">

                <div class="list-create">
                    <div class="list-voucher">
                        <h3>List Voucher</h3>
                    </div>
                    <div class="create-button">
                        <button onclick="location.href='create_voucher'"><i class="fa-solid fa-plus"></i> Add Voucher</button>
                    </div>
                </div>

                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Voucher Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voucher as $vr)
                            <tr>
                                <td class="foto">
                                    <img src="{{ asset('foto_voucher/'.$vr->foto) }}" style="width: 17%; max-height: 60px" alt="">
                                    {{ $vr->nama }}
                                </td>
                                <td class="align-middle">{{ $vr->kategori }}</td>
                                <td class="align-middle">{{ $vr->status }}</td>
                                <td class="align-middle">
                                    <div class="button-container">
                                        <button class="edit" onclick="location.href='edit_voucher/{{$vr->id}}'">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                        
                                        <form action="{{ route('voucher.delete', ['id' => $vr->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="delete">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>   
                        @endforeach
                    </tbody>
                </table>
            </div>            
            
        </div>

        <div class="sidebar">
            <h3>Category Voucher</h3>
                <ul>
                    @foreach ($kategoriData as $category => $count)
                        <li>
                            @if ($category == 'Food')
                                <i class="fa-solid fa-bowl-food"></i>
                            @elseif ($category == 'Travelling')
                                <i class="fa-solid fa-plane"></i>
                            @elseif ($category == 'Fashion')
                                <i class="fa-solid fa-shirt"></i>
                            @elseif ($category == 'Electronic')
                                <i class="fa-solid fa-tv"></i>
                            @else
                                <i class="fa-solid fa-tag"></i>
                            @endif
                            <div class="category-quantity">
                                <span>{{ $category }}</span>
                                <span>{{ $count }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="separator"></div>
                <ul>
                    <form action="{{ route('admin.logout') }}" method="POST" role="search">
                        @csrf
                        <button class="logout" type="submit"><i class='bx bx-log-out'></i> <span>Logout</span></button>
                    </form>
                </ul>
        </div>
    </div>

     <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#example');
    </script>

    <!-- alert sukses nambah -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if (Session::has('success'))
        <script>
            swal("Success","{{ Session::get('success') }}", 'success',{
                button:true,
                button:"OK",
                timer:2500,
            });
        </script>
    @endif

    <!-- alert sukses edit -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if (Session::has('success'))
        <script>
            swal("Success","{{ Session::get('success') }}", 'success',{
                button:true,
                button:"OK",
                timer:2500,
            });
        </script>
    @endif

     <!-- alert logout -->
     <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $(document).on('click', '.logout', function(e){
                e.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: "You want to logout?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Logout"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/logout';
                    }
                });
            });
        });
    </script> -->

    <!-- alert hapus -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to restore this data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Delete"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

</body>
</html>