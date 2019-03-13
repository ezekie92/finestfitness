#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE finestfitness_test;"
    psql -U postgres -c "CREATE USER finestfitness PASSWORD 'finestfitness' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists finestfitness
    sudo -u postgres dropdb --if-exists finestfitness_test
    sudo -u postgres dropuser --if-exists finestfitness
    sudo -u postgres psql -c "CREATE USER finestfitness PASSWORD 'finestfitness' SUPERUSER;"
    sudo -u postgres createdb -O finestfitness finestfitness
    sudo -u postgres psql -d finestfitness -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O finestfitness finestfitness_test
    sudo -u postgres psql -d finestfitness_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:finestfitness:finestfitness"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
