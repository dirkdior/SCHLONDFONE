# SCHLONDFONE
> v1 for SCHLONDFONE api to register students who receive subject notes on a periodic basis.

## Components

### alegehUSSD.php
API endpoint for SCHLONDFONE USSD service running with Africa's Talking. 
Allows users signup and get subscibed to a subject.

### alegehMain.php
Main script containing functions used across the application.

### alegehEnums.php
Containing abstract class to standardize subjects across application, much like an enums.

### alegehCron.php
Script to be run via a cronjob, to send messages to subscibers on a Mon-Fri basis around 9AM.

### alegehSignups.php
Allows signups to be viewed on a webpage via a simple echo from the file where the signups are saved.

#### Note
v1 of this application persists data into files instead of a database.

Here is what the file system looks like:
```
    -.
    -alegeh/
        -config/
        -data/
```