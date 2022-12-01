# GetBasketProps (v. 1.0.0)
Данный модуль добавляет класс **GetBasketProps** для взаимодействия со свойствами товаров из корзины.

# Подключение
После установки в системе появится глобальный класс **GetBasketProps** по директории "local/php_interface/classes/GetBasketProps.php".
Подключается он с помощью файла init.php при помощи скрипта:

    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/classes/GetBasketProps.php'))
    {
        require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/classes/GetBasketProps.php');
    }

, либо другим удобным для Вас способом.

После удаление модуля класс будет удален.

# Вызов
Массив свойств товаров из корзины можно вызвать при помощи скрипта:

    GetBasketProps::getBasketElementPropertyValue(array('КОД_СВОЙСТВА_1', 'КОД_СВОЙСТВА_2'));

**ВНИМАНИЕ: В ПАРАМЕТР ПЕРЕДАВАТЬ ПРЕИМУЩЕСТВЕННО МАССИВ!**
В результате чего Вы получите массив свойств товаров из корзины, где в качестве ключа будет использован ID продукта.

Предположим, что в корзине два товара. Примерный результат:

    Array
    (
        [ID_продукта] => Array
            (
                [КОД_СВОЙСТВА_1'] => Значение
                [КОД_СВОЙСТВА_2] => Значение
            )

        [ID_продукта] => Array
            (
                [КОД_СВОЙСТВА_1] => Значение
                [КОД_СВОЙСТВА_2] => Значение
            )

    )

Также данным классом предусмотрен отдельный вызов ID товаров из корзины и их инфоблока.

    GetBasketProps::getBasketElementID() //вызов ID товаров из корзины
    GetBasketProps::getBasketIBlockID() //вызов ID инфоблока товаров из корзины

**ВНИМАНИЕ: ВСЕ ЗНАЧЕНИЯ ДЛЯ ТОВАРОВ ИЗ КОРЗИНЫ БЕРУТСЯ ИЗ МОДУЛЯ "ИНТЕРНЕТ-МАГАЗИН", А ТОЧНЕЕ ИЗ ЭЛЕМЕНТОВ ТИПА ИНФОБЛОКА "ТОРГОВЫЕ ПРЕДЛОЖЕНИЯ"!**

# Редактирование модуля (НЕ РЕКОМЕНДУЕТСЯ!)
Если Ваши классы расположены в другой директории, то стоит отредактировать две функции __addClass()__ и __deleteClass()__ внутримодульного класса **GetBasketPropClass**, расположенного относительно модуля по директории: "lib/GetBasketPropClass.php".

Пример редактирования:

    public function addClass()
    {
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/ПУТЬ_К_КЛАССАМ'))
        {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/ПУТЬ_К_КЛАССАМ');
        }

        if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/ПУТЬ_К_КЛАССАМ/GetBasketProps.php'))
        {
            $fp = fopen($_SERVER['DOCUMENT_ROOT']."/ПУТЬ_К_КЛАССАМ/GetBasketProps.php", "w");
            $php = '<?php';
            fwrite($fp, $php);
            fwrite($fp, implode($this->createText()));
            fclose($fp);
        }
    }

    public function deleteClass()
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/ПУТЬ_К_КЛАССАМ/GetBasketProps.php'))
        {
            unlink($_SERVER['DOCUMENT_ROOT']."/ПУТЬ_К_КЛАССАМ/GetBasketProps.php");
        }
    }

**Редактировать непосредственно сам класс GetBasketProps не рекомендую совершенно! ТОЛЬКО ОПЫТНЫМ РАЗРАБОТЧИКАМ!**

# Обратная связь
По всем вопросам https://t.me/columb1anin11
