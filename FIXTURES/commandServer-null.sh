#!/bin/bash

#@while ! timeout 1 bash -c "echo > /dev/tcp/localhost/3306"; do sleep 10; done

until $(curl --output /dev/null --silent --head --fail http://localhost:3306); do
    printf '.'
    sleep 5
done