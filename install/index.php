<?php
use Bitrix\Main\Localization\Loc,
    Bitrix\Main\EventManager;

Loc::loadMessages(__FILE__);

class shirokov_getbasketprops extends CModule
{
    var $MODULE_ID = 'shirokov.getbasketprops';

    function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';

        $this->MODULE_ID = 'shirokov.getbasketprops';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage('GET_BASKET_PROPS_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('GET_BASKET_PROPS_MODULE_DESC');

        $this->PARTNER_NAME = Loc::getMessage('GET_BASKET_PROPS_PARTNER_NAME');
        $this->PARTNER_URI = 'https://t.me/columb1aini11';

        $this->FILE_PREFIX = 'getprop';
        $this->MODULE_FOLDER = str_replace('.', '_', $this->MODULE_ID);
        $this->FOLDER = 'bitrix';

        $this->INSTALL_PATH_FROM = '/' . $this->FOLDER . '/modules/' . $this->MODULE_ID;
    }

    function isVersionD7()
    {
        return true;
    }

    function DoInstall()
    {
        global $APPLICATION;
        if ($this->isVersionD7()) {
//            $this->InstallDB();
//            $this->InstallEvents();
            $this->installClass();
            $this->InstallFiles();

            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
        } else {
            $APPLICATION->ThrowException(Loc::getMessage('GET_BASKET_PROPS_INSTALL_ERROR_VERSION'));
        }
    }

    function DoUninstall()
    {
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

        $this->UnInstallFiles();
        $this->UnInstallClass();
//        $this->UnInstallEvents();
//        $this->UnInstallDB();
    }

//    function InstallDB()
//    {
//        return true;
//    }

//    function UnInstallDB()
//    {
//        return true;
//    }

    function installFiles()
    {
        return true;
    }

    function uninstallFiles()
    {
        return true;
    }

    function installClass()
    {
        $GetBasketPropClass = new GetBasketPropClass;
        $GetBasketPropClass->addClass();
    }
    function unInstallClass()
    {
        $GetBasketPropClass = new GetBasketPropClass;
        $GetBasketPropClass->deleteClass();
    }

//    function getEvents()
//    {
//        return [
//            ['FROM_MODULE' => 'sale', 'EVENT' => 'OnBasketAdd', 'TO_METHOD' => 'CheckBasket'],
//            ['FROM_MODULE' => 'sale', 'EVENT' => 'OnBasketDelete', 'TO_METHOD' => 'CheckBasket'],
//        ];
//    }
//
//    function InstallEvents()
//    {
//        $classHandler = 'GetBasketPropClass';
//        $eventManager = EventManager::getInstance();
//
//        $arEvents = $this->getEvents();
//        foreach($arEvents as $arEvent){
//            $eventManager->registerEventHandler(
//                $arEvent['FROM_MODULE'],
//                $arEvent['EVENT'],
//                $this->MODULE_ID,
//                $classHandler,
//                $arEvent['TO_METHOD']
//            );
//        }
//
//        return true;
//    }

//    function UnInstallEvents()
//    {
//        $classHandler = 'GetBasketPropClass';
//        $eventManager = EventManager::getInstance();
//
//        $arEvents = $this->getEvents();
//        foreach($arEvents as $arEvent){
//            $eventManager->unregisterEventHandler(
//                $arEvent['FROM_MODULE'],
//                $arEvent['EVENT'],
//                $this->MODULE_ID,
//                $classHandler,
//                $arEvent['TO_METHOD']
//            );
//        }
//
//        return true;
//    }
}