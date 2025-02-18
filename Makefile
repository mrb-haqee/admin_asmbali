serve:
	php artisan serve

reload:
	composer dump-autoload
	php artisan config:clear
	php artisan cache:clear

dev:
	composer install
	npm install --global yarn
	yarn
	npm run dev
	# cp .env.example
	php artisan key:generate
	php artisan migrate
	php artisan migrate:fresh --seed

mg:
	php artisan migrate

commit:
	git add .
	git commit -m "commit"
	git push origin main

ARTISAN = php artisan

lv:
	$(ARTISAN) make:livewire Menu

dt:
	$(ARTISAN) datatables:make Menu
