# MiniTasks

## Egyszerű feladatkezelő

Fejlesztő: [pphome2](https:/github.com/pphome2)

**Aktuális verzió: 2020.**
**Első megjelenés: 2018.**

A program feladatokat tárol és kezel.

Elsődlegesen megrendeléseket tárolt: egy régi program egszerűsített változata lett,
ami web-es felületen fut, így a lokális gépen semmilyen telepítés, módosítás szükségtelen.

Később változott az igény, így feladatokat kezelünk vele.

Egyszerű:
- nem szükséges CMS a működéshez
- nincs külön felhasználókezelés, két felasználó jelszót tárol a `config` fájlban
- nem kell telepíteni
- nem használ SQL adatbázist
- nem használ cookie-kat


### Telepítés

- felmásolni az összes fájlt a webserver megfelelő könyvtárába
- írási jog kell a `tasks` könyvtárra
- `config` könyvtár `config.php` fájlátnézése, a beállítások itt taláhatók
- `config` könyvtárban találhatók a nyelvi fájlok, ha szükséges a módosítható
- a táblázat fejrésze a `tasks\schema` fájlban található




## One page tasks manager

Developer: [pphome2](https:/github.com/pphome2)

**Original release: 2018.**

**Last version: 2020.**

Mini task manager in one webpage.

Mini:
- No need CMS, only use it.
- No user managment, only one passcode in config file.
- No need install, only copy to folder, and add rights for web users.
- No cookie, no SQL database.

All data is stored in the "tasks" directory. Here is the "schema" 
file that contains fields in the spreadsheet (separated by 
the "|" character). Before the name of the field is "#", you can 
filter it in the field.

When archiving, a new file is created based on the date, which 
can be opened but can not be edited.

All displayed messages are in the "config.php" file, you just 
have to change it to that language ...
