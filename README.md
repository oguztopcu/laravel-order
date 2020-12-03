# Laravel Order API

Öncelikle, proje ana dizininde bulunan ve docker/ klasörü içinde bulunan .env.example kopyalayarak yeni bir .env dosyası oluşturun ve düzenleyin.

Docker ile çalıştırmak için proje içerisinde bulunan docker klasörüne giderek;
```
    docker-compose build
    docker-compose up -d
```

Önce build almanız daha sonrasında terminale bağlı kalmadan containerları çalıştırmalısınız.

Projeyi ayağa kaldırdıktan docker/ kalsörümüz içinde

```
    docker-compose exec php php artisan migrate
```

komutunu çalıştırın, database migrationları oluşsun.

Artık proje içerisinde bulunan postman_collection.json Postman uygulamasına import ederek erişim sağlayabilirsiniz.
