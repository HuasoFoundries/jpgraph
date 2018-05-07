VERSION = $(shell cat composer.json | sed -n 's/.*"version": "\([^"]*\)",/\1/p')

SHELL = /usr/bin/env bash

default: clean
.PHONY: version install test tag start csfixer

version:
	@echo $(VERSION)



install:
	composer install --no-dev

test:
	php vendor/bin/codecept run

update_version:
	@echo "Current version is " ${VERSION}
	@echo "Next version is " $(v)
	@sed -i s/'"$(VERSION)"'/'"$(v)"'/ composer.json
	@sed -i s/'"$(VERSION)"'/'"$(v)"'/ README.md
	composer update nothing --lock --root-reqs

tag_and_push:
		git add --all
		git commit -a -m "Tag v $(v) $(m)"
		git tag v$(v)
		git push
		git push --tags

tag: csfixer update_version tag_and_push	

delete_tag:
	git tag -d $(v)
	git push origin :refs/tags/$(v)

start:
	php -S localhost:8000

csfixer:
	./vendor/bin/php-cs-fixer --verbose fix	
