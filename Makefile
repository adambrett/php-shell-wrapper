# Variables
SHELL := /bin/bash -o errexit -o nounset -o pipefail

MAKEFLAGS += --warn-undefined-variables
MAKEFLAGS += --no-builtin-rules

VERBOSE ?= false
ifeq (${VERBOSE}, false)
	# --silent drops the need to prepend `@` to suppress command output
	MAKEFLAGS += --silent
endif

UID := $(shell id -u)
GID := $(shell id -g)

## Applications
COMPOSER ?= composer

PHPLOC  ?= vendor/bin/phploc
PHPMD   ?= vendor/bin/phpmd
PHPCS   ?= vendor/bin/phpcs
PHPCPD  ?= vendor/bin/phpcpd
PHPUNIT ?= vendor/bin/phpunit

# Helpers
.PHONY: all ## clean and depend
all: clean depend

# Dependencies
.PHONY: depend
depend: vendor ## install dependencies

vendor: composer.json composer.lock ## download composer dependencies
	${COMPOSER} install --no-progress --prefer-source
	touch vendor

# QA
.PHONY: qa ## run quality assurance tools
qa: lint phpmd phpcs phpcpd

.PHONY: lint
lint: ## syntax linting
	find ./src -name "*.php" -exec /usr/bin/env php -l {} \; | grep "Parse error" > /dev/null && exit 1 || exit 0
	find ./tests -name "*.php" -exec /usr/bin/env php -l {} \; | grep "Parse error" > /dev/null && exit 1 || exit 0

.PHONY: phploc
phploc: ## output lines of code stats
	${PHPLOC} src

.PHONY: phpmd
phpmd: ## run mess detector (static analysis)
	${PHPMD} --suffixes php src/ text codesize,design,naming,unusedcode,controversial

.PHONY: phpcs
phpcs: ## run codesniffer (formatting check)
	${PHPCS} --standard=PSR12 --extensions=php src/ tests/

.PHONY: phpcpd
phpcpd: ## run copy-paste detector
	${PHPCPD} src/

# Testing
.PHONY: test
test: ## run tests
	${PHPUNIT} -v --colors --coverage-text

# Cleaning
.PHONY: clean
clean: clean-vendor ## clean build artifacts

.PHONY: clean-vendor
clean-vendor: ## remove the vendor directory
	rm -rf vendor

.PHONY: clean-all
clean-all: clean ## reset the project to a totally clean state

# Make
print-% :
	echo $* = $($*)

help:
	grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: help

.DELETE_ON_ERROR:
