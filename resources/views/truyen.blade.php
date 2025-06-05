<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $truyen->ten_truyen }} - Chi tiết truyện</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/truyen.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
</head>
<body>
    @include('layouts.header')

    <!-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show container-fluid container-xl mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif -->

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
                            
                            <!-- Thông tin truyện -->
                            <div class="col-md-8">
                                <h1 class="detail-title">{{ $truyen->ten_truyen }}</h1>
                                
                                <div class="info-item"><strong>Tác giả:</strong> {{ $truyen->tac_gia }}</div>
                                <div class="info-item"><strong>Trạng thái:</strong> 
                                    @if($truyen->tinh_trang == 1)
                                        <span class="badge bg-success">Đã hoàn thành</span>
                                    @else
                                        <span class="badge bg-danger">Đang cập nhật</span>
                                    @endif
                                </div>
                                <div class="info-item"><strong>Ngày đăng tải:</strong> {{ $truyen->ngay_dang }}</div>
                                <div class="info-item"><strong>Cập nhật:</strong> {{ $truyen->ngay_update }}</div>
                                <div class="info-item">
                                    <strong>Thể loại:</strong> 
                                    @foreach($truyen->theLoai as $theLoai)
                                        <a href="{{ route('the-loai.show', $theLoai->id) }}" class="badge bg-primary">{{ $theLoai->ten_the_loai }}</a>
                                    @endforeach
                                </div>

                                <div class="info-item">
                                    <div class="col-md-6">
                                        <div class="rating-card">
                                            <strong>Đánh Giá: {{ number_format($truyen->rating, 1, '.', '') }}/5</strong>
                                            <span class="small text-muted">({{ $truyen->ratings()->count() }} đánh giá)</span>
                                            
                                            @auth
                                                @php
                                                    $userRating = $truyen->getUserRating(Auth::id());
                                                @endphp
                                                
                                                <form action="{{ route('rating.store', $truyen->id) }}" method="POST">
                                                    @csrf
                                                    <div class="star-rating animated-stars">
                                                        <input type="radio" id="star5" name="rating" value="5" {{ $userRating && $userRating->rating == 5 ? 'checked' : '' }} onchange="this.form.submit()">
                                                        <label for="star5" class="bi bi-star-fill"></label>
                                                        <input type="radio" id="star4" name="rating" value="4" {{ $userRating && $userRating->rating == 4 ? 'checked' : '' }} onchange="this.form.submit()">
                                                        <label for="star4" class="bi bi-star-fill"></label>
                                                        <input type="radio" id="star3" name="rating" value="3" {{ $userRating && $userRating->rating == 3 ? 'checked' : '' }} onchange="this.form.submit()">
                                                        <label for="star3" class="bi bi-star-fill"></label>
                                                        <input type="radio" id="star2" name="rating" value="2" {{ $userRating && $userRating->rating == 2 ? 'checked' : '' }} onchange="this.form.submit()">
                                                        <label for="star2" class="bi bi-star-fill"></label>
                                                        <input type="radio" id="star1" name="rating" value="1" {{ $userRating && $userRating->rating == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                                                        <label for="star1" class="bi bi-star-fill"></label>
                                                    </div>
                                                    @if($userRating)
                                                        <small class="d-block text-muted mt-1">Đánh giá của bạn: {{ $userRating->rating }}/5</small>
                                                    @endif
                                                </form>
                                            @else
                                                <div class="star-rating animated-stars readonly">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" id="star{{ $i }}" disabled {{ round($truyen->rating) == $i ? 'checked' : '' }}>
                                                        <label for="star{{ $i }}" class="bi bi-star-fill"></label>
                                                    @endfor
                                                </div>
                                                <small class="d-block text-muted mt-1"><a href="{{ route('login') }}">Đăng nhập</a> để đánh giá</small>
                                            @endauth
                                        </div>
                                    </div>
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
    <script>
        document.querySelectorAll('.star-rating:not(.readonly) label').forEach(star => {
            star.addEventListener('click', function() {
                this.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            });
        });
    </script>
</body>
</html>