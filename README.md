
## Run Locally

Go to the Xampp/htdocs folder and create the ecommerce folder


Clone the project

```bash
  git clone git@github.com/huy008/E-commerce-Laravel
```

Go to the project directory

```bash
  cd ecommerce
```

Start the server

```bash
  php artisan serve
```

## Environment Variables

To run this project, you will need to add the following environment variables to your .env file


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=


#### Login

```http://localhost/ecommerce/ecommerce/public/admin
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `password`      | `string` | **Required**. Id of item to fetch |
| `email`      | `string` | **Required**. Id of item to fetch |


#### VD
```http
{
    "password":"123",
    "email":"quanghuy@gmail.com"
}
```
