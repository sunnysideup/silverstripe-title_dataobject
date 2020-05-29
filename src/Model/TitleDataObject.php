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

    /**
     * ### @@@@ START REPLACEMENT @@@@ ###
     * OLD: private static $db (case sensitive)
     * NEW:
    private static $db (COMPLEX)
     * EXP: Check that is class indeed extends DataObject and that it is not a data-extension!
     * ### @@@@ STOP REPLACEMENT @@@@ ###
     */
    private static $table_name = 'TitleDataObject';

    /**
     * ### @@@@ START REPLACEMENT @@@@ ###
     * WHY: automated upgrade
     * OLD: private static $db = (case sensitive)
     * NEW: private static $db = (COMPLEX)
     * EXP: Make sure to add a private static $table_name!
     * ### @@@@ STOP REPLACEMENT @@@@ ###
     */
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
    public static function find_or_create($title, $showDBAlterationMessage = false)
    {
        $title = trim($title);
        $titleToLower = strtolower($title);

        /**
         * ### @@@@ START REPLACEMENT @@@@ ###
         * WHY: automated upgrade
         * OLD: $className (case sensitive)
         * NEW: $className (COMPLEX)
         * EXP: Check if the class name can still be used as such
         * ### @@@@ STOP REPLACEMENT @@@@ ###
         */
        $className = static::class;

        /**
         * ### @@@@ START REPLACEMENT @@@@ ###
         * WHY: automated upgrade
         * OLD: $className (case sensitive)
         * NEW: $className (COMPLEX)
         * EXP: Check if the class name can still be used as such
         * ### @@@@ STOP REPLACEMENT @@@@ ###
         */
        $key = $className . '_' . $titleToLower;
        if (isset(self::$_cache[$key])) {
            if ($showDBAlterationMessage) {

                /**
                 * ### @@@@ START REPLACEMENT @@@@ ###
                 * WHY: automated upgrade
                 * OLD: $className (case sensitive)
                 * NEW: $className (COMPLEX)
                 * EXP: Check if the class name can still be used as such
                 * ### @@@@ STOP REPLACEMENT @@@@ ###
                 */
                DB::alteration_message('Found ' . $className . ' with Title = <strong>' . $title . '</strong>');
            }
            return self::$_cache[$key];
        }

        if (! $title) {

            /**
             * ### @@@@ START REPLACEMENT @@@@ ###
             * WHY: automated upgrade
             * OLD: $className (case sensitive)
             * NEW: $className (COMPLEX)
             * EXP: Check if the class name can still be used as such
             * ### @@@@ STOP REPLACEMENT @@@@ ###
             */
            return $className::create();
        }

        /**
         * ### @@@@ START REPLACEMENT @@@@ ###
         * WHY: automated upgrade
         * OLD: $className (case sensitive)
         * NEW: $className (COMPLEX)
         * EXP: Check if the class name can still be used as such
         * ### @@@@ STOP REPLACEMENT @@@@ ###
         */
        $obj = $className::get()->where('LOWER("Title") =\'' . Convert::raw2sql($titleToLower) . '\'');

        if ($obj->count() === 0) {
            if ($showDBAlterationMessage) {

                /**
                 * ### @@@@ START REPLACEMENT @@@@ ###
                 * WHY: automated upgrade
                 * OLD: $className (case sensitive)
                 * NEW: $className (COMPLEX)
                 * EXP: Check if the class name can still be used as such
                 * ### @@@@ STOP REPLACEMENT @@@@ ###
                 */
                DB::alteration_message('Creating new ' . $className . ' with Title = <strong>' . $title . '</strong>', 'created');
            }

            /**
             * ### @@@@ START REPLACEMENT @@@@ ###
             * WHY: automated upgrade
             * OLD: $className (case sensitive)
             * NEW: $className (COMPLEX)
             * EXP: Check if the class name can still be used as such
             * ### @@@@ STOP REPLACEMENT @@@@ ###
             */
            $obj = $className::create();
        } else {
            if ($showDBAlterationMessage) {

                /**
                 * ### @@@@ START REPLACEMENT @@@@ ###
                 * WHY: automated upgrade
                 * OLD: $className (case sensitive)
                 * NEW: $className (COMPLEX)
                 * EXP: Check if the class name can still be used as such
                 * ### @@@@ STOP REPLACEMENT @@@@ ###
                 */
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
