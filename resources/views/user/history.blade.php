<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
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
                <p class="name" style="font-size:17px">{{ Auth::user()-> name}}</p>
                <p class="gmail">{{ Auth::user()-> email}}</p>
            </div>
        </div>

        <div class="judul">
            <h3>MegaVoucher</h3>
        </div>

        <div class="history-button">
            <button onclick="location.href='{{ route('user.dashboard') }}'"><i class="fa-solid fa-house"></i> Dashboard</button>
        </div>
    </header>

    <div class="sidebar-main">

        <div class="sidebar">
            <h3>Your Voucher</h3>
                <ul>
                    @foreach ($categories as $category => $count)
                        <li>
                            @switch($category)
                                @case('Food')
                                    <i class="fa-solid fa-bowl-food"></i>
                                    @break
                                @case('Fashion')
                                    <i class="fa-solid fa-shirt"></i>
                                    @break
                                @case('Electronic')
                                    <i class="fa-solid fa-tv"></i>
                                    @break
                                @case('Travelling')
                                    <i class="fa-solid fa-plane"></i>
                                    @break
                                @default
                                    <i class="fa-solid fa-question"></i>
                            @endswitch
                            <div class="category-quantity">
                                <span>{{ $category }}</span>
                                <span>{{ $count }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="separator"></div>
                <ul>
                    <form action="{{ route('user.logout') }}" method="POST" role="search">
                        @csrf
                        @method("DELETE")
                        <button class="logout" type="submit"><i class='bx bx-log-out'></i> <span>Logout</span></button>
                    </form>
                </ul>
        </div>

        <div class="main">
            <h1 style="font-size: 22px"> <i class="fa-solid fa-clock-rotate-left"></i> History</h1>
            <div class="separator"></div>

            <div class="table-box">
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
                        @foreach ($voucher_claims as $vc)
                            <tr>
                                @if ($vc->voucher)
                                    <td>
                                        <img src="{{ asset('foto_voucher/'.$vc->voucher->foto) }}" style="width: 17%; max-height: 60px" alt="">
                                        {{ $vc->voucher->nama ?? 'Voucher' }} 
                                    </td>
                                    <td class="align-middle">
                                        {{ $vc->voucher->kategori ?? 'Kategori' }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $vc->voucher->status ?? 'Status' }}
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('claim.delete', $vc->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                                            
                    </tbody>
                </table>
            </div>            
            
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