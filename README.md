# 1. Start the container

You can start the container by typing following into your local shell:

```bash
❯ cd /path/your/project/framework_php/docker 
❯ docker-compose up
```
Then you can enter the php container

```bash
❯ docker exec -it -u dev framework_php bash
❯ cd framework_php
❯ composer install
```

# 2. Start web server

You can start the web server by typing following into your local shell
```bash
❯ cd /path/your/project/framework_php
❯ symfony server:start --port=4321 --passthru=front.php
```

You can execute the controllers by typing following into your web browser
```
http://localhost:4321/hello/Joe
```
