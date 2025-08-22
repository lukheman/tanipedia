# Kebutuhan

1. PHP 8.2
2. Composer
3. Git

# Perintah untuk instalasi

- git clone https://github.com/lukheman/tanipedia.git
- cd tanipedia
- composer install
- php artisan migrate
- php artisan migrate:fresh --seed
- php artisan storage:link

# perintah untuk menjalankan

php artisan serve

Nama: Admin
email: admin@gmail.com

Nama: Petani 1
email: petani1@gmail.com

Nama: Petani 2
email: petani2@gmail.com

Nama: Ahli Pertanian
email: ahlipertanian@gmail.com

Nama: KEPALADINAS
email: kepaladinas@gmail.com


password semua user: password123

# Revisi

- Pisahkan pisah table setiap role
- ganti id -> id_konsultasi pada table konsultasi
- ganti id jadi id_nama_table di semua table
- pisahkan login petani dan login admin

