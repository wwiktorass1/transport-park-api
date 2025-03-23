# 🚛 Transport Park API

**ENGLISH / LIETUVIŲ**

## 🇬🇧 English

Transport Park API is a Symfony-based Fleet Management System that allows management of trucks, trailers, drivers, and service orders.

### 🔧 Features
- FleetSet management (Trucks + Trailers + Drivers)
- Service orders
- RESTful API using API Platform
- OpenAPI (Swagger) documentation
- Dockerized environment
- Fixtures for test data
- PHPUnit tests
- Validation with Symfony Validator

### ▶️ Run the Project

1. Clone the repo:
```bash
git clone https://github.com/your-username/transport-park-api.git
cd transport-park-api
```

2. Start Docker containers:
```bash
docker compose up --build -d
```

3. Create and migrate databases:
```bash
docker compose exec php php bin/console doctrine:database:create
docker compose exec php php bin/console doctrine:migrations:migrate
docker compose exec php php bin/console doctrine:fixtures:load
```

4. Access the API:
- API: http://localhost:8000/api/fleets
- Docs: http://localhost:8000/api/docs

5. Run tests:
```bash
docker compose exec php php bin/phpunit
```

---

## 🇱🇹 Lietuviškai

Transport Park API – tai Symfony pagrindu sukurta transporto valdymo sistema, skirta vilkikų, priekabų, vairuotojų ir paslaugų užsakymų valdymui.

### 🔧 Funkcionalumas
- FleetSet valdymas (Vilkikas + Priekaba + Vairuotojai)
- Paslaugų užsakymai
- REST API su API Platform
- OpenAPI dokumentacija (Swagger)
- Docker aplinka
- Testiniai duomenys su Fixtures
- PHPUnit testai
- Validacija naudojant Symfony Validator

### ▶️ Projekto paleidimas

1. Nukopijuokite repozitoriją:
```bash
git clone https://github.com/your-username/transport-park-api.git
cd transport-park-api
```

2. Paleiskite Docker konteinerius:
```bash
docker compose up --build -d
```

3. Sukurkite ir migruokite duomenų bazes:
```bash
docker compose exec php php bin/console doctrine:database:create
docker compose exec php php bin/console doctrine:migrations:migrate
docker compose exec php php bin/console doctrine:fixtures:load
```

4. Pasiekite API:
- API: http://localhost:8000/api/fleets
- Dokumentacija: http://localhost:8000/api/docs

5. Paleiskite testus:
```bash
docker compose exec php php bin/phpunit
```

---

🛠 Developed using Symfony 6, API Platform, PostgreSQL, Docker, PHPUnit.
