Запросы приходят на http://127.0.0.1:8000/api/products или http://127.0.0.1:8000/api/products/{id}.

В случае http://127.0.0.1:8000/api/products, вызывается контроллер CatalogController и в нем метод getAll(). 
{
    В методе getAll() сначала достаем все продукты из таблицы catalog. 
    
    CatalogController.php 22 строка: $products = $this->catalog->getAll();
    
    getAll() также метод и в модели Catalog, название которой соответствует названию таблицы catalog.
    
    Catalog.php 21 строка: $products['products'] = $this->all(); - создаем массив $products, а в нем ключ ['products'], у которого 
    значение - все обькты модели.
    
    Catalog.php 22 строка: CatalogCurrencies::getCurrencyConvertUAH($products['products']); - вызываем статический метод в 
    модели CatalogCurrencies, которая НЕ соответствует названию таблицы, (название таблицы указано в protected свойстве $table),
    метод getCurrencyConvertUAH - конвертирует цены которые указаны в таблице в разных валютах, в главную валюту - гривны.
    
    Параметром в getCurrencyConvertUAH передаем массив обьектов модели Catalog. 
    CatalogCurrencies.php 21 строка: $product->attributes['price'] = round($product->attributes['price'] * $product->currency->rate);
    присваиваем атрибуту price соответствующую цену по курсу, который указан в таблице catalog_currencies (столбец rate), 
    с помощью связей которые нам предоставляет Eloquent. Связь описана в обеих моделях как один ко многим. 
    
    Catalog.php 23 строка: $products = $this->addExtraInfo($products); - c помощью метода addExtraInfo() добавляем обязательные
    данные в массив $products, исходя из указанного в ТЗ. В метод передаем весь массив $products.
    
    Catalog.php 38 строка: $array['totalNumberOfFilteredItems'] = count($array['products']); в ключе totalNumberOfFilteredItems
    будет находится количество отфильтрованных товаров, т.к. фильтров по данному маршруту у нас не будет, в этом ключе всегда будет
    значение 0.
    
    Catalog.php 39 строка: $array['totalQuantityOfGoods'] = self::count(); в ключе totalQuantityOfGoods будет находится количество
    всех товаров таблицы catalog.
    
    На данном этапе массив имеет вид:
    [
        'products' = [{данные продукта}, {...}, {...}, ...],
        'totalNumberOfFilteredItems' = 0,
        'totalQuantityOfGoods' = n,
    ]
    
    Catalog.php 24 строка: возвращаем массив с конвертированными ценами и обязательными данными выборки.


    CatalogController.php 23 строка: $products['products'] = CatalogResource::collection($products['products']); - воспользуемся 
    классом CatalogResource что бы передать небходимые данные во фронтенд(в нашем случае сразу вывод пользователю).
    
    CatalogController.php 24 строка: return response()->json($products); - возвращаем ответ в формате json.
}

В случае http://127.0.0.1:8000/api/products/{id} 
{
    Перед попаданием в контроллер, запрос попадает в посредник PriceSortValid.php, где происходит валидация вводных данных.
    В случае непрохождения валидации, происходит ответ с кодом 400 (Bad request) и сообщением - false.
    В случае успешного прохождения валидации запрос попадает в CatalogController, метод getByFilters(). 
    
    Метод принимает 3 параметра: $id - id указанной категории, $filter - обьект класса App\Services\Filters\Products\ProductsFilter,
    $request - обьект класса Illuminate\Http\Request. 
    
    CatalogController.php 29 строка: $products = $this->catalog->getInCategoryByFilters($filter->applyFilters($idCategory, $request), $request);
    Получаем массив отфильтрованных товаров с помощью метода getInCategoryByFilters(), который принимает первым 
    параметром - построитель запросов, вторым - обьект класса Illuminate\Http\Request.
    
    Фильтры:
    Метод applyFilters(), находится в трейте App\Services\Filters\FiltersHandler, и принимает 2 параметра, $id - id категории,
    обьект класса Illuminate\Http\Request.
    
    Так как FiltersHandler это трейт в классе App\Services\Filters\Products\ProductsFilter, то обьект данного класса обращается
    к методу своего трейта applyFilters().
    
    FiltersHandler.php 13 строка: $this->category($id); Применяем филтр по категории и возвращаем построитель
    запросов $query_builder.
    
    FiltersHandler.php 13 - 18 строка: Перебираем массив $request->all(), где ключи фильтров = названия методов в
    ProductsFilter.php, и с помощью встроенных в PHP функций, обращаемся только к тем методам класса ProductsFilter
    которые указанны в запросе.
    
    В каждом методе\фильтре фильтрация описывается посредством добавления условий выборки в $query_builder.(Применяются все фильтры
    кроме фильтра по price).
    
    FiltersHandler.php 19 строка: возвращается построитель запросов.
    
    Catalog.php 29 строка: $products['products'] = $query_builder->get(); присваеваем в $products['products'] все отфилтрованные
    товары.
    
    Catalog.php 30 строка: CatalogCurrencies::getCurrencyConvertUAH($products['products']); - конвертирует цены которые 
    указаны в таблице в разных валютах, в главную валюту - гривны. Полное описание метода выше.

    Catalog.php 31 строка: $products['products'] = PriceFilter::filtrate($products['products'], $request->get('price')['from'],
    $request->get('price')['to']); - к уже отфильтрованным товарам применяем фильтр по price'у, который указан в запросе.
     
     Статический метод filtrate() класса App\Services\Filters\Products\PriceFilter принимает 3 параметра: $products - 
     массив отфильтрованных товаров, $from - нижний порог цены, $to - верхний порог цены.
     
     PriceFilter.php 10 - 16 строка: метод filtrate() перебирает массив продуктов, и удаляет из массива продукты, которые не
     проходят фильтрацию.
     
     Примечание: 
     Благодаря ранее известному методу getCurrencyConvertUAH(), все цены продуктов уже в гривнах. Так как выборка в запросе
     указана в гривнах, соответственно фильтрация должна происходить только с продуктами у которых цена в гривнах.
     
     PriceFilter.php 17 строка: возвращает массив отфильтрованных по цене продуктов.
     
     Catalog.php 32 строка: $products = $this->addExtraInfo($products); c помощью метода addExtraInfo() добавляем обязательные
     данные в массив $products, исходя из указанного в ТЗ. В метод передаем весь массив $products.
     
     Catalog.php 33 строка: возвращаем массив с отфильтрованными товарами.
     
     CatalogController.php 30 строка: $products['products'] = CatalogResource::collection($products['products']); - воспользуемся 
     классом CatalogResource что бы передать небходимые данные во фронтенд(в нашем случае сразу вывод пользователю).
     
     CatalogController.php 31 строка: return response()->json($products); - возвращаем ответ в формате json.
}



