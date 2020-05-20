# Тестовое задание petshop.ru

## Дано

Имеeтся endpoint, по которому можно получить json-массив с результатами работы команд (пример):
```
[
  { "team": "Axiom", "scores": 88 },
  { "team": "BnL", "scores": 65 },
  { "team": "Eva", "scores": 99 },
  { "team": "WALL-E", "scores": 99 }
]
```
## Запуск проекта
Необходимо подхватить все зависимости `composer update`

Выполнить команду для запуска сервера `php artisan serve`

Задание реализовал как простой API.

по адресу `/get_teams`, указываем ссылку на endpoint в параметр `url_to_endpoint`,
({`/get_teams?url_to_endpoint=https://google.com`})

Обязательно указывать с протоколом (http(s)).
