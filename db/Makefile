mysql-data: 
	mkdir -p mysql-data

.make: Dockerfile migration.sql
	docker build -t socialnetwork-db .
	touch .make

build: .make

shell: build store
	docker run -it --rm socialnetwork-db /bin/bash

run: build store
	docker run -d --name socialnetwork-dbd -e MYSQL_ROOT_PASSWORD=doNotUseInProd socialnetwork-db

rm:
	docker stop socialnetwork-dbd && \
	docker rm socialnetwork-dbd

rmi: rm
	docker rmi socialnetwork-db
	@rm -f .make

