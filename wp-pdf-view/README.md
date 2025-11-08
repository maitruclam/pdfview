# MTL PDF View Gallery

**Version:** 1.3.0  
**Author:** [maitruclam.com](https://maitruclam.com)  
**License:** GPL v2 or later

---

## 🇻🇳 Tiếng Việt

### Mô tả

MTL PDF View Gallery là một plugin WordPress mạnh mẽ giúp bạn hiển thị và quản lý thư viện tài liệu PDF một cách chuyên nghiệp. Plugin cung cấp giao diện người dùng đẹp mắt với bộ lọc thư mục linh hoạt và trình xem PDF popup tích hợp.

### ✨ Tính năng chính

- 📁 **Quản lý thư mục phân cấp** - Hỗ trợ thư mục chính và thư mục con
- 🎨 **Giao diện hiện đại** - Thiết kế responsive, đẹp mắt trên mọi thiết bị
- 🔍 **Bộ lọc mạnh mẽ** - Lọc tài liệu theo thư mục chính và thư mục con
- 👁️ **Trình xem PDF tích hợp** - Xem PDF trực tiếp trên trang web không cần tải xuống
- ⬇️ **Tải xuống dễ dàng** - Nút tải xuống cho mỗi tài liệu
- 🖼️ **Hỗ trợ ảnh cover** - Tự động hiển thị ảnh bìa cho mỗi PDF
- ⚙️ **Tùy chỉnh linh hoạt** - Cấu hình số cột hiển thị cho mobile, tablet, desktop
- 🏷️ **Đổi tên thư mục** - Tùy chỉnh tên hiển thị cho các thư mục
- 📱 **Responsive 100%** - Hoạt động mượt mà trên mọi kích thước màn hình

### 📋 Yêu cầu hệ thống

- WordPress 5.0 trở lên
- PHP 7.0 trở lên
- jQuery (tự động được bao gồm trong WordPress)

### 🚀 Cài đặt

1. **Tải plugin**
   - Tải thư mục plugin vào `/wp-content/plugins/wp-pdf-view/`
   - Hoặc tải file zip và cài đặt qua WordPress Admin

2. **Kích hoạt plugin**
   - Vào `Plugins` trong WordPress Admin
   - Tìm `MTL PDF View Gallery` và click `Activate`

3. **Chuẩn bị thư mục PDF**
   - Tải các file PDF lên thư mục `wp-content/uploads/` của bạn
   - Cấu trúc thư mục nên như sau:
     ```
     wp-content/uploads/2025/10/so hoa TTHC/
     ├── Thư mục chính 1/
     │   ├── Thư mục con A/
     │   │   ├── file1.pdf
     │   │   ├── file1.jpg (ảnh cover - tùy chọn)
     │   │   └── file2.pdf
     │   └── file3.pdf
     ├── Thư mục chính 2/
     │   └── file4.pdf
     ```

4. **Thêm shortcode vào trang**
   - Tạo hoặc chỉnh sửa trang/bài viết
   - Thêm shortcode: `[pdf_view]`

### ⚙️ Cấu hình

Vào `MTL PDF View` trong menu WordPress Admin để cấu hình:

#### 1. **Cấu hình đường dẫn**
- Đặt đường dẫn tương đối đến thư mục chứa PDF (tính từ thư mục uploads)
- Ví dụ: `2025/10/so hoa TTHC`

#### 2. **Cấu hình hiển thị Grid**
- **Mobile**: Số cột hiển thị trên màn hình < 768px (khuyến nghị: 1-2)
- **Tablet**: Số cột hiển thị trên màn hình 768px-1024px (khuyến nghị: 2-3)
- **Desktop**: Số cột hiển thị trên màn hình > 1024px (khuyến nghị: 3-4)

#### 3. **Tùy chỉnh tên thư mục**
- Đổi tên hiển thị cho các thư mục (giữ nguyên tên thư mục gốc trên server)
- Thiết lập tên tiếng Việt hoặc mô tả dễ hiểu hơn

#### 4. **Tùy chỉnh nhãn**
- Thay đổi nhãn hiển thị cho bộ lọc
- Mặc định: "Thư mục chính", "Thư mục con"

### 📖 Sử dụng

#### Shortcode cơ bản:
```
[pdf_view]
```

#### Cách thêm ảnh cover cho PDF:
Plugin tự động tìm kiếm ảnh cover theo các tên sau (cùng thư mục với file PDF):
- `tenfile-pdf.jpg` hoặc `tenfile-pdf.png`
- `tenfile.jpg` hoặc `tenfile.png`

Ví dụ: Nếu file PDF tên là `bao-cao-2024.pdf`, plugin sẽ tìm:
1. `bao-cao-2024-pdf.jpg`
2. `bao-cao-2024-pdf.png`
3. `bao-cao-2024.jpg`
4. `bao-cao-2024.png`

### 🎨 Tính năng giao diện

- **Card layout hiện đại** - Mỗi PDF được hiển thị dưới dạng card với thumbnail
- **Hover effects** - Hiệu ứng khi di chuột qua card
- **Modal popup** - Xem PDF trong modal popup toàn màn hình
- **Smooth animations** - Các hiệu ứng chuyển động mượt mà
- **Loading states** - Hiển thị trạng thái loading khi tải dữ liệu

### ❓ Câu hỏi thường gặp (FAQ)

**Q: Plugin có hỗ trợ file khác ngoài PDF không?**  
A: Hiện tại plugin chỉ hỗ trợ file PDF (.pdf)

**Q: Tôi có thể thay đổi màu sắc của giao diện không?**  
A: Có, bạn có thể chỉnh sửa file `assets/style.css` để tùy chỉnh màu sắc và style

**Q: Plugin có ảnh hưởng đến tốc độ trang web không?**  
A: Plugin được tối ưu hóa, chỉ load assets khi cần thiết và sử dụng AJAX để tải file

**Q: Làm sao để PDF được sắp xếp theo thứ tự?**  
A: Các file được hiển thị theo thứ tự alphabet của tên file

**Q: Tôi có thể giới hạn số lượng PDF hiển thị không?**  
A: Hiện tại plugin hiển thị tất cả PDF trong thư mục được chọn

### 🔄 Changelog

**Version 1.3.0**
- Cải thiện UI/UX
- Thêm tùy chỉnh số cột grid cho responsive
- Thêm tính năng đổi tên thư mục
- Tối ưu hóa hiệu suất
- Fix bugs nhỏ

**Version 1.2.0**
- Thêm hỗ trợ thư mục con
- Cải thiện trình xem PDF
- Thêm nút reset filters

**Version 1.1.0**
- Thêm ảnh cover cho PDF
- Cải thiện responsive
- Thêm trang admin settings

**Version 1.0.0**
- Phiên bản đầu tiên phát hành

### 📞 Hỗ trợ

Nếu bạn cần hỗ trợ, vui lòng liên hệ:
- Website: [maitruclam.com](https://maitruclam.com)

---

## 🇬🇧 English

### Description

MTL PDF View Gallery is a powerful WordPress plugin that helps you display and manage PDF document galleries professionally. The plugin provides a beautiful user interface with flexible folder filters and integrated popup PDF viewer.

### ✨ Key Features

- 📁 **Hierarchical Folder Management** - Support for main folders and subfolders
- 🎨 **Modern Interface** - Responsive design, beautiful on all devices
- 🔍 **Powerful Filters** - Filter documents by main folder and subfolder
- 👁️ **Built-in PDF Viewer** - View PDFs directly on the website without downloading
- ⬇️ **Easy Download** - Download button for each document
- 🖼️ **Cover Image Support** - Automatically display cover image for each PDF
- ⚙️ **Flexible Customization** - Configure column display for mobile, tablet, desktop
- 🏷️ **Folder Renaming** - Customize display names for folders
- 📱 **100% Responsive** - Works smoothly on all screen sizes

### 📋 System Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- jQuery (automatically included in WordPress)

### 🚀 Installation

1. **Upload the plugin**
   - Upload the plugin folder to `/wp-content/plugins/wp-pdf-view/`
   - Or upload the zip file and install via WordPress Admin

2. **Activate the plugin**
   - Go to `Plugins` in WordPress Admin
   - Find `MTL PDF View Gallery` and click `Activate`

3. **Prepare PDF folder**
   - Upload PDF files to your `wp-content/uploads/` directory
   - Folder structure should look like:
     ```
     wp-content/uploads/2025/10/so hoa TTHC/
     ├── Main Folder 1/
     │   ├── Subfolder A/
     │   │   ├── file1.pdf
     │   │   ├── file1.jpg (cover image - optional)
     │   │   └── file2.pdf
     │   └── file3.pdf
     ├── Main Folder 2/
     │   └── file4.pdf
     ```

4. **Add shortcode to page**
   - Create or edit a page/post
   - Add shortcode: `[pdf_view]`

### ⚙️ Configuration

Go to `MTL PDF View` in WordPress Admin menu to configure:

#### 1. **Path Configuration**
- Set the relative path to PDF folder (from uploads directory)
- Example: `2025/10/so hoa TTHC`

#### 2. **Grid Display Configuration**
- **Mobile**: Number of columns on screens < 768px (recommended: 1-2)
- **Tablet**: Number of columns on screens 768px-1024px (recommended: 2-3)
- **Desktop**: Number of columns on screens > 1024px (recommended: 3-4)

#### 3. **Folder Name Customization**
- Change display names for folders (keep original folder names on server)
- Set Vietnamese names or more descriptive names

#### 4. **Label Customization**
- Change display labels for filters
- Default: "Main folder", "Sub folder"

### 📖 Usage

#### Basic shortcode:
```
[pdf_view]
```

#### How to add cover images for PDFs:
The plugin automatically searches for cover images with the following names (in the same folder as the PDF file):
- `filename-pdf.jpg` or `filename-pdf.png`
- `filename.jpg` or `filename.png`

Example: If the PDF file is named `report-2024.pdf`, the plugin will search for:
1. `report-2024-pdf.jpg`
2. `report-2024-pdf.png`
3. `report-2024.jpg`
4. `report-2024.png`

### 🎨 Interface Features

- **Modern card layout** - Each PDF is displayed as a card with thumbnail
- **Hover effects** - Effects when hovering over cards
- **Modal popup** - View PDFs in fullscreen modal popup
- **Smooth animations** - Smooth transition effects
- **Loading states** - Display loading state when fetching data

### ❓ Frequently Asked Questions (FAQ)

**Q: Does the plugin support files other than PDF?**  
A: Currently the plugin only supports PDF files (.pdf)

**Q: Can I change the interface colors?**  
A: Yes, you can edit the `assets/style.css` file to customize colors and styles

**Q: Does the plugin affect website speed?**  
A: The plugin is optimized, only loads assets when needed and uses AJAX to load files

**Q: How are PDFs sorted?**  
A: Files are displayed in alphabetical order by filename

**Q: Can I limit the number of PDFs displayed?**  
A: Currently the plugin displays all PDFs in the selected folder

### 🔄 Changelog

**Version 1.3.0**
- Improved UI/UX
- Added grid column customization for responsive
- Added folder renaming feature
- Performance optimization
- Minor bug fixes

**Version 1.2.0**
- Added subfolder support
- Improved PDF viewer
- Added reset filters button

**Version 1.1.0**
- Added PDF cover images
- Improved responsive design
- Added admin settings page

**Version 1.0.0**
- Initial release

### 📞 Support

If you need support, please contact:
- Website: [maitruclam.com](https://maitruclam.com)

---

## 📄 License

This plugin is licensed under the GPL v2 or later.

```
Copyright (C) 2026 maitruclam.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

---

**Made with ❤️ by [maitruclam.com](https://maitruclam.com)**

