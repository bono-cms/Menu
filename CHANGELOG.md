CHANGELOG
=========

1.3
---

 * Added Bootstrap4 menu generator
 * Added `truncate category` action button
 * Don't show expand/collapse buttons and parent dropdown if category depth is less or equals one
 * Added optional font-icon support
 * In regular `Dropdown` renderer added extra option to override item class
 * In regular `Dropdown` renderer added extra option to override inner UL class
 * Categories are no longer filtered by language ID
 * Removed internal `LinkBuilder` service
 * Improved the way of fetching records. Since now additional database queries won't be executed in iteration
 * Fixed issue with quote escaping
 * Fixed issue with ability to edit main UL class in `\Menu\View\BootstrapDropdown`
 * Changed color of items. They are now black
 * Fixed binding issue with item removals
 * Added `rel = "noopener noreferrer"` attribute for links to be opened in new window
 * Made `active` class configurable. It defaults to `active`, but can be overridden in configuration array
 * Dropped reading rendering from configuration array. Since now an instance of renderer must be passed as a third argument explicitly.
 * Added support for table prefix
 * Updated module icon
 * Improved internal structure

1.2
---

 * Improved internals

1.1
---

 * Added "choosen" plugin. Since now, page links cab be searched
 * Added an option "Open in new window". Now an item can be opened in new window on clicking on a site
 * Since now a name of an item can be empty when creating. In that case it would be taken from a title automatically

1.0
---

 * First public version