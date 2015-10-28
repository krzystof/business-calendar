# business-calendar
Manage a business calendar with working hours and events.

## Opening
```php
<?php
$opening->openAt(); // Return a Carbon instance
$opening->closesAt(); // Return a Carbon instance
```
---
## Working week
```php
$workingWeek->addOpening($opening);
$workingWeek->countOpenings();
```
---
## Calendar
---

