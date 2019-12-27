VERSION = $(shell cat composer.json | sed -n 's/.*"version": "\([^"]*\)",/\1/p')

SHELL = /usr/bin/env bash

XDSWI := $(shell command -v xd_swi 2> /dev/null)
XDSWI_STATUS:=$(shell command xd_swi stat 2> /dev/null)
CURRENT_FOLDER:=$(shell command pwd 2> /dev/null)
HASPHPMD := $(shell command -v phpmd 2> /dev/null)
 YELLOW=\033[0;33m
RED=\033[0;31m
WHITE=\033[1m
RESET=\033[0m
GREEN=\u001B[32m

ifneq ($(g),)	
	groups=-g
endif
ifeq ($(target),)	
	target=src
endif
default: clean
.PHONY: version install test tag start csfixer

version:
	@echo $(VERSION)



install:
	composer install --no-dev

test:
	@if [[ "$(XDSWI)" != "" ]]; then \
		echo -e "$(WHITE)XDebug state is$(RESET) $(XDSWI_STATUS)" ;\
	fi ;\
	xd_swi off ;\
	php vendor/bin/codecept run unit $(test) $(groups) $(g) --debug ;\
	echo seting XDebug to initial state $(XDSWI_STATUS)  ;\
	xd_swi $(XDSWI_STATUS)

test_coverage:
	@if [[ "$(XDSWI)" != "" ]]; then \
		echo -e "$(WHITE)XDebug state is$(RESET) $(XDSWI_STATUS)" ;\
	fi ;\
	xd_swi on ;\
	php vendor/bin/codecept run unit $(test)     --coverage-html  ;\
	echo seting XDebug to initial state $(XDSWI_STATUS)  ;\
	xd_swi $(XDSWI_STATUS)

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

tag: test update_version csfixer tag_and_push	

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

phpmd:
	@if [ -f ./vendor/bin/phpmd ]; then \
	    ./vendor/bin/phpmd $(target) text .phpmd.xml |  sed "s/.*\///" ;\
    else \
        echo -e "$(GREEN)phpmd$(WHITE) is $(RED)NOT$(WHITE) installed. Install it with $(GREEN)composer require --dev phpmd/phpmd$(WHITE)" ;\
    fi ;\
    echo ""
	
psalm:
	@if [ -f ./vendor/bin/psalm ]; then \
		if [ -f ./vendor/bin/psalm ]; then \
			./vendor/bin/psalm --init $(target) 3 ;\
		fi ;\
	    ./vendor/bin/psalm $(target) ;\
    else \
        echo -e "$(GREEN)phpmd$(WHITE) is $(RED)NOT$(WHITE) installed. Install it with $(GREEN)composer require --dev vimeo/psalm$(WHITE)" ;\
    fi ;\


churn:
	@if [ -f ./vendor/bin/churn ]; then \
		vendor/bin/churn run $(target) -c .churn.yml ;\
    else \
        echo -e "$(GREEN)churn$(WHITE) is $(RED)NOT$(WHITE) installed. Install it with $(GREEN)composer require --dev bmitch/churn-php$(WHITE)" ;\
    fi ;\

phpcpd:
	@if [ -f ./vendor/bin/phpcpd ]; then \
		vendor/bin/phpcpd --fuzzy --ansi --log-pmd=.pmd.log $(target) ;\
    else \
        echo -e "$(GREEN)churn$(WHITE) is $(RED)NOT$(WHITE) installed. Install it with $(GREEN)composer require --dev sebastian/phpcpd$(WHITE)" ;\
    fi ;\