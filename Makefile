.PHONY: build
.PHONY: cs
.PHONY: phpstan


build:
	#cd assets/coreui && npm install && npm run build
	cp -r assets/coreui/dist/assets www/assets
	cp -r assets/coreui/dist/css www/css
	cp -r assets/coreui/dist/js www/js
	cp -r assets/coreui/dist/vendors www/vendors


cs:
	vendor/bin/phpcs app/ tests/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandardStrict/ruleset.xml
	vendor/bin/phpcs app/ tests/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandard/ruleset.xml


phpstan:
	vendor/bin/phpstan analyse -c tests/phpstan.neon --level=7 app/
