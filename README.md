# nbp-recruitment-task
This repository contains my recruitment task:

##Task assumptions
Write a service that provides the calculated average buy rate based on data from the National Bank of
Poland. The data downloaded from the NBP are: buy rate. Upload the code to a repository. The task
should be done in PHP.

Endpoint

GET /{currency}/{startDate}/{endDate}/

● Supported currencies: USD, EUR, CHF, GBP
● startDate, endDate: format RRRR-MM-YY

information and tips
● information and necessary tips to download data from the NBP on the website:
○ http://www.nbp.pl/home.aspx?f=/kursy/instrukcja_pobierania_kursow_walut.html
○ http://api.nbp.pl/
● start and end date rates are also to be taken into account

Example
GET /EUR/2013-01-28/2013-01-31/
Response:
{
“average_price”: 4,1505
}

##Installation
Clone the repository to a folder.
Change current directory to nbp_recruitment-task
Install Symfony
```bash
composer install
```
Run Symfony server
```bash
symfony server:start
```

Create/open a sample request:
```bash
http://127.0.0.1:8000/CHF/2023-02-01/2023-02-09
```

