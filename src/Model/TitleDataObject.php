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
    
    public function validate()
    {
        $result = parent::validate();
        $id = (empty($this->ID) ? 0 : $this->ID);
        // https://stackoverflow.com/questions/63227834/return-self-for-the-return-type-of-a-function-inside-a-php-trait
        $exists = self::get()
            ->filter($field)
            ->exclude(['Title' => $this->Title, 'ClassName' => $this->ClassName])
            ->exists()
        ;
        if ($exists) {
            $fieldLabels = $this->FieldLabels();
            $result->addError(
                _t(
                    self::class . '.Title_UNIQUE_REQUIREMENT',
                    $fieldLabels['Title'] . ' needs to be unique'
                ),
                'UNIQUE_' . self::class . '.' . $field
            );
        }

        return $result;
    }
    
    
}
