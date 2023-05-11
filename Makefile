CURRENT_DIRECTORY := $(shell pwd)

TESTSCOPE = apps
TESTFLAGS = --with-timer --timer-top-n 10 --keepdb
TEST_FLAG = TRUE


cyan = /bin/echo -e "\x1b[36m\#\# $1\x1b[0m"

export COMPOSE_INTERACTIVE_NO_CLI=1


help:

	@echo "Docker procedure"
	@echo "-----------------------"
	@echo ""
	@echo "Run All containers:"
	@echo "    make start"
	@echo ""
	@echo "Run fixtures to create & populate bdd library:"
	@echo "    make fixtures"
	@echo ""
	@echo "Run stop for stopping and removing containers:"
	@echo "    make stop"
	@echo ""
	@echo "Run status for container status:"
	@echo "    make status"
	@echo ""

start:
	@$(call cyan, "We will check and remove all containers and volumes")
	@docker-compose stop && docker-compose rm -f
	@$(call cyan, "And start all containers")
	@xterm -e docker-compose up --build &

stop:
	@$(call cyan, "We will check and remove all containers and volumes")
	@docker-compose stop && docker-compose rm -f

status:
	@docker-compose ps


fixtures:


	@echo "    .____    ._____.                                "
	@echo "    |    |   |__\_ |______________ _______ ___.__.  "
	@echo "    |    |   |  || __ \_  __ \__  \\_  __ <   |  |  "
	@echo "    |    |___|  || \_\ \  | \// __ \|  | \/\___  |  "
	@echo "    |_______ \__||___  /__|  (____  /__|   / ____|  "
	@echo "            \/       \/           \/       \/       "
	@echo "   _____          __           _____.__.__          "
	@echo "  /     \ _____  |  | __ _____/ ____\__|  |   ____  "
	@echo " /  \ /  \\__  \ |  |/ // __ \   __\|  |  | _/ __ \ "
	@echo "/    Y    \/ __ \|    <\  ___/|  |  |  |  |_\  ___/ "
	@echo "\____|__  (____  /__|_ \\___  >__|  |__|____/\___  >"
	@echo "        \/     \/     \/    \/                   \/ "


	@$(call cyan, "Step 1: We will check and remove all containers and volumes")
	@docker-compose stop && docker-compose rm -f

	@$(call cyan, "Step 2: We will open a terminal an launch docker procedure")
	@xterm -e docker-compose up --build &
	@./FIXTURES/commandServer1.sh

	@$(call cyan, "Step 3: We will drop the database library if already in base")
	@sleep 15
	@./FIXTURES/commandServer2.sh

	@$(call cyan, "Step 4: We will create the database library")
	@sleep 15
	@docker-compose exec php php /usr/local/apache2/htdocs/bin/console doctrine:database:create

	@$(call cyan, "Step 5: We will create all tables")
	@rm -rf src/Migrations/*
	@docker-compose exec php php /usr/local/apache2/htdocs/bin/console doctrine:migration:diff
	@./FIXTURES/commandServer3.sh

	@$(call cyan, "Final Step: Launching the fixtures procedure")
	@./FIXTURES/commandServer4.sh


tail:
	@docker-compose logs -f

.PHONY: stop status fixtures tail