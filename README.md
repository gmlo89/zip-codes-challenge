# Challenge: Mexican postal codes API

This API provide information of mexican zip codes like: federal entity, settlements, municipality and locality name.

## End Point
`GET /api/zip-codes/{zip-code}`

## Instalation
1 - Clone this repository
2 - Configure the .env file (You can copy and edit the .env.example file)
3 - Run this commands:
```sh
cd zipcodes
composer install
php artisan migrate
php artisan zip-codes:start
```

## Request Example
`GET /api/zip-codes/01210`

## Response Example
```json
{
  "zip_code": "01210",
  "locality": "CIUDAD DE MÉXICO",
  "federal_entity": {
    "key": 9,
    "name": "CIUDAD DE MÉXICO",
    "code": null
  },
  "settlements": [
    {
      "key": 82,
      "name": "SANTA FE",
      "zone_type": "URBANO",
      "settlement_type": {
        "name": "Pueblo"
      }
    }
  ],
  "municipality": {
    "key": 10,
    "name": "ÁLVARO OBREGÓN"
  }
}
```


## Testing
```sh
php artisan test
```

## How its work

The information to serve the API was downloaded from the Mexican Postal Service Official Web Page (https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx).