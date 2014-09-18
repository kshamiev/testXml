<?php
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 foldmethod=marker: */
/**
 * @package Service
 */

/**
 * Класс реализующий работу с XML объектами.
 *
 * XML в виде древовидного объекта.
 * Доступ к нодам осуществяется как к свойствам объекта.
 * Доступ к значениям конретной ноды осуществяется через методы.
 * (атрибуты, содержимое ноды, ее имя)
 * Добавление новых нод осуществяется также через спекциальный метод.
 * Справка по определению нод:
 * При запросе количества ноды (count($Xml->root->items))
 * Возвращается 0 если ноды не существует, 1 если это нода, 2 и более если это список нод.
 *
 *
 * @package Service
 * @subpackage XML
 * @author Konstantin Shamiev aka marko-polo <konstanta75@mail.ru>
 * @version 16.03.2010
 */
class Xml_Object
{
    /**
     * Имя тега
     *
     * @var string
     */
    private $_Name = '';

    /**
     * Атрибуты тега
     *
     * @var array
     */
    private $_Attribute = [];

    /**
     * Значение или содержимое тега
     *
     * @var string
     */
    private $_Data = '';

    /**
     * Дочерние ноды
     *
     * @var array Xml_Object
     */
    private $_Node = [];

    /**
     * Конструткор, создание ноды.
     *
     * @param string $name - имя ноды
     * @param string $data - значение ноды или содержимое
     */
    public function __construct($name, $data = '')
    {
        $this->_Name = $name;
        $this->_Data = $data;
    }

    public function Get_Name()
    {
        return $this->_Name;
    }

    public function Get_Attributes()
    {
        return $this->_Attribute;
    }

    public function Set_Attribute($name, $value)
    {
        $this->_Attribute[$name] = $value;
    }

    public function Get_Data()
    {
        return $this->_Data;
    }

    /**
     * Присвоение ноде содержимого или значения.
     *
     * @param string $data - значение ноды или содержимое
     * @param integer $flag - флаг обработки данных (1 - обработка тегов для xml, 0 - удаление html тегов)
     */
    public function Set_Data($data, $flag = 1)
    {
        if ( 0 < $flag )
        {
            $this->_Data = Xml_Parser::String_Xml($data);
        }
        else
        {
            $this->_Data = Xml_Parser::String_Xml_NotHtml($data);
        }
    }

    /**
     * @param $name
     * @return Xml_Object
     */
    public function Get_Node($name)
    {
        if ( isset($this->_Node[$name]) )
        {
            return $this->_Node[$name][0];
        }
        return null;
    }

    /**
     * @param $name
     * @return array Xml_Object
     */
    public function Get_Nodes($name)
    {
        if ( isset($this->_Node[$name]) )
        {
            return $this->_Node[$name];
        }
        return null;
    }

    /**
     * @return array Xml_Object
     */
    public function Get_NodeTags()
    {
        return $this->_Node;
    }

    public function Set_Node(Xml_Object $Xml_Object)
    {
        $this->_Node[$Xml_Object->_Name][] = $Xml_Object;
    }


    /**
     * Поиск нод по имени в передаваемом Xml объекте.
     *
     * @param Xml_Object $Xml_Object - Xml объект в котором производится поиск
     * @param string $name - имя ноды которую ищем
     * @return Xml_Object - найденая нода/список нод либо null
     */
    public static function Search_Node(Xml_Object $Xml_Object, $name)
    {
        if ( false != $Xml = $Xml_Object->$name )
        {
            return $Xml;
        }
        else
        {
            foreach ($Xml_Object->Get_NodeTags() as $xml_list)
            {
                foreach ($xml_list as $xml)
                {
                    if ( false != $Xml = self::Search_Node($xml, $name) )
                    {
                        return $Xml;
                    }
                }
            }
            return null;
        }
    }

    /**
     * Создание дочерней ноды.
     *
     * @param string $name - имя ноды
     * @param string $data - значение ноды или содержимое
     * @return Xml_Object - созданная дочерняя нода.
     */
    public function Add_Node($name, $data = '')
    {
        $Xml_Node = new Xml_Object($name, $data);
        $this->Set_Node($Xml_Node);
        return $Xml_Node;
    }

    /**
     * универсальный геттер позволяющий обернуть все прямые обращения
     * к приватным, защищенным или абстрактным свойствам в их персональный геттер
     *
     * @param string $field свойство класса
     * @return mixed
     */
    public function __get($field)
    {
        //  получение дочерних нод
        if ( isset($this->_Node[$field]) )
        {
            if ( 1 < count($this->_Node[$field]) )
            {
                return $this->_Node[$field];
            }
            else
            {
                return $this->_Node[$field][0];
            }
        }
        return false;
    }
}
