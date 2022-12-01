<?php

class GetBasketPropClass
{
    public function addClass()
    {
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/classes'))
        {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/classes');
        }

        if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/classes/GetBasketProps.php'))
        {
            $fp = fopen($_SERVER['DOCUMENT_ROOT']."/local/php_interface/classes/GetBasketProps.php", "w");
            $php = '<?php';
            fwrite($fp, $php);
            fwrite($fp, implode($this->createText()));
            fclose($fp);
        }
    }

    public function deleteClass()
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/classes/GetBasketProps.php'))
        {
            unlink($_SERVER['DOCUMENT_ROOT']."/local/php_interface/classes/GetBasketProps.php");
        }
    }

    private function createText()
    {
        $use = '

use Bitrix\Main,
    Bitrix\Sale;
';
        $class = '
class GetBasketProps';
        $classOpen = '{';
        $codeProperty = '   
    /**
    * Pass the array of basket product properties you need
    * @param $property: array
    * @return array
    */
    public static function codeProperty($property): array
    {
        return $property;
    }
';
        $getBasketElementID = '
    /**
     * Get the basket product ID array
     * @return array
     * @throws Main\ArgumentException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotImplementedException
     */
    public static function getBasketElementID(): array
    {
        $basket = Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Main\Context::getCurrent()->getSite());
        $getBasket = $basket->getBasket();
        $elementIDs = [];
        foreach($getBasket as $basketItem)
        {
            $product = $basketItem->getFieldValues();
            array_push($elementIDs, $product["PRODUCT_ID"]);
        }

        return $elementIDs;
    }
';
        $getBasketIBlockID = '
    /**
     * Get the basket infoblock ID
     * @return array|mixed
     * @throws Main\ArgumentException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotImplementedException
     */
    public static function getBasketIBlockID()
    {
        $IBLOCK_ID_OBJ = CIBlockElement::GetList(
            array(),
            array("ID"=>self::getBasketElementID()[0]),
            false,
            false,
            array("IBLOCK_ID")
        );
        $IBLOCK_ID = [];
        while($IBLOCK_ID_RES = $IBLOCK_ID_OBJ->Fetch())
            $IBLOCK_ID = $IBLOCK_ID_RES["IBLOCK_ID"];

        return $IBLOCK_ID;
    }
';
        $getBasketElementPropertyValue = '
    /**
     * Get the basket array of the product properties and their values
     * @param $property: array
     * @return array
     * @throws Main\ArgumentException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotImplementedException
     */
    public static function getBasketElementPropertyValue($property)
    {
        $propsValue = [];
        foreach (self::getBasketElementID() as $elementID) {
            $props = [];
            foreach (self::codeProperty($property) as $key)
            {
                $propObj = CIBlockElement::GetProperty(
                    self::getBasketIBlockID(),
                    $elementID,
                    array(),
                    array("CODE" => $key)
                );
                $value = [];
                if($propRes = $propObj->Fetch())
                    $value = $propRes["VALUE"];
                $props[$key] = $value;
            }
            $propsValue[$elementID] = $props;
        }

        return $propsValue;
    }';
    $classClose = '
}';

        return [$use, $class, $classOpen, $codeProperty, $getBasketElementID, $getBasketIBlockID, $getBasketElementPropertyValue, $classClose];
    }
}
