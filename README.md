# DonkeyAir

## GIT

To download the latest version of the project :
```
git clone git@github.com:Nels18/DonkeyAir.git
```
(you'll get a directory named DonkeyAir)


## CREATE DATABASE

Open your terminal and launch mysql server:
```
mysql -u root
```
To create the database :
```
CREATE DATABASE donkeyair;
```
```
USE donkeyair;
```

## IMPORT DATABASE

In your terminal, import datas using these commands:
```
SOURCE data/sql/database.sql
```
```
SOURCE data/sql/insert-data.sql
```

## LAUNCH WEBSITE

Open another window in your terminal and launch localhost :
```
php -S localhost:8000
```

## LOGIN TO SESSION

In your navigator's URL, type:
```
localhost:8000/login.php
```
In order to connect to the website use an existing mail/password from the database, use for example:

- Email: a.aliquet@outlook.ca

- Password field : SOH60ORU8VJ

Click on "Connexion"

## SEARCH FORM 

In order to get an available flight from the database, use for example:

- Ville de départ: MDW, Chicago Midway - United States

- Ville de destination: CZS, Cruzeiro Do Sul Campo Internacional - Brazil

Everything in other form fields can be accepted

Thank you for reading us and enjoy your flight with DonkeyAir Airline !
