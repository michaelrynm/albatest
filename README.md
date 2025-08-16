# 📌 Blog API (Laravel + Sanctum + Spatie Media Library)

REST API untuk **User, Category, Post, Bookmark** dengan autentikasi token (Sanctum) dan upload cover image (Spatie Media Library).  
Dilengkapi API documentation (OpenAPI/Swagger), pagination, dan soft delete.

---

## 🚀 Features
- Autentikasi: **Register, Login, Logout** (Laravel Sanctum)
- User profile (update name & bio)
- Category CRUD (soft delete)
- Post CRUD:
  - Relasi **User → hasMany → Post**
  - Relasi **Post → belongsTo → Category**
  - Upload **cover image** (Spatie Media Library)
  - Soft delete
- Bookmark:
  - Relasi **User ↔ many-to-many ↔ Post**
  - Toggle bookmark/unbookmark
  - Soft delete pivot
- API Resource (response JSON konsisten)
- Pagination untuk semua list
- API Docs dengan **OpenAPI/Swagger**

---

## 📋 Requirements
- PHP >= 8.2
- Composer
- SQLite (untuk database dev/testing)
- Node.js & npm/yarn (opsional, hanya jika butuh front-end assets)

---

## 🔧 Setup Project

1. **Clone repository**
   ```bash
   git clone https://github.com/your-username/blog-api.git
   cd blog-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi environment**
   - Copy `.env.example` ke `.env`:
     ```bash
     cp .env.example .env
     ```
   - Ubah konfigurasi DB untuk pakai SQLite:
     ```env
     DB_CONNECTION=sqlite
     DB_DATABASE=/absolute/path/to/database/database.sqlite
     ```
   - Buat file kosong untuk SQLite:
     ```bash
     touch database/database.sqlite
     ```

4. **Generate key**
   ```bash
   php artisan key:generate
   ```

5. **Migrate & seed database**
   ```bash
   php artisan migrate --seed
   ```
   Seeder otomatis membuat:
   - 1 akun admin → `admin@mail.com` / `password`
   - 10 user dummy
   - 5 kategori default + random
   - 20 post dummy

6. **Link storage (untuk upload cover image)**
   ```bash
   php artisan storage:link
   ```

7. **Run server**
   ```bash
   php artisan serve
   ```
   Akses di: [http://localhost:8000](http://localhost:8000)

---

## 📂 API Endpoint

Semua endpoint ada di prefix `/api`.

### 🔑 Auth
- `POST /api/auth/register` → registrasi user
- `POST /api/auth/login` → login, dapatkan token
- `POST /api/auth/logout` → logout (revoke token)

### 👤 User
- `GET /api/users/me` → lihat profil user login
- `PUT /api/users/me` → update profil (name, bio)

### 🗂️ Category
- `GET /api/categories` → list categories (pagination)
- `POST /api/categories` → buat kategori
- `GET /api/categories/{id}` → detail kategori
- `PUT /api/categories/{id}` → update kategori
- `DELETE /api/categories/{id}` → hapus kategori (soft delete)

### 📝 Post
- `GET /api/posts` → list posts (pagination, filter `?search=`, `?category_id=`)
- `POST /api/posts` → buat post (multipart: `title`, `content`, `category_id`, `cover`)
- `GET /api/posts/{id}` → detail post
- `PUT /api/posts/{id}` → update post (hanya author)
- `DELETE /api/posts/{id}` → hapus post (soft delete, hanya author)

### 🔖 Bookmark
- `POST /api/posts/{id}/bookmark` → toggle bookmark/unbookmark
- `GET /api/bookmarks` → list post yang di-bookmark user (pagination)

---

## 🔑 Authentication

Semua endpoint (kecuali register/login) dilindungi middleware **Laravel Sanctum**.  
Gunakan **Bearer Token**:

```
Authorization: Bearer {token}
Accept: application/json
```

Token diperoleh dari endpoint `POST /api/auth/login`.

---

## 📑 API Documentation (Swagger)

- File OpenAPI tersedia di:
  - `resources/api/openapi.yaml` → file sumber utama
  - `public/openapi.yaml` → file publik untuk Swagger UI
- Halaman Swagger UI bisa diakses di:
  ```
  http://localhost:8000/docs
  ```
- Bisa juga langsung load file `openapi.yaml` ke [Swagger Editor](https://editor.swagger.io).

---

## 🗄️ Database Seeding

Seeder default (`php artisan migrate:fresh --seed`) akan membuat:
- **Admin user** → email: `admin@mail.com`, password: `password`
- **10 user random**
- **10 kategori** (5 default + 5 acak)
- **20 post random** (user + kategori acak)

---

## 🧰 Development Tips

- **Clear cache**
  ```bash
  php artisan optimize:clear
  ```
- **Refresh DB**
  ```bash
  php artisan migrate:fresh --seed
  ```
- **Test upload cover via curl**
  ```bash
  curl -X POST http://localhost:8000/api/posts     -H "Authorization: Bearer {TOKEN}"     -F "title=Hello World"     -F "content=This is content"     -F "category_id=1"     -F "cover=@/path/to/image.jpg"
  ```

---

## 📜 License
MIT
