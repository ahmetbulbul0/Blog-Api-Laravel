# Blog Yönetim Sistemi

Bu proje, Laravel framework'ü kullanılarak geliştirilmiş kapsamlı bir blog yönetim sistemidir. Modern blog yönetimi için gerekli tüm temel özellikleri içerir ve kolayca genişletilebilir bir yapıya sahiptir.

## 🚀 Kurulum Talimatları

### Sistem Gereksinimleri
- PHP >= 8.1
- Composer
- MySQL veya PostgreSQL
- Node.js & NPM

### Adım Adım Kurulum
1. Projeyi klonlayın:
   ```bash
   git clone [proje-url]
   cd blog-management-system
   ```

2. Composer bağımlılıklarını yükleyin:
   ```bash
   composer install
   ```

3. NPM paketlerini yükleyin:
   ```bash
   npm install
   ```

4. Örnek env dosyasını kopyalayın:
   ```bash
   cp .env.example .env
   ```

5. Uygulama anahtarını oluşturun:
   ```bash
   php artisan key:generate
   ```

6. Veritabanı ayarlarını yapın:
   - `.env` dosyasında veritabanı bilgilerinizi düzenleyin
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=blog_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Veritabanı tablolarını oluşturun:
   ```bash
   php artisan migrate
   ```

8. (Opsiyonel) Örnek verileri yükleyin:
   ```bash
   php artisan db:seed
   ```

9. Uygulamayı başlatın:
   ```bash
   php artisan serve
   ```

## 📦 Mevcut Modüller

### 1. Kullanıcı Yönetimi
- Kullanıcı kaydı ve girişi
- Rol tabanlı yetkilendirme sistemi
- Kullanıcı profil yönetimi

### 2. Blog Yönetimi
- Post oluşturma, düzenleme ve silme
- Kategori yönetimi
- Etiket sistemi
- Görüntülenme sayısı takibi

### 3. Yorum Sistemi
- Post yorumları
- Yorum moderasyonu
- Yanıt verme özelliği

### 4. İçerik Organizasyonu
- Kategorilere göre sınıflandırma
- Etiketleme sistemi
- Arama ve filtreleme özellikleri

## 🔌 API Dokümantasyonu

### Kimlik Doğrulama
```
POST /api/auth/login
POST /api/auth/register
POST /api/auth/logout
```

### Blog Post Endpoint'leri
```
GET    /api/posts           - Tüm postları listele
POST   /api/posts           - Yeni post oluştur
GET    /api/posts/{id}      - Post detaylarını getir
PUT    /api/posts/{id}      - Post güncelle
DELETE /api/posts/{id}      - Post sil
```

### Kategori Endpoint'leri
```
GET    /api/categories
POST   /api/categories
GET    /api/categories/{id}
PUT    /api/categories/{id}
DELETE /api/categories/{id}
```

### Yorum Endpoint'leri
```
GET    /api/posts/{id}/comments
POST   /api/comments
PUT    /api/comments/{id}
DELETE /api/comments/{id}
```

## 🎨 Frontend Geliştirme Kılavuzu

### Önerilen Teknolojiler
- Vue.js veya React
- Tailwind CSS (projede mevcut)
- Axios HTTP client

### API Entegrasyonu
1. API base URL'ini yapılandırın
2. Interceptor'lar ile token yönetimini yapın
3. Error handling mekanizması kurun

### Best Practices
- Component bazlı geliştirme yapın
- State management kullanın (Vuex/Redux)
- Form validasyonlarını frontend'de de uygulayın
- Responsive tasarım prensiplerini takip edin

## 🔮 Gelecek Güncellemeler

### Planlanan Özellikler
1. **Medya Yönetimi**
   - Gelişmiş dosya yükleme sistemi
   - Resim optimizasyonu
   - Medya kütüphanesi

2. **SEO Optimizasyonu**
   - Meta tag yönetimi
   - Sitemap oluşturma
   - URL yapılandırması

3. **İstatistik ve Analiz**
   - Detaylı ziyaretçi analizi
   - Post performans metrikleri
   - Kullanıcı davranış analizi

4. **Çoklu Dil Desteği**
   - Dinamik dil yönetimi
   - İçerik çevirisi
   - Dil bazlı URL yapısı

5. **Gelişmiş Yetkilendirme**
   - Detaylı rol ve izin sistemi
   - Kullanıcı grupları
   - Özel izin tanımlamaları

## 📝 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasını inceleyebilirsiniz.

## 🤝 Katkıda Bulunma

1. Fork'layın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit'leyin (`git commit -m 'feat: Add amazing feature'`)
4. Branch'i push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun
