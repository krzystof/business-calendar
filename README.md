# business-calendar
Manage a business calendar with a working week, openings and events.

## API

#### Adding Opening to a Working Week
```php
$workingWeek->addOpening($opening1);
$workingWeek->addOpening($opening2);
$workingWeek->countOpenings();          // -> returns 2
$workingWeek->isOpenAt(Carbon::now())   // -> returns bool
```
Or using a parser included:
```php
$workingWeek->addOpenings(FrenchOpeningParser::parse('le lundi de 8h a 18h'));
$workingWeek->addOpenings(EnglishOpeningParser::parse('from Monday to Friday, 9 to 5'));
```
The parsers returns an OpeningCollection, which can also be used when creating a new workingWeek:
```php
$ww = new WorkingWeek(FrenchOpeningParser::parse('lun mar mer 7-16'));

## Opening
```php
$opening->opensAt();  // Return a Carbon instance
$opening->closesAt(); // Return a Carbon instance

// Check wether the two Openings overlaps:
$opening1->overlaps($opening2);
```

## Calendar
In progress

## Events
In progress
