php:
	docker exec -t -i php-geekway /bin/bash

run:
	docker ps -aq | xargs docker stop | xargs docker rm;
	docker compose up -d;
	docker exec -t -i php-geekway /bin/bash

clean:
	docker exec -t -i php-geekway /bin/bash;
	php
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

#remove all docker containers
#docker ps -aq | xargs docker stop | xargs docker rm