#! /bin/sh

# Output colors
GREEN=$(tput setaf 2)
NORMAL=$(tput sgr0)
RED=$(tput setaf 1)

# Check params
if [ -z "$1" ]
then
    echo "${RED}Given name required${NORMAL}";
fi

if [ -z "$2" ]
then
    echo "${RED}Family name required${NORMAL}";
fi

if [ -z "$3" ]
then
    echo "${RED}Email required${NORMAL}";
fi

if [ -z "$4" ]
then
    echo "${RED}Password required${NORMAL}";
fi

# Api call
curl -X POST http://localhost:8080/users -H 'Content-Type: application/json' -d '{"givenName": "'"$1"'", "familyName": "'"$2"'", "email": "'"$3"'", "birthDate": null, "password": "'"$4"'"}'
