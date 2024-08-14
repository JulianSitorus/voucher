<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <div class="judul">
            <!-- <img src="{{ asset('foto/logo.png') }}" style="width:200px; height:100px"> -->
            <h3 style="font-weight:200">Megavoucher</h3>
        </div>

        <div class="history-button">
            <button onclick="location.href='{{ Auth::user()-> id}}/history'"> <i class="fa-solid fa-clock-rotate-left"></i> History</button>
        </div>
    </header>

    <div class="sidebar-main">

        <div class="sidebar">
            <h3>Category Voucher</h3>
            <ul>
                <li>
                    <a href="#food" class="smooth-scroll-food" data-count="{{ $voucherCounts['Food'] ?? 0 }}">
                        <i class="fa-solid fa-bowl-food"></i>
                        <div class="category-quantity">
                            <span>Food</span>
                            <span></span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#fashion" class="smooth-scroll" data-count="{{ $voucherCounts['Fashion'] ?? 0 }}">
                        <i class="fa-solid fa-shirt"></i>
                        <div class="category-quantity">
                            <span>Fashion</span>
                            <span></span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#electronic" class="smooth-scroll" data-count="{{ $voucherCounts['Electronic'] ?? 0 }}">
                        <i class="fa-solid fa-tv"></i>
                        <div class="category-quantity">
                            <span>Electronic</span>
                            <span></span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#travelling" data-count="{{ $voucherCounts['Travelling'] ?? 0 }}">
                        <i class="fa-solid fa-plane"></i>
                        <div class="category-quantity">
                            <span>Travelling</span>
                            <span></span>
                        </div>
                    </a>
                </li>
            </ul>
                <div class="separator"></div>
                <ul>
                    <form action="{{ route('user.logout') }}" method="POST" role="search">
                        @csrf
                        @method("DELETE")
                        <button  type="submit"><i class='bx bx-log-out'></i> <span>Logout</span></button>
                    </form>
                </ul>
        </div>

        <div class="main">
            <h1 id="food" style="font-size: 22px; margin-bottom: 15px;"><i class="fa-solid fa-ticket gradient-icon"></i> All Vouchers</h1>
            <div class="separator"></div>

            @foreach ($sortedVouchersByCategory  as $kategori => $vouchers)
                <div class="category-box">
                    <h1 id="{{ strtolower($kategori) }}" style="font-size: 22px">
                        @if ($kategori == 'Fashion')
                            <i class="fa-solid fa-shirt"></i>
                        @elseif ($kategori == 'Travelling')
                            <i class="fa-solid fa-plane"></i>
                        @elseif ($kategori == 'Food')
                            <i class="fa-solid fa-bowl-food"></i>
                        @elseif ($kategori == 'Electronic')
                            <i class="fa-solid fa-tv"></i>
                        @else
                            <i class="fa-solid fa-tag"></i>
                        @endif
                        {{ $kategori }} Vouchers
                    </h1>
                    <div class="vouchers">
                        @foreach ($vouchers as $voucher)
                            <div class="voucher-box" style="{{ $voucher->is_claimed ? 'opacity: 0.5; background-color: #f0f0f0; cursor: not-allowed' : '' }}">
                                <img src="{{ asset('foto_voucher/'.$voucher->foto) }}" alt="">
                                <p class="nama-voucher">{{ $voucher->nama }}</p>
                                <div class="store-claim">
                                    <p class="status-voucher">{{ $voucher->status }}</p>

                                    <!-- <button>Claim Now</button> -->
                                    @if (!$voucher->is_claimed)
                                        <form action="{{ route('claim.voucher') }}" method="POST" id="claim-form-{{ $voucher->id }}">
                                            @csrf
                                            <input type="hidden" name="id_voucher" value="{{ $voucher->id }}">
                                            <button type="submit">Claim Now</button>
                                        </form>
                                    @endif
                                    <!--  -->

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
    </div>

    <!-- --------------------------------------- claim voucher ----------------------------------------- -->

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


    <!-- --------------------------------------- smooth scroll ----------------------------------------- -->
    <script>
    document.querySelectorAll('.smooth-scroll').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            const offsetPosition = targetElement.offsetTop - 95; // Adjust the offset as needed

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        });
    });
    </script>

    <script>
    document.querySelectorAll('.smooth-scroll-food').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            const offsetPosition = targetElement.offsetTop - 15; // Adjust the offset as needed

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        });
    });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[data-count]');
            links.forEach(link => {
                const count = link.getAttribute('data-count');
                const span = link.querySelector('.category-quantity span:last-child');
                span.textContent = count;
            });
        });
    </script>


</body>
</html>