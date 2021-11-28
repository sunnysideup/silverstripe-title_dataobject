<?php

namespace Sunnysideup\TitleDataObject\Traits;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\DB;

use Sunnysideup\TitleDataObject\Model\TitleDataObject;

trait FindOrCreate
{
    /**
     * to prevent racing conditions ...
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * see README.md for usage ...
     *
     * @param bool $showDBAlterationMessage
     *
     * @return TitleDataObject
     */
    public static function find_or_create(string $title, ?bool $showDBAlterationMessage = false)
    {
        $title = trim($title);
        $titleToLower = strtolower($title);

        $className = static::class;
        $key = $className . '_' . $titleToLower;
        if (isset(self::$cache[$key])) {
            if ($showDBAlterationMessage) {
                DB::alteration_message('Found ' . $className . ' with Title = <strong>' . $title . '</strong>');
            }
            /** @return TitleDataObject */
            return self::$cache[$key];
        }

        if (! $title) {
            /** @return TitleDataObject */
            return $className::create();
        }

        /** @var TitleDataObject $obj  */
        $obj = $className::get()->where('LOWER("Title") =\'' . Convert::raw2sql($titleToLower) . '\'');

        if (! $obj->exists()) {
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
        self::$cache[$key] = $obj;
        $obj->write();

        return $obj;
    }
}
