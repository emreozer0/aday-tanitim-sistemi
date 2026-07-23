# Aday Tanıtım Sistemi

Siyasi aday / belediye başkan adayı tanıtım siteleri için geliştirilmiş, PHP tabanlı bir içerik yönetim sistemi. Site ziyaretçileri adayın özgeçmişini, haberlerini, galerisini ve hizmet vaatlerini görüntüleyebilir; adminler ise bu içerikleri kolayca yönetebilir.

## Özellikler

**Ziyaretçi tarafı**
- Ana sayfa (özgeçmiş özeti, hizmet kartları, öne çıkan haberler)
- Haberler listesi ve haber detay sayfası
- Fotoğraf galerisi
- Hizmet vaatleri / kartları
- İletişim formu

**Admin paneli**
- Güvenli giriş (session + hashlenmiş şifre)
- Site ayarlarını düzenleme (site adı, iletişim bilgileri, sosyal medya, söz metni)
- Özgeçmiş içeriğini düzenleme
- Haber ekleme / düzenleme / silme
- Galeri fotoğrafı ekleme / silme
- Hizmet kartlarını yönetme
- Gelen iletişim mesajlarını görüntüleme

## Kullanılan Teknolojiler

- PHP 8.x
- MySQL / MariaDB
- HTML5, CSS3
- (Geliştirme ortamı: XAMPP)

## Kurulum

1. Bu depoyu klonlayın:
   ```bash
   git clone <https://github.com/emreozer0/aday-tanitim-sistemi>
   ```
2. `data.sql` dosyasını phpMyAdmin veya MySQL komut satırından içe aktarın:
   ```bash
   mysql -u root -p aday_tanitim_db < data.sql
   ```
   (Veritabanını önce `aday_tanitim_db` adıyla oluşturmanız gerekir.)
3. `core` klasörü altındaki veritabanı bağlantı dosyasında (`db.php` veya benzeri) kendi MySQL kullanıcı adı/şifre bilgilerinizi girin.
4. Projeyi XAMPP'in `htdocs` klasörüne kopyalayıp `http://localhost/<proje-klasoru>` adresinden çalıştırın.
5. Admin paneline `http://localhost/<proje-klasoru>/admin/login.php` adresinden, `data.sql` içindeki varsayılan admin hesabıyla giriş yapın.
   - **Önemli:** İlk girişten sonra admin şifresini mutlaka değiştirin.

## Klasör Yapısı

```
├── admin/              # Admin paneli sayfaları
│   ├── includes/        # Ortak layout (navbar) dosyaları
│   ├── dashboard.php
│   ├── ayarlar.php
│   ├── haberler.php
│   ├── galeri.php
│   ├── hizmetler.php
│   ├── mesajlar.php
│   ├── ozgecmis.php
│   └── login.php
├── core/                # Veritabanı bağlantısı ve ortak fonksiyonlar
├── upload/              # Yüklenen görseller
├── index.php            # Ana sayfa
├── haberler.php
├── haber_detay.php
├── galeri.php
├── ozgecmis.php
├── iletisim.php
└── data.sql             # Veritabanı şeması ve örnek veriler
```

## Notlar

- `data.sql` içindeki gerçek kullanıcı verileri (iletişim mesajları vb.) gizlilik nedeniyle örnek verilerle değiştirilmiştir.
- `upload/` klasörü altındaki gerçek görseller `.gitignore` ile depo dışında tutulmalıdır (bkz. `.gitignore`).

## Lisans

Bu proje kişisel/eğitim amaçlı geliştirilmiştir.