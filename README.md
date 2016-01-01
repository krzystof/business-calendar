## business-calendar
<!-- [![Latest Stable Version](https://poser.pugx.org/krzystof/business-calendar/v/stable)](https://packagist.org/packages/krzystof/business-calendar) -->
[![Latest Unstable Version](https://poser.pugx.org/krzystof/business-calendar/v/unstable)](https://packagist.org/packages/krzystof/business-calendar)
[![Build Status](https://travis-ci.org/krzystof/business-calendar.svg)](https://travis-ci.org/krzystof/business-calendar)
[![StyleCI](https://styleci.io/repos/45024706/shield)](https://styleci.io/repos/45024706)
[![Total Downloads](https://poser.pugx.org/krzystof/business-calendar/downloads)](https://packagist.org/packages/krzystof/business-calendar)

Manage a business calendar with a working week, openings and events.

**THIS IS NOT A STABLE PACKAGE AND SHOULD NOT BE USED IN PRODUCTION**

### API

#### Calendar
**In progress**

<!-- ```php
$calendar = new Calendar($workingWeek, $events, $timezone);

$scheduledTask = $calendar->schedule($task);

$scheduledTask->beginning();
$scheduledTask->end();

``` -->

#### Working Week
```php
$workingWeek->addOpening(new Opening([
    'day' => Carbon::MONDAY, 'time' => '06:00', 'length' => 12 * 3600
]));
$workingWeek->addOpening($opening2);

$workingWeek->countOpenings();           // returns the count of the openings
$workingWeek->isOpenAt(Carbon::now());   // returns bool
$workingWeek->workingHours();            // returns the sum of the working hours of the openings
```
<!-- r using a parser included: **This is currently in development**
```php
$workingWeek->addOpenings(FrenchOpeningParser::parse('le lundi de 8h a 18h'));
$workingWeek->addOpenings(EnglishOpeningParser::parse('from Monday to Friday, 9 to 5'));
```
The parsers returns an OpeningCollection, which can also be used when creating a new workingWeek:
```php
$ww = new WorkingWeek(FrenchOpeningParser::parse('lun mar mer 7-16'));-->

#### Opening
```php
$opening->opensAt();  // Return a Carbon instance
$opening->closesAt(); // Return a Carbon instance

// Check wether the two Openings overlaps:
$opening1->overlaps($opening2); // returns bool
// Merge them:
$opening1->merge($opening2);

// Get the day value to instantiate an opening
Opening::dayOfWeek('monday') // returns 1
```

### Events
In progress

### Task
In progress

### BusinessTime
A couple of helpers to work with time and dates.
```php
BusinessTime::dayFromString('Friday');  // returns 5
BusinessTime::dayToString(0);           // returns 'Sunday'
BusinessTime::hoursToSeconds(2);        // returns 7200
BusinessTime::secondsToHours(3600)      // returns 1
```
