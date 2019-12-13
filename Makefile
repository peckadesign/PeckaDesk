.PHONY: cs
.PHONY: phpstan


cs:
	vendor/bin/phpcs app/ tests/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandardStrict/ruleset.xml
	vendor/bin/phpcs app/ tests/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandard/ruleset.xml


phpstan:
	vendor/bin/phpstan analyse --level=7 app/
