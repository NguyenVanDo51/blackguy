## Giới thiệu
Trang web học các khóa học online, sử dụng phân quyền để cho phép truy cập trang quan trị với vai trò admin. 
Admin có thể thêm sửa xóa khóa học, bài học, các tag, danh mục. Crawl dữ liệu.

## Tính năng
- Có thể lựa chọn các danh mục để hiển thị lên trang chủ (ví dụ: web, mobile, ...)
- Có thể Crawl toàn bộ các khóa học tại trang https://coderstape.com/ sử dụng queue
- Tính % hoàn thành khóa học, phát tiếp tục bài học, thời gian của video từ lần xem trước

## Cài đặt
Chạy các lệnh sau để cài đặt project:<br>

```
# Cài đặt các pakage 
composer install

# Tạo key cho ứng dụng
php artisan key:generate

# Copy file .env, sau đó sửa thông tin database trong file .env
cp .env.example .env

# Tạo bảng cho queues
php artisan queue:table

# Tạo các bảng cho database
php artisan migrate

# Chạy lệnh queue:work khi sử dụng chức năng crawl
php artisan queue:work

```
