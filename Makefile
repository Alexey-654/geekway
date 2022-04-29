bash:
	docker exec -t -i php-geekway /bin/bash
t:
	docker exec -t -i php-geekway /bin/bash

#migration
#php bin/console d:m:m

#fixture
#php bin/console doctrine:fixtures:load

#encore
#npm install
#npm run watch
#npm run build