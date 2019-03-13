#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U finestfitness -d finestfitness < $BASE_DIR/finestfitness.sql
fi
psql -h localhost -U finestfitness -d finestfitness_test < $BASE_DIR/finestfitness.sql
