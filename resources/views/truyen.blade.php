<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $truyen->ten_truyen }} - Chi tiết truyện</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/truyen.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
</head>
<body>
    @include('layouts.header')

    <!-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif -->

    <!-- Main Content -->
    <main class="main-content py-5">
        <div class="container-fluid container-xl">
            <div class="row">
                <!-- Left Section: Chi tiết truyện -->
                <div class="col-lg-9 mb-4">
                    <div class="detail-card">
                        <div class="row">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}" class="img-fluid rounded shadow">
                                
                                <div class="d-block d-md-none mt-3">
                                    <div class="read-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-eye"></i>
                                            @if(isset($truyen->luot_xem) && $truyen->luot_xem >= 1000)
                                                {{ number_format($truyen->luot_xem / 1000, 1) }}k
                                            @else
                                                {{ $truyen->luot_xem ?? 0 }}
                                            @endif
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-book"></i>
                                            {{ $truyen->chapters->count() }} chương
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Truyện Info -->
                            <div class="col-md-8">
                                <h1 class="detail-title">{{ $truyen->ten_truyen }}</h1>
                                
                                <div class="info-item"><strong>Ngày đăng tải:</strong> {{ $truyen->ngay_dang }}</div>
                                <div class="info-item"><strong>Cập nhật:</strong> {{ $truyen->ngay_update }}</div>
                                <div class="info-item">
                                    <strong>Thể loại:</strong> 
                                    @foreach($truyen->theLoai as $theLoai)
                                        <a href="{{ route('the-loai.show', $theLoai->id) }}" class="badge bg-primary">{{ $theLoai->ten_the_loai }}</a>
                                    @endforeach
                                </div>
                                
                                <div class="d-none d-md-block">
                                    <div class="read-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-eye"></i>
                                            @if($truyen->luot_xem >= 1000)
                                                {{ number_format($truyen->luot_xem / 1000, 1) }}k
                                            @else
                                                {{ $truyen->luot_xem }}
                                            @endif
                                            lượt xem
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-book"></i>
                                            {{ $truyen->chapters->count() }} chương
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="mt-3">{{ $truyen->mo_ta }}</p>
                                
                                <!-- Action Buttons -->
                                <div class="action-buttons mt-4 d-flex flex-wrap gap-2">
                                    <a href="{{ route('truyen.chapter', $truyen->id) }}" class="btn btn-primary action-btn">
                                        <i class="fas fa-book-open me-1"></i> Đọc từ đầu
                                    </a>
                                    
                                    @if($truyen->chapters->isNotEmpty())
                                        <a href="{{ route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $truyen->chapters()->orderBy('so_chap', 'desc')->first()->id]) }}" 
                                           class="btn btn-success action-btn">
                                            <i class="fas fa-bolt me-1"></i> Chap mới nhất
                                        </a>
                                    @endif
                                    
                                    @auth
                                        @php
                                            $dangTheoDoi = \App\Models\TheoDoi::where('user_id', Auth::id())
                                                ->where('truyen_id', $truyen->id)
                                                ->exists();
                                        @endphp

                                        <form action="{{ route('theo-doi.toggle', $truyen->id) }}" method="POST">
                                            @csrf
                                            @if($dangTheoDoi)
                                                <button type="submit" class="btn btn-info action-btn">
                                                    <i class="fas fa-bell me-1"></i> Đang theo dõi
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-outline-info action-btn">
                                                    <i class="far fa-bell me-1"></i> Theo dõi
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-info action-btn">
                                            <i class="far fa-bell me-1"></i> Đăng nhập để theo dõi
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách chương -->
                    @if($truyen->chapters->isNotEmpty())
                        <div class="chapter-list mt-4">
                            <h2>
                                <i class="fas fa-list-ul me-2"></i>
                                Danh sách chương ({{ $truyen->chapters->count() }} chương)
                            </h2>
                            
                            <div class="chapter-grid">
                                @foreach($truyen->chapters->sortByDesc('so_chap') as $chapter)
                                    <div class="chapter-item">
                                        <a href="{{ route('chapter.show', ['truyen' => $truyen->id, 'chapter' => $chapter->id]) }}">
                                            {{ $chapter->ten_chap }}
                                            <small class="d-block text-muted mt-1">{{ \Carbon\Carbon::parse($chapter->ngay_dang)->format('d/m/Y') }}</small>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Truyện chưa có chapter nào.
                        </div>
                    @endif
                </div>
                
                <!-- Right Section: Truyện cùng thể loại -->
                <div class="col-lg-3">
                    <div class="related-stories">
                        <h3><i class="fas fa-book me-2"></i>Truyện cùng thể loại</h3>
                        <ul class="list-unstyled">
                            @foreach($relatedStories as $related)
                                <li class="mb-3">
                                    <a href="{{ route('truyen.show', $related->id) }}" class="d-flex align-items-center">
                                        <img src="{{ asset('assets/img/cover_img/' . $related->anh_bia) }}" alt="{{ $related->ten_truyen }}" class="img-fluid rounded me-3" style="width: 60px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-1">{{ $related->ten_truyen }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-eye me-1"></i>
                                                @if(isset($related->luot_xem) && $related->luot_xem >= 1000)
                                                    {{ number_format($related->luot_xem / 1000, 1) }}k
                                                @else
                                                    {{ $related->luot_xem ?? 0 }}
                                                @endif
                                            </small>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>