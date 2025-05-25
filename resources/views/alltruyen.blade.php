<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả truyện - HieuNghiaDev Manga</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include('layouts.header')

    <!-- Main Content -->
    <main class="main-content py-5">
        <div class="container-fluid container-xl">
            <div class="section-title mb-4">
                <h2>
                    <i class="fas fa-book text-primary me-2"></i>
                    Tất cả truyện
                </h2>
            </div>

            <div class="row">
                @foreach($allTruyen as $truyen)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                        <div class="manga-card">
                            <div class="manga-card-img">
                                @if($truyen->luot_xem > 1000)
                                    <span class="manga-status">Hot</span>
                                @endif
                                @if($truyen->ngay_update > now()->subDays(7))
                                    <span class="manga-status new">Mới</span>
                                @endif
                                <a href="{{ route('truyen.show', $truyen->id) }}">
                                    <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}" class="img-fluid">
                                </a>
                                <div class="manga-card-actions">
                                    <a href="{{ route('truyen.show', $truyen->id) }}" class="btn-read"><i class="fas fa-book-open"></i> Đọc ngay</a>
                                </div>
                            </div>
                            <div class="manga-card-body">
                                <h5 class="manga-title"><a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a></h5>
                                <div class="manga-info">
                                    <span><i class="fas fa-eye"></i> 
                                        @if($truyen->luot_xem >= 1000)
                                            {{ number_format($truyen->luot_xem / 1000, 1) }}k
                                        @else
                                            {{ $truyen->luot_xem ?? 0 }}
                                        @endif
                                    </span>
                                    <span>
                                        <i class="fas fa-book"></i> 
                                        {{ $truyen->chapters_count ?? 0 }} chương
                                    </span>
                                </div>
                                <div class="manga-genres small">
                                    @foreach($truyen->theLoai as $theLoai)
                                        <span class="badge bg-primary">{{ $theLoai->ten_the_loai }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $allTruyen->links() }}
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <!-- Back to Top Button -->
    <a href="#" id="return-to-top" class="return-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>