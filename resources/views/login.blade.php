<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
    <div class="container login-container">
        <div class="card login-card">
            <div class="login-card-header">
                <div class="brand-logo">
                    <i class="fas fa-user"></i>
                </div>
                <h3>Đăng nhập vào tài khoản</h3>
                <p class="text-muted">Vui lòng nhập thông tin đăng nhập của bạn</p>
            </div>
            
            <div class="login-card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label">Tên đăng nhập</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control with-icon @error('name') is-invalid @enderror" 
                                id="name" name="name" placeholder="Nhập tên đăng nhập" 
                                value="{{ old('name') }}" required autofocus>
                        </div>
                        @error('name')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control with-icon @error('password') is-invalid @enderror" 
                                id="password" name="password" placeholder="Nhập mật khẩu" required>
                        </div>
                        @error('password')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="login-options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>
                        <div>
                            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                        </button>
                    </div>
                </form>
                
                <div class="login-footer">
                    <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <small>&copy; {{ date('Y') }} HieuNghiaDev. Tất cả các quyền được bảo lưu.</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>