<?php


class TitleDataObject extends DataObject {

    private static $indexes = array(
        'Title' => 'unique("Title, ClassName")'
    );

    private static $searchable_fields = array(
        'Title' => 'PartialMatchFilter'
    );

    private static $default_sort = array(
        'Title' => "ASC"
    );

    private static $db = array(
        'Title' => 'Varchar(255)',
    );

    /**
     * to prevent racing conditions ...
     *
     * @var array
     */
    private static $_cache = array();

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
        $titleToLower = strtolower(($title));
        $className = get_called_class();
        $key = $className.'_'.$titleToLower;
        if(isset(self::$_cache[$key])) {
            if($showDBAlterationMessage) {
                DB::alteration_message('Found '.$className.' with Title = <strong>'.$title.'</strong>');
            }
            return self::$_cache[$key];
        }

        if( ! $title) {
            return $className::create();
        }
        $obj = $className::get()->where('LOWER("Title") =\''.Convert::raw2sql($titleToLower).'\'');

        if($obj->count() == 0) {
            if($showDBAlterationMessage) {
                DB::alteration_message('Creating new '.$className.' with Title = <strong>'.$title.'</strong>', 'created');
            }
            $obj = $className::create();
        } else {
            if($showDBAlterationMessage) {
                DB::alteration_message('Found '.$className.' with Title = <strong>'.$title.'</strong>');
            }
            $obj = $obj->first();
        }
        $obj->Title = $title;
        self::$_cache[$key] = $obj;
        $obj->write();

        return $obj;
    }

}
