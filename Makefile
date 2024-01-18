.PHONY: build
build:
	$(MAKE) -C app build
	$(MAKE) -C db build

up: build
	docker compose up