<?php

namespace Sunnysideup\TitleDataObject\Model;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;

class TitleDataObject extends DataObject
{
    private static $indexes = [
        'Title' => 'unique("Title, ClassName")',
    ];

    private static $searchable_fields = [
        'Title' => 'PartialMatchFilter',
    ];

    private static $default_sort = [
        'Title' => 'ASC',
    ];

    private static $table_name = 'TitleDataObject';

    private static $db = [
        'Title' => 'Varchar(255)',
    ];

    /**
     * to prevent racing conditions ...
     *
     * @var array
     */
    private static $_cache = [];

    /**
     * see README.md for usage ...
     *
     * @param string $title
     * @param bool $showDBAlterationMessage
     * @return DataObject
     */
    public static function find_or_create(string $title, ?bool $showDBAlterationMessage = false)
    {
        $title = trim($title);
        $titleToLower = strtolower($title);

        $className = static::class;
        $key = $className . '_' . $titleToLower;
        if (isset(self::$_cache[$key])) {
            if ($showDBAlterationMessage) {
                DB::alteration_message('Found ' . $className . ' with Title = <strong>' . $title . '</strong>');
            }
            return self::$_cache[$key];
        }

        if (! $title) {
            return $className::create();
        }

        $obj = $className::get()->where('LOWER("Title") =\'' . Convert::raw2sql($titleToLower) . '\'');

        if ($obj->count() === 0) {
            if ($showDBAlterationMessage) {
                DB::alteration_message(
                    'Creating new ' . $className . ' with Title = <strong>' . $title . '</strong>',
                    'created'
                );
            }
            $obj = $className::create();
        } else {
            if ($showDBAlterationMessage) {
                DB::alteration_message('Found ' . $className . ' with Title = <strong>' . $title . '</strong>');
            }
            $obj = $obj->first();
        }
        $obj->Title = $title;
        self::$_cache[$key] = $obj;
        $obj->write();

        return $obj;
    }
}
