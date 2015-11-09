# business-calendar
Manage a business calendar with a working week, openings and events.

## Opening
```php
$opening->opensAt();  // Return a Carbon instance
$opening->closesAt(); // Return a Carbon instance

// Check wether the two Openings overlaps:
$opening1->overlaps($opening2);
```

## Working week
```php
$workingWeek->addOpening($opening1);
$workingWeek->addOpening($opening2);
$workingWeek->countOpenings();          // -> returns 2
$workingWeek->isOpenAt(Carbon::now())   // -> returns bool
```

## Calendar
In progress

## Events
In progress
