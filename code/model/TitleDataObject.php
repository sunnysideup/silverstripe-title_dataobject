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
     * see README.md for usage ...
     * 
     * @param string $title
     * @return DataObject
     */ 
    public static function find_or_create($title, $dbMessage = false)
    {
        $title = trim($title);
        $className = get_called_class();
        if( ! $title) {
            return $className::create();
        }
        $obj = $className::get()->where('LOWER("Title") =\''.Convert::raw2sql(strtolower($title)).'\'');

        if($obj->count() == 0) {
            if($dbMessage) {
                DB::alteration_message('Creating new '.$className.' with Title = <strong>'.$title.'</strong>', 'created');
            }
            $obj = $className::create();
        } else {
            DB::alteration_message('Found '.$className.' with Title = <strong>'.$title.'</strong>');
            $obj = $obj->first();
        }
        $obj->Title = $title;
        $obj->write();

        return $obj;
    }

}
