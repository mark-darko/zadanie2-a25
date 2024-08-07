# Форма обратной связи

## Задача

Это репозиторий (Laravel + Vue 3/TS + TailwindCSS) с реализованной формой обратной связи. Данные из формы (заголовок, время обращения и описание) отправляются на сервер, где и сохраняются. После сохранения отзыва его можно посмотреть по идентификатору.

Вам требуется добавить в форму обратной связи два элемента:

1. Селектор для выбора сервиса, на который делается отзыв (Магазин, Доставка, Приложение)
2. 5-звёздочный рейтинг (выбор от 1 до 5 включительно)

Дизайн должен вписываться в уже существующий. Для написания стилей следует использовать TailwindCSS (обсуждаемо). Звёздочный рейтинг должен отображаться с реальными иконками звёздочек и закрашивать их необходимое кол-во при выборе. Все новые данные должны отправляться на сохранение и отображаться при просмотре отзыва так же, как и уже реализованные.

UseCases:

- Создание отзыва: `<title>, <description>, <time>, <service_name>, <rating>`. Отзыв сохраняется в базу.
- Просмотр отзыва: `<feedback_id>`. Отзыв со всеми данными отображается в пользовательском интерфейсе.

*Примечание: Технический контроль жалуется, что время обращения в заявке обрабатывается некорректно. Разберитесь, что там за баг.*

Для выполнения задания нужно клонировать к себе репозиторий локально. Сделанное задание нужно упаковать в архив без директорий `vendor` и `node_modules`, выложить его на файлообменник и прислать ссылку в чат телеграмма.

## Инструкция по развертыванию репозитория и настройке окружения

Необходимо иметь локально: `PHP 8+`, `Composer 2+`, `Node 16+`, `npm 8+`.

```shell
cp .env.example .env
```

Настройте `.env` в соответствии с вашей системой (установите ключи `DB_`). Создайте базу данных на основе установленных ключей.

```shell
php script install
php artisan test
cd ./app-front
npm ci
cp src/env.example.json src/env.json
```

Настройки в `env.json` настроены на дефолтный порт `artisan serve`. Если запускаете по другому — поменяйте настройки.

## Запуск

В корне:

```shell
php artisan serve
```

В app-front:

```shell
npm run dev
```