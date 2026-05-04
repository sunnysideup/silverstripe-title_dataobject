# Upgrade to SilverStripe 6

This document outlines the changes required to upgrade this module from SilverStripe 4/5 to SilverStripe 6.

---

## Dependencies

⚠️ **BREAKING CHANGE**

**Update framework version requirement** in `composer.json:25`
- Change: `"silverstripe/framework": "^4.0 || ^5.0"` → `"silverstripe/framework": "^6.0"`
- Run `composer update` after making this change

---

## Configuration Changes

⚠️ **BREAKING CHANGE**

**Replace deprecated `DatabaseAdmin` class** in `_config/database.legacy.yml:6-14`

- Old: `SilverStripe\ORM\DatabaseAdmin`
- New: `SilverStripe\Dev\DbBuild`
- Why: `DatabaseAdmin` was removed in SilverStripe 6
- Reference: https://docs.silverstripe.org/en/6/changelogs/6.0.0/

The `classname_value_remapping` configuration remains unchanged but is now under the new class namespace.

---

## Code Updates

**Add `#[Override]` attribute to `validate()` method** in `src/Model/TitleDataObject.php:46`

- Add `use Override;` statement at the top of the file (`src/Model/TitleDataObject.php:38`)
- Apply `#[Override]` attribute to the `validate()` method
- This is a PHP 8.3+ attribute that explicitly marks method overrides
- Not breaking, but recommended for better IDE support and type safety
