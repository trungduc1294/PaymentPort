# 1. Layout
- có giao diện admin, quản lý: 
  - danh sách user 
  - danh sách role
  - danh sách bài post
  - danh sách order
  - danh sách presenter
  - import

- giao diện người dùng:
  - chọn vai trò
    - trường hợp là nguười nghe
        - hiển thị nhập email
        - nhập student ....
        - tính tiền
        - thanh toán
        - kết quả thanh toán
        - khi nhấn nút checkout thì gọi server
          - server tạo 1 record order trong bảng order
          - gửi mail xác minh
          - user sẽ click link thanh toán trong mail để xác minh thaành toaán -> cập nhật status order thành paid
          - 
    - trường hơp là người thuyết triình
      - giao diện tìm kiếm
      - danh sách bài báo của tác giả theo tìm kiếm
      - form thanh toán
        - vai trò student/. member , ...
        - số trang vượt quá
      - Tính tiền
      - thanh toán
      - kết quả thanh toán


# 2.Tạo database
    - tạo migration, model
    - connect DB

# 3. Tạo route, controller
    - logic xử lý data, đăng ký thuet trinh, nghe, .... 
    - tính tiền
    - thanh toán
    - Hủy thanh toán
    - Gửi mail xác minh
    
# 4. Các vấn đề còn lại
    - Chưa xử lý không hiện các bài post sau khi thanh toán xong, chờ lấy trạng thái từ cổng thành toán là thành công để chuyển status của post thành unactive, khi đó sẽ không hiêện nữa
    - Chưa tạo bảng transaction để lưu trạng thái thanh toán, liên kết tới orderid, từ đó sửa các logic cần thiết phải thay đổi
    - chưa tạo loading khi gửi mail
    - chưa liên kết với cổng thanh toán
    - chưa deploy
