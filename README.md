# Система отправки форм для сайта kataem-zimoi.space

Этот проект содержит скрипт для отправки данных из контактной формы на электронную почту через SMTP Gmail.

## Важная информация о Gmail

Начиная с мая 2022 года, Google больше не поддерживает использование обычных паролей для доступа к почте через сторонние приложения. Вместо этого нужно использовать **пароли приложений**.

### Как настроить пароль приложения для Gmail:

1. Войдите в свой аккаунт Google
2. Перейдите к настройкам безопасности: https://myaccount.google.com/security
3. Включите двухфакторную аутентификацию, если она еще не включена
4. Откройте раздел "Пароли приложений" (находится под разделом "Двухэтапная проверка")
5. Выберите "Почта" и "Другое устройство" (введите имя, например "Сайт kataem-zimoi")
6. Google сгенерирует 16-значный пароль приложения
7. Скопируйте этот пароль и вставьте его в настройки скрипта (файл index.php, переменная `$mail->Password`)

## Установка

1. Загрузите файлы на хостинг через FTP:
   - Хост: 195.2.67.121
   - Логин: kataem_zimoi
   - Пароль: 4vsQRZESCIQY6zao

2. Если у вас установлен Composer, выполните в корневой директории сайта:
   ```
   composer install
   ```

3. Если Composer не установлен, файлы библиотеки PHPMailer уже включены в проект.

## Настройка

Откройте файл `index.php` и обновите следующие настройки:

```php
$mail->Username = 'DavidMitchell4416681@gmail.com'; // Gmail адрес
$mail->Password = 'ТУТ_ДОЛЖЕН_БЫТЬ_ПАРОЛЬ_ПРИЛОЖЕНИЯ'; // Пароль приложения (не обычный пароль!)
```

## Тестирование

После загрузки файлов на сервер, откройте сайт в браузере и отправьте тестовую форму. Проверьте, что сообщение успешно отправлено на указанный Gmail-адрес.

## Возможные проблемы

- Если письма не отправляются, проверьте журнал ошибок на сервере.
- Убедитесь, что на сервере включена функция `mail()` или настроен внешний SMTP-сервер.
- Проверьте, что вы используете правильный пароль приложения, а не обычный пароль от Gmail-аккаунта. # kataem-zimoi
