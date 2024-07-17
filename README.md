
### Тестове завдання BULLS MEDIA

#### Умови

https://docs.google.com/document/d/1-KvYqDeAU7nb0l5heJiHzbFvVFy5LRaPquLERtkjUW4/edit

https://docs.google.com/document/d/1XtC1P3g43PdseKp2Os_w9J_onHa0W5Kna0IbsMD561c/edit

#### Встановлення

* Розгортаємо локальну копію проекта
```
git clone 
```
* Переходимо в папку проекта
```
cd 
```
* Встановлюємо необхідні бібліотеки
```
composer install
```
* Створюємо базу даних MySQL, додаємо користувача до неї і оновлюємо привілеї
* Копіюємо файл конфігурації .env з .env.example і вносимо в нього свої креденшени до бази даних
* Виконуємо міграції
```
php artisan migrate
```
* Запускамо розробницький сервер
```
php artisan serve
```
* Запускаємо джобу з фонової обробки черги на відправку
```
php artisan queue:work
```
* Імпортуємо у Postman к колекцію з файла 
<i>IS-Delivery.postman_collection.json</i>
і виконуємо запит
<i>Parcel info send</i>
або
виконуємо запит, використовуючи <i>curl</i>
```
curl --location 'http://127.0.0.1:8000/send' \
--header 'Content-Type: application/json' \
--data-raw '{
    "first_name": "William",
    "middle_name": "Sherlock",
    "last_name": "Holmes",
    "email": "wssh64987634@gmail.com",
    "address": "221B Baker St, London NW1 6XE, Great Britain",
    "phone": "442072243688",
    "width": 200,
    "height": 300,
    "depth": 400,
    "weight": 500
}'
```

#### Реалізація

При відправці запиту на ендпойнт <i>/send</i> ([DeliveryController.php](app%2FHttp%2FControllers%2FDeliveryController.php)) після простої валідації у базі створюється запис в таблиці <b>users</b> (або використовується вже існуючий при наявності користовача з  таким самим e-mail-ом) і запис таблиці <b>parcels</b>, після чого запит на відправку на зовнішний адрес інформації про відправлення стає в чергу на відправку [SendParcelInfoJob.php](app%2FJobs%2FSendParcelInfoJob.php).

Відправка відбувається за допомою сервіса [NovaPostDeliveryService.php](app%2FServices%2FParcelInfoSenders%2FNovaPostDeliveryService.php), який реалізує інтерфейс [ParcelInfoSendInterface.php](app%2FServices%2FParcelInfoSenders%2FParcelInfoSendInterface.php). 

Для перевірки роботи необхідно у методі getUrl класа [NovaPostDeliveryService.php](app%2FServices%2FParcelInfoSenders%2FNovaPostDeliveryService.php) розкоментувати запит на власний тестовий урл проекта
```
        return 'http://127.0.0.1:8000/nova-post-receiver';
//        return config('deliveries.nova_post.host').config('deliveries.nova_post.urls.parcel_info_send');
```

Запит виконується контролером [TestReceiverController.php](app%2FHttp%2FControllers%2FTestReceiverController.php), в якому можна вибрати результат виконання запиту також розкоментуванням/закоментуванням
```
    public function receive(): Response
    {
//        return response('Ok', 200);
        return response('Bad request', 400);
    }
```
Після успішної чи неуспішної віправки запиту змінюється статус відправлення з <b>new</b> на <b>sent/failed</b> і генеруються івенти <b>ParcelInfoSuccessSentEvent/ParcelInfoFailSentEvent</b> відповідно.

У випадку необхідності реакції на невідравлений запит можно додати посилання повідолення через слухача івента <b>ParcelInfoFailSentEvent</b>.

Для повторної обробки невідправлених запитів можно зробити кроновий процесс, який раз  на пару годин буде робити перевідправку запитів зі статусом <b>failed</b> (передбачена зміна статусу на <b>retry_send</b>).

При можливості розширення служб доставки для кожної служби треба зробити новий сервіс, дочірній до [AbstractDeliveryService.php](app%2FServices%2FParcelInfoSenders%2FAbstractDeliveryService.php) і реалізуючий інтерфейс [ParcelInfoSendInterface.php](app%2FServices%2FParcelInfoSenders%2FParcelInfoSendInterface.php) і додати в список сервісів <b>services</b> класа [DeliveryCreatorService.php](app%2FServices%2FDeliveryCreatorService.php).

<i>Необхідно реалізувати логіку надсилання даних про посилку з урахуванням можливих майбутніх запитів клієнта. (*можна в коді прописати які можуть бути додаткові запити в майбутньому).</i>

Дуже дивно, що не передається інформація про розміри і вагу посилки у запит на відправку, мабуть воно там має бути, щоб служба доставки знала, з чим приїзжати по замовлення. З того, що можна додати - трекінг посилки наприклад. З боку сервісу відправки треба приймати ідентифікатор посилання у сліжбі доставки і зберігати його у <b>parcels</b>.

#### Розроблено в

PHP 8.3.6 + Laravel 11.15.0 + PHP development server

MySQL 8.4.1 (Ubuntu 24.04 LTS)
