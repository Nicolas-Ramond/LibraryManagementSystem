#!/bin/bash

printf 'Waiting for docker to come up'

while netstat -lnt | awk '$4 ~ /:3306$/ {exit 1}'; do
    printf '.'
    sleep 1
done

printf 'done.\n'
