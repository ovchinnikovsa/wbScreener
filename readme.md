# wbScreener

Just for parse wb top positions by search keywords.

## Installations

###  Requirements:
* linux or win, under wsl
* installed docker
* installed make app

### Steps to build

Run make instructions:

1. `make build`
2. `make run`
3. `make composer-install`
4. `make db_restore`

To stop - `make stop`

Also u can change db access in `.env` file.

## API methods

Все методы формируют ответ в формате json.

- ### Метод get
    > Пример `/get/?search=поисковое%20слово`

    В качестве ответа отдаёт закешированный список товаров по поисковому слову.
    , search - urlencoded строка с поисковыми словами.

- ### Метод get-new
    > Пример `/get-new/?search=поисковое%20слово`

    Получает список товаров по поисковому слову, сохраняет его в памяти и отдаёт в формате json, search - urlencoded строка с поисковыми словами.

- ### Метод article
    > Пример `/get-article/11111111`

    Получает список товаров по поисковому слову, сохраняет его в памяти и отдаёт (позиция в поиске, наименование товара, артикул товара) в формате json, search - urlencoded строка с поисковыми словами.