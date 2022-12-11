#!/usr/bin/env bash

source variables

readonly grn='\033[0;32m'
readonly red='\033[0;31m'
readonly nc='\033[0m'

readonly thisScript="$0"

printUsageAndExit() {
  echo -e \
    "Usage: ${grn}$thisScript${nc} <command> <args...>

Where:
  ${grn}<command>${nc}  - command to execute; e.g: start, psql, composer, console
  ${grn}<args...>${nc}  - command arguments

Commands:
  ${grn}start${nc}                         - starts dev environment
  ${grn}migrate${nc} <prod|test>           - migrates db, default: 'prod'
  ${grn}bash${nc}                          - bash console for rating docker
  ${grn}psql${nc}                          - psql console
  ${grn}soap${nc} <args...>                - runs soap (use any soap command)
  ${grn}composer${nc} <args...>            - runs composer (use any composer command)
  ${grn}console${nc} <args...>             - runs console
"
  exit 1
}

soap() {
  docker exec --user "$(id -u "${USER}")" -it "${SERVICE_DOCKER}" php "/var/www/html/soap-rest-performance-comparison/API/SOAP/$@"
}

composer() {
  docker exec --user "$(id -u "${USER}")" -it "${SERVICE_DOCKER}" /var/www/html/soap-rest-performance-comparison/composer.phar --working-dir=/var/www/soap-rest-performance-comparison "$@"
}

console() {
  docker exec --user "$(id -u "${USER}")" -it "${SERVICE_DOCKER}" /var/www/html/soap-rest-performance-comparison/console "$@"
}

migrate() {
  console migration:run --force "$@"
}

if [[ "$#" == 0 ]]; then
  printUsageAndExit
fi

readonly command=$1
shift 1

case "${command}" in
start)
  docker-compose up -d

#  composer install
#
#  migrate
#  migrate --db_name="${TEST_DB_NAME}"
  ;;
migrate)
  config=$1
  shift 1

  if [[ $config == 'test' ]]; then
    migrate --db_name="${TEST_DB_NAME}"
  else
    migrate
  fi
  ;;
bash)
  docker exec -it "${SERVICE_DOCKER}" bash
  ;;
psql)
  docker exec -it "${DB_DOCKER}" psql "${PROD_DB_NAME}" "${DB_USER}"
  ;;
composer)
  composer "$@"
  ;;
soap)
  soap "$@"
  ;;
console)
  console "$@"
  ;;
*)
  echo -e "Unknown command ${red}${command}${nc}."
  echo
  printUsageAndExit
  ;;
esac
