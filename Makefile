VERSION = $(shell cat composer.json | sed -n 's/.*"version": "\([^"]*\)",/\1/p')

SHELL = /usr/bin/env bash

XDSWI := $(shell command -v xd_swi 2> /dev/null)
XDSWI_STATUS:=$(shell command xd_swi stat 2> /dev/null)
CURRENT_FOLDER:=$(shell command pwd 2> /dev/null)
HAS_PHPMD := $(shell command -v phpmd 2> /dev/null)
HAS_CSFIXER:= $(shell command -v php-cs-fixer 2> /dev/null)
HAS_PSALM:=$(shell command -v psalm stat 2> /dev/null)
HAS_PHPCPD:=$(shell command -v phpcpd 2> /dev/null)
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
		@if [[ "$(HAS_CSFIXER)" == "" ]]; then \
        echo -e "$(GREEN)php-cs-fixer$(WHITE) is $(RED)NOT$(WHITE) installed. " ;\
        echo -e "Install it with $(GREEN)phive install php-cs-fixer$(WHITE)" ;\
    else \
	    php-cs-fixer --verbose fix --using-cache no;\
    fi 

csfixer:
	@if [[ "$(XDSWI)" == "" ]]; then \
	     ${MAKE} runcsfixer --no-print-directory ;\
    else \
        xd_swi off ;\
		${MAKE} runcsfixer --no-print-directory ;\
		xd_swi $(XDSWI_STATUS)	;\
    fi
	
phpmd:
	@if [ "$(HAS_PHPMD)" == "" ]; then \
        echo -e "$(GREEN)phpmd$(WHITE) is $(RED)NOT$(WHITE) installed. " ;\
        echo -e "Install it with $(GREEN)phive install phpmd$(WHITE)" ;\
    else \
	    phpmd src text .phpmd.xml |  sed "s/.*\///" ;\
    fi ;\
    echo ""
	

phpcpd:
	@if ["$(HAS_PHPCPD)" == "" ]; then \
        echo -e "$(GREEN)phpcpd$(WHITE) is $(RED)NOT$(WHITE) installed. Install it with $(GREEN)phive install phpcpd$(WHITE)" ;\
    else \
		phpcpd --fuzzy --ansi --log-pmd=.pmd.log $(target) ;\
    fi ;\
    echo ""