.PHONY: deploy install
PHP=/usr/bin/php8.4-cli
COMPOSER=/kunden/homepages/23/d4298669514/htdocs/bin/composer

deploy: public/build/manifest.json
	rsync -avz public/build hyeresentreprendre:~/www/v1/public
	ssh -A hyeresentreprendre 'cd ~/www/v1 && git pull origin main && make install'

install: vendor/autoload.php .env public/storage
	$(PHP) artisan cache:clear
	$(PHP) artisan filament:optimize
	$(PHP) artisan optimize
	$(PHP) artisan migrate --force

.env:
	cp .env.example
	$(PHP) artisan key:generate

public/storage:
	$(PHP) artisan storage:link

vendor/autoload.php: composer.lock
	$(PHP) $(COMPOSER) install
	touch vendor/autoload.php

public/build/manifest.json: package.json
	npm install
	npm run build
