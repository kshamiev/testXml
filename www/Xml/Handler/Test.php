<?php
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 foldmethod=marker: */
/**
 * @package Service
 */

/**
 * Класс реализующий обрабчики нод XML объекта.
 *
 * Для обработки нужной ноды создется метод-обработчик с соответсвующим ей именем.
 * К примеру: &lt;item ...&gt; ... &lt;/item&gt; = function Item()
 * ! Регистр и там и там не имеет значения !
 * Сулжит в первую очередь для поточной обработки нод.
 * Во время парсинга файла очень большего размера.
 * После обработки он не добавляется в общее дерево объекта XML
 *
 * @package Service
 * @subpackage XML
 * @author Konstantin Shamiev aka marko-polo <konstanta75@mail.ru>
 * @version 16.03.2010
 */
class Xml_Handler_Test extends Xml_Handler
{
    protected $FlagBool = ['да' => 1, 'true' => 1, '1' => 1, '+' => 1, 'нет' => 0, 'false' => 0, '0' => 0, '-' => 0];

    /**
     * Обработчик ноды одноименной методу (без учета регистра)
     *
     * @param Xml_Object $xml
     * @return bool
     */
    public function offer(Xml_Object $xml)
    {
        // Main
        $params = [];

        $attributes = $xml->Get_Attributes();
        if ( !isset($attributes['internal-id']) )
            return Zero_Logs::Error('error attribute internal-id');
        $params[] = $attributes['internal-id'];

        if ( is_null($node = $xml->Get_Node('type')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag type');
        $params[] = $node->Get_Data();

        if ( is_null($node = $xml->Get_Node('property-type')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag property-type');
        $params[] = $node->Get_Data();

        if ( is_null($node = $xml->Get_Node('category')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag category');
        $params[] = $node->Get_Data();

        if ( is_null($node = $xml->Get_Node('url')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag url');
        $params[] = $node->Get_Data();

        if ( is_null($node = $xml->Get_Node('creation-date')) || !$node->Get_Data() || null == $date = $this->CheckDate($xml->Get_Data()) )
            return Zero_Logs::Error('error tag creation-date');
        $params[] = $date->format('Y-m-d H:i:s');

        if ( !is_null($node = $xml->Get_Node('last-update-date')) && '' != $node->Get_Data() )
        {
            if ( is_null($date = $this->CheckDate($xml->Get_Data())) )
                return Zero_Logs::Error('error tag last-update-date');
            $params[] = $date->format('Y-m-d H:i:s');
        }
        else
        {
            $params[] = '';
        }

        if ( !is_null($node = $xml->Get_Node('expire-date')) && '' != $node->Get_Data() )
        {
            if ( is_null($date = $this->CheckDate($xml->Get_Data())) )
                return Zero_Logs::Error('error tag expire-date');
            $params[] = $date->format('Y-m-d H:i:s');
        }
        else
        {
            $params[] = '';
        }

        if ( is_null($node = $xml->Get_Node('payed-adv')) || !$node->Get_Data() || !isset($this->FlagBool[$node->Get_Data()]) )
            return Zero_Logs::Error('error tag payed-adv');
        $params[] = $this->FlagBool[$node->Get_Data()];

        if ( is_null($node = $xml->Get_Node('manually-added')) || !$node->Get_Data() || !isset($this->FlagBool[$node->Get_Data()]) )
            return Zero_Logs::Error('error tag manually-added');
        $params[] = $this->FlagBool[$node->Get_Data()];

        // Location
        if ( is_null($nodeLocation = $xml->Get_Node('location')) )
            return Zero_Logs::Error('error tag location');

        if ( is_null($node = $nodeLocation->Get_Node('country')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag location country');
        $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('region')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('district')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('locality-name')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('sub-locality-name')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('address')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('direction')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('distance')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('latitude')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodeLocation->Get_Node('longitude')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        // Metro
        if ( is_null($nodeMetro = $nodeLocation->Get_Node('metro')) )
        {
            $params[] = '';
            $params[] = '';
            $params[] = '';
        }
        else
        {
            if ( is_null($node = $nodeMetro->Get_Node('name')) )
                $params[] = '';
            else
                $params[] = $node->Get_Data();

            if ( is_null($node = $nodeMetro->Get_Node('time-on-transport')) )
                $params[] = '';
            else
                $params[] = $node->Get_Data();

            if ( is_null($node = $nodeMetro->Get_Node('time-on-foot')) )
                $params[] = '';
            else
                $params[] = $node->Get_Data();
        }

        if ( is_null($node = $nodeLocation->Get_Node('railway-station')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        // Price
        if ( is_null($nodePrice = $xml->Get_Node('price')) )
            return Zero_Logs::Error('error tag price');

        if ( is_null($node = $nodePrice->Get_Node('value')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag price value');
        $params[] = $node->Get_Data();

        if ( is_null($node = $nodePrice->Get_Node('currency')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag price currency');
        $params[] = $node->Get_Data();

        if ( is_null($node = $nodePrice->Get_Node('period')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        if ( is_null($node = $nodePrice->Get_Node('unit')) )
            $params[] = '';
        else
            $params[] = $node->Get_Data();

        // SalesAgent
        $params_sales = [];

        if ( is_null($nodeSales = $xml->Get_Node('sales-agent')) )
            return Zero_Logs::Error('error tag sales-agent');

        if ( is_null($node = $nodeSales->Get_Node('name')) )
            $params_sales[] = '';
        else
            $params_sales[] = $node->Get_Data();

        if ( is_null($node = $nodeSales->Get_Node('phone')) || !$node->Get_Data() )
            return Zero_Logs::Error('error tag phone');
        $params_sales[] = $node->Get_Data();

        if ( is_null($node = $nodeSales->Get_Node('category')) )
            $params_sales[] = '';
        else
            $params_sales[] = $node->Get_Data();

        if ( is_null($node = $nodeSales->Get_Node('organization')) )
            $params_sales[] = '';
        else
            $params_sales[] = $node->Get_Data();

        if ( is_null($node = $nodeSales->Get_Node('agency-id')) )
            $params_sales[] = '';
        else
            $params_sales[] = $node->Get_Data();

        if ( is_null($node = $nodeSales->Get_Node('url')) )
            $params_sales[] = '';
        else
            $params_sales[] = $node->Get_Data();

        if ( is_null($node = $nodeSales->Get_Node('email')) )
            $params_sales[] = '';
        else
            $params_sales[] = $node->Get_Data();

        if ( is_null($node = $nodeSales->Get_Node('partner')) )
            $params_sales[] = '';
        else
            $params_sales[] = $node->Get_Data();

        // Sql

        $sql = "INSERT Offers SET
            internal_id = %d,
            type = %s,
            property_type = %s,
            category = %s,
            url = %s,
            creation_date = %s,
            last_update_date = %s,
            expire_date = %s,
            payed_adv = %d,
            manually_added = %d,
            country = %s,
            region = %s,
            district = %s,
            locality_name = %s,
            sub_locality_name = %s,
            address = %s,
            direction = %s,
            distance = %d,
            latitude = %d,
            longitude = %d,
            metroName = %s,
            time_on_transport = %d,
            time_on_foot = %d,
            railway_station = %s,
            price = %f,
            currency = %s,
            period = %s,
            unit = %s
        ";
        $sql = Zero_DB::Escape_Format($sql, $params);
        if ( !$offer_id = Zero_DB::Ins($sql) )
        {
            return Zero_Logs::Error('error offer save: ' . $attributes['internal-id']);
        }

        $sql = "INSERT OffersSalesAgent SET
            name = %s,
            phone = %s,
            category = %s,
            organization = %s,
            agency_id = %d,
            url = %s,
            email = %s,
            partner = %s,
            Offers_Id = %d
        ";
        $params_sales[] = $offer_id;
        $sql = Zero_DB::Escape_Format($sql, $params_sales);
        Zero_DB::Ins($sql);

        // Images
        if ( !is_null($nodeImages = $xml->Get_Nodes('image')) )
        {
            $sqlImages = [];
            $sql = "INSERT INTO `OffersImages`(`Offers_Id`, `image`) VALUES ";
            foreach ($nodeImages as $node)
            {
                /* @var $node Xml_Object */
                if ( '' != $img = $node->Get_Data() )
                    $sqlImages [] = '(' . $offer_id . ', ' . Zero_DB::Escape_T($img) . ')';
            }
            if ( 0 < count($sqlImages) )
            {
                $sql .= implode(', ', $sqlImages);
            }
            Zero_DB::Ins($sql);
        }

        return Zero_Logs::Info('обработка предложения id: ' . $attributes['internal-id']);
    }

    /**
     * Обработчик ноды одноименной методу (без учета регистра)
     *
     * @param Xml_Object $xml
     * @return bool
     * @throws Exception
     */
    public function generation_date(Xml_Object $xml)
    {
        $date = $this->CheckDate($xml->Get_Data());
        if ( is_null($date) )
        {
            Zero_Logs::Error('формат даты указан неверно (generation_date) ' . $xml->Get_Data());
            throw new Exception(mysqli_connect_error(), 500);
        }
        return Zero_Logs::Info('дата обрабатываемого файла: ' . $date->format('Y-m-d H:i:s'));
    }

    /**
     * @param $data
     * @return DateTime|null
     */
    protected function CheckDate($data)
    {
        try
        {
            $date = new DateTime($data);
        } catch ( Exception $e )
        {

            return null;
            //            throw new Exception('формат даты указан неверно', 500);
        }
        return $date;
    }
}
