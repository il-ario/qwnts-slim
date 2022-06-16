## FYI

### Built with Slim

URL example: http://localhost:8080/users

- docker-compose.yml for PHP, MySQL, nginx
- MySQL dummy data via docker-entrypoint-initdb.d
- API: routes to actions, sort, search
- Database: MySQL connection in DI Container, *user:create* shell command with composer
- No JWT auth

**Steps**

1. Clone repo
2. docker-compose up --build
3. composer user:create <params...>
