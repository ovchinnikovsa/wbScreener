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

## API Методы

Все методы формируют ответ в формате JSON.

Доступны через HTTP метод GET.

- ### Метод getProducts
> Пример `/getProducts/?search_query=футболка+мужская`

    Возвращает закешированный список товаров по поисковому запросу.
    - `search_query`: URL-кодированная строка с поисковыми словами.

- ### Метод getNewProducts
> Пример `/getNewProducts?search_query=футболка+мужская`

    Получает список новых товаров по поисковому запросу, сохраняет его в памяти и возвращает в формате JSON.
    - `search_query`: URL-кодированная строка с поисковыми словами.

- ### Метод getArticle
> Пример `/getArticle?article=111111111`

    Получает информацию о товаре по его артикулу и возвращает позицию в поиске, наименование и артикул товара в формате JSON.
    - `article`: Артикул товара.