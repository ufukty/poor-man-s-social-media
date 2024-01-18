store: 
	mkdir -p store{,posts,avatar}

.make: Dockerfile
	docker build -t socialnetwork-app .
	@touch .make

build: .make

.PHONY: shell run rm rmi
 
shell: build store
	docker run -it --rm socialnetwork-app /bin/bash

run: build store
	docker run -d -p 8080:80 --name socialnetwork-appd socialnetwork-app

rm:
	docker stop socialnetwork-appd
	docker rm socialnetwork-appd

rmi: rm
	docker rmi socialnetwork-app
	@rm -f .make

