<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm: {{ $keyword }} - 3N online</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include('layouts.header')

    <!-- Main Content -->
    <main class="main-content py-5">
        <div class="container-fluid container-xl">
            <div class="section-title mb-4">
                <h2>
                    <i class="fas fa-search text-primary me-2"></i>
                    Kết quả tìm kiếm: "{{ $keyword }}"
                </h2>
                <div>Tìm thấy {{ $ketQuaTimKiem->total() }} truyện</div>
            </div>

            @if($ketQuaTimKiem->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Không tìm thấy truyện nào phù hợp với từ khóa "{{ $keyword }}".
                    
                </div>
            @else
                <div class="row">
                    @foreach($ketQuaTimKiem as $truyen)
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
                    {{ $ketQuaTimKiem->appends(['keyword' => $keyword])->links() }}
                </div>
            @endif
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