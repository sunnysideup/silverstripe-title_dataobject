<?php

namespace Sunnysideup\TitleDataObject\Model;

use SilverStripe\ORM\DataObject;
use Sunnysideup\TitleDataObject\Traits\FindOrCreate;

/**
 * Class \Sunnysideup\TitleDataObject\Model\TitleDataObject.
 *
 * @property string $Title
 */
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

    /**
     * @see: https://stackoverflow.com/questions/63227834/return-self-for-the-return-type-of-a-function-inside-a-php-trait
     */
    public function validate()
    {
        $result = parent::validate();

        // must have a value
        if (! $this->Title) {
            $fieldLabels = $this->FieldLabels();
            $result->addError(
                _t(
                    $this->ClassName . '.Title_NOT_EMPTY_REQUIREMENT',
                    $fieldLabels['Title'] . ' needs to be entered'
                ),
                'Title_NOT_EMPTY_REQUIREMENT_' . str_replace('\\', '_', $this->ClassName)
            );
        }

        // must be unique
        $id = (empty($this->ID) ? 0 : $this->ID);
        $exists = self::get()
            ->filter(['Title' => $this->Title, 'ClassName' => $this->ClassName])
            ->exclude(['ID' => $id])
            ->exists()
        ;
        if ($exists) {
            $fieldLabels = $this->FieldLabels();
            $result->addError(
                _t(
                    $this->ClassName . '.Title_UNIQUE_REQUIREMENT',
                    $fieldLabels['Title'] . ' needs to be unique'
                ),
                'Title_UNIQUE_REQUIREMENT_' . str_replace('\\', '_', $this->ClassName)
            );
        }

        return $result;
    }
}
