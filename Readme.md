create/update entity
```bash
php bin/console make:entity
```

execute particular migration
```bash
php bin/console doctrine:migrations:execute --down 'DoctrineMigrations\Version20211025202345'
```

load fixtures
```bash
php bin/console doctrine:fixtures:load
```