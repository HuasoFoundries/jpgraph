VERSION = $(shell cat composer.json | sed -n 's/.*"version": "\([^"]*\)",/\1/p')

SHELL = /usr/bin/env bash

XDSWI := $(shell command -v xd_swi 2> /dev/null)
HASPHPMD := $(shell command -v phpmd 2> /dev/null)

YELLOW=\033[0;33m
RED=\033[0;31m
WHITE=\033[0m
GREEN=\u001B[32m

ifneq ($(g),)	
	groups=-g
endif

default: clean
.PHONY: version install test tag start csfixer

version:
	@echo $(VERSION)



install:
	composer install --no-dev

test:
	php vendor/bin/codecept run unit $(test) $(groups) $(g) --debug

test_coverage:
	php vendor/bin/codecept run unit $(test)  -g ready --coverage --coverage-xml

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

tag: update_version csfixer tag_and_push	

delete_tag:
	git tag -d $(v)
	git push origin :refs/tags/$(v)

start:
	php -S localhost:8000 -t Examples

runcsfixer:
	@if [ -f ./vendor/bin/php-cs-fixer ]; then \
	    ./vendor/bin/php-cs-fixer --verbose fix ;\
    else \
        echo -e "$(GREEN)php-cs-fixer$(WHITE) is $(RED)NOT$(WHITE) installed. Install it with $(GREEN)composer require --dev friendsofphp/php-cs-fixer$(WHITE)" ;\
    fi 

csfixer:
	@if [[ "$(XDSWI)" == "" ]]; then \
	     ${MAKE} runcsfixer --no-print-directory ;\
    else \
        xd_swi off ;\
		${MAKE} runcsfixer --no-print-directory ;\
		xd_swi on	;\
    fi
	