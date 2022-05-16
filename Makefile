t:
	docker exec -t -i php-geekway /bin/bash

#db
# php bin/console d:m:m
#
# php bin/console doctrine:schema:drop --force
# php bin/console doctrine:schema:create
#
# php bin/console doctrine:fixtures:load

# execute particular migration
# php bin/console doctrine:migrations:execute --down 'DoctrineMigrations\Version20211025202345'

#debug
# php bin/console debug:autowiring --all

#encore
#npm install
#npm run watch
#npm run build