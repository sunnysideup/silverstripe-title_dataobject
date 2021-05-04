<?php

namespace Sunnysideup\TitleDataObject\Model;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use Sunnysideup\TitleDataObject\Traits\FindOrCreate;

class TitleDataObject extends DataObject
{
    use FindOrCreate;

    private static $table_name = 'TitleDataObject';

    private static $db = [
        'Title' => 'Varchar(255)',
    ];

    private static $casting = [
        "CalculatedTitle" => 'Varchar',
    ];

    private static $indexes = [
        'Title' => 'unique("Title, ClassName")',
    ];

    private static $searchable_fields = [
        'Title' => 'PartialMatchFilter',
    ];

    // NOTE: we do not use default_sort, because that can't be overridden.
    
    public function CalculatedTitle(): string
    {
        return $this->Title ? $this->Title : '';
    }
}
