<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>
<body>
    <div class="container register-container">
        <div class="card register-card">
            <div class="register-card-header">
                <div class="brand-logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3>Đăng ký tài khoản mới</h3>
                <p class="text-muted">Vui lòng điền thông tin để tạo tài khoản</p>
            </div>
            
            <div class="register-card-body">
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    
                    <div class="mb-3">
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
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control with-icon @error('email') is-invalid @enderror" 
                                id="email" name="email" placeholder="Nhập địa chỉ email" 
                                value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
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
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control with-icon" 
                                id="password_confirmation" name="password_confirmation" 
                                placeholder="Nhập lại mật khẩu" required>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-register">
                            <i class="fas fa-user-plus me-2"></i> Đăng ký
                        </button>
                    </div>
                </form>
                
                <div class="register-footer">
                    <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
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