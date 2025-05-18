<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="fixed-top">
        <div class="container-fluid container-xl">
            <div class="top-header py-2">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-lg-2 col-6">
                        <a href="/" class="logo">
                            <img src="https://is1-ssl.mzstatic.com/image/thumb/Purple211/v4/17/7c/c5/177cc56c-f685-158d-917f-af4cfbeed4ac/AppIcon-0-0-1x_U007emarketing-0-11-0-85-220.png/1200x630wa.png" alt="HieuNghiaDev Manga" height="50">
                        </a>
                    </div>
                    
                    <!-- Search -->
                    <div class="col-lg-8 d-none d-lg-block">
                        <div class="search-bar">
                            <form action="#" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm truyện, tác giả..." aria-label="Search">
                                    <button class="btn btn-primary search-btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="col-lg-2 col-6 text-end">
                        <div class="user-menu">
                            <div class="dropdown">
                                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset(Auth::user()->avatar) }}" alt="User Avatar" class="rounded-circle" width="40" height="40">
                                    @else
                                        <img src="https://cdn.vectorstock.com/i/500p/17/16/default-avatar-anime-girl-profile-icon-vector-21171716.jpg" alt="User Avatar" class="rounded-circle" width="40" height="40">
                                    @endif
                                    <span class="d-none d-sm-inline ms-2">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Hồ sơ</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Truyện yêu thích</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2"></i>Lịch sử đọc</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                            @csrf
                                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-lg-none mt-2">
                        <div class="search-bar-mobile">
                            <form action="#" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm truyện, tác giả..." aria-label="Search">
                                    <button class="btn btn-primary search-btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="navbar navbar-expand-lg main-nav">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="/"><i class="fas fa-home me-1"></i>Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tags me-1"></i>Thể loại
                            </a>
                            <ul class="dropdown-menu multi-column" aria-labelledby="navbarDropdown">
                                <div class="row">
                                    <div class="col-sm-4">
                                        @foreach($theLoai as $key => $tl)
                                            @if($key % 3 == 0)
                                                <li><a class="dropdown-item" href="{{ url('the-loai/' . $tl->id) }}">{{ $tl->ten_the_loai }}</a></li>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-sm-4">
                                        @foreach($theLoai as $key => $tl)
                                            @if($key % 3 == 1)
                                                <li><a class="dropdown-item" href="{{ url('the-loai/' . $tl->id) }}">{{ $tl->ten_the_loai }}</a></li>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-sm-4">
                                        @foreach($theLoai as $key => $tl)
                                            @if($key % 3 == 2)
                                                <li><a class="dropdown-item" href="{{ url('the-loai/' . $tl->id) }}">{{ $tl->ten_the_loai }}</a></li>
                                            @endif
                                        @endforeach
                                        <li><a class="dropdown-item" href="{{ url('the-loai') }}">Xem tất cả</a></li>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-chart-line me-1"></i>Bảng xếp hạng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-fire me-1"></i>Truyện Hot</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-calendar-alt me-1"></i>Truyện mới cập nhật</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-book-open me-1"></i>Truyện hoàn thành</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</body>
</html>