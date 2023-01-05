<?php

namespace Sunnysideup\TitleDataObject\Model;

use SilverStripe\ORM\DataObject;
use Sunnysideup\TitleDataObject\Traits\FindOrCreate;

class TitleDataObject extends DataObject
{
    use FindOrCreate;

    private static $table_name = 'TitleDataObject';

    private static $db = [
        'Title' => 'Varchar(255)',
    ];

    private static $casting = [
        'CalculatedTitle' => 'Varchar',
    ];

    private static $indexes = [
        'Title' => ['type' => 'unique', 'columns' => ['Title', 'ClassName']],
    ];

    private static $searchable_fields = [
        'Title' => 'PartialMatchFilter',
    ];

    // NOTE: we do not use default_sort, because that can't be overridden.

    /**
     * This is here to improve export of has_one related objects that do not have a value.
     */
    public function CalculatedTitle(): string
    {
        return (string) $this->Title;
    }
}
