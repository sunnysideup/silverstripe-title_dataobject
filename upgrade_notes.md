2020-05-29 05:33

# running php upgrade upgrade see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/upgradeto4
php /var/www/upgrader/vendor/silverstripe/upgrader/bin/upgrade-code upgrade /var/www/upgrades/upgradeto4/title_dataobject  --root-dir=/var/www/upgrades/upgradeto4 --write -vvv
Writing changes for 2 files
Running upgrades on "/var/www/upgrades/upgradeto4/title_dataobject"
[2020-05-29 17:33:29] Applying RenameClasses to TitleDataobjectTest.php...
[2020-05-29 17:33:29] Applying ClassToTraitRule to TitleDataobjectTest.php...
[2020-05-29 17:33:29] Applying RenameClasses to TitleDataObject.php...
[2020-05-29 17:33:29] Applying ClassToTraitRule to TitleDataObject.php...
[2020-05-29 17:33:29] Applying RenameClasses to _config.php...
[2020-05-29 17:33:29] Applying ClassToTraitRule to _config.php...
modified:	tests/TitleDataobjectTest.php
@@ -1,4 +1,6 @@
 <?php
+
+use SilverStripe\Dev\SapphireTest;

 class TitleDataobjectTest extends SapphireTest
 {

modified:	src/Model/TitleDataObject.php
@@ -2,9 +2,13 @@

 namespace Sunnysideup\TitleDataObject\Model;

-use DataObject;
-use DB;
-use Convert;
+
+
+
+use SilverStripe\ORM\DB;
+use SilverStripe\Core\Convert;
+use SilverStripe\ORM\DataObject;
+




Warnings for src/Model/TitleDataObject.php:
 - src/Model/TitleDataObject.php:116 PhpParser\Node\Expr\Variable
 - WARNING: New class instantiated by a dynamic value on line 116

 - src/Model/TitleDataObject.php:127 PhpParser\Node\Expr\Variable
 - WARNING: New class instantiated by a dynamic value on line 127

 - src/Model/TitleDataObject.php:151 PhpParser\Node\Expr\Variable
 - WARNING: New class instantiated by a dynamic value on line 151

Writing changes for 2 files
✔✔✔