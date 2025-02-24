# Hướng Dẫn Chạy Dự Án Laravel

## 1. Yêu Cầu Hệ Thống
Trước khi chạy dự án Laravel, cần đảm bảo bạn đã cài đặt các công cụ sau:
- **PHP** (phiên bản phù hợp với Laravel, khuyến nghị từ PHP 8.0 trở lên)
- **Composer** (trình quản lý gói PHP)
- **SQLite** (do dự án sử dụng SQLite làm database)
- **Node.js & NPM** (nếu sử dụng frontend với Laravel Mix hoặc Vite)
- **Redis** (nếu được sử dụng trong dự án)

## 2. Clone Hoặc Tải Mã Nguồn
Nếu dự án có sẵn trên GitHub/GitLab, bạn có thể clone về bằng lệnh:

```bash
git clone https://github.com/your-repo/project.git
cd project
```

## 3. Cài Đặt Các Gói Phụ Thuộc
Chạy lệnh sau để cài đặt thư viện PHP:

```bash
composer install
```

Nếu dự án có frontend, chạy tiếp:

```bash
npm install
```

## 4. Cấu Hình File .env
Sao chép file `.env.example` thành `.env`:

```bash
cp .env.example .env
```

Dự án sử dụng SQLite, cần tạo file database:

```bash
touch database/database.sqlite
```

Cập nhật `.env`:

```ini
DB_CONNECTION=sqlite
```

## 5. Tạo Key Cho Ứng Dụng

```bash
php artisan key:generate
```

## 6. Chạy Migration Và Seed Database (nếu có)
Nếu dự án sử dụng database, chạy:

```bash
php artisan migrate --seed
```

Nếu session, cache hoặc queue sử dụng database, chạy thêm:

```bash
php artisan session:table
php artisan cache:table
php artisan queue:table
php artisan migrate
```

## 7. Khởi Động Server Laravel
Chạy lệnh:

```bash
php artisan serve
```

Laravel sẽ chạy trên `http://localhost/`.

## 8. Chạy Frontend (Nếu Có)
Nếu dự án sử dụng Laravel Mix hoặc Vite:

```bash
npm run dev
```

Nếu build frontend cho production:

```bash
npm run build
```

## 9. Cấu Hình Mail (Nếu Cần)
Dự án hiện tại sử dụng log để lưu email:

```ini
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Laravel"
```

Nếu cần gửi email thực, hãy chỉnh lại `.env` để sử dụng SMTP.

## 10. Redis (Nếu Cấu Hình Cache, Queue)
Nếu dự án sử dụng Redis, hãy chắc chắn Redis đang chạy và `.env` có thông số:

```ini
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

## 11. Xử Lý Các Vấn Đề Thường Gặp
- **Không chạy được migration** → Kiểm tra database SQLite đã được tạo chưa.
- **Không gửi được email** → Kiểm tra cấu hình mail trong `.env`.
- **CSS/JS không hiển thị** → Chạy `npm run dev` hoặc `php artisan storage:link` nếu dùng storage.

## 12. Hoàn Thành 🎉
Giờ bạn có thể truy cập `http://localhost/` và bắt đầu sử dụng Laravel!

