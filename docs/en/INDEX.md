# Usage

```php


use Sunnysideup\TitleDataObject\Model\TitleDataObject;

/**
 * use MyListEntry::find_or_make('Title');
 */
class MyListEntry extends TitleDataObject
{


}

```

OR

```php

use Sunnysideup\TitleDataObject\Traits\FindOrCreate;

class TopicPage extends Page
{
    use FindOrCreate;
}

```
