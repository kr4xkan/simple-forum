#!/bin/bash
RED="\033[31m"
BLUE="\033[94m"
ENDCOLOR="\033[0m"

if ! [ -x "$(command -v docker)" ]; then
    echo -e "${RED}[-] Docker is not installed${ENDCOLOR}" >&2
    exit 1
fi
echo -e "${BLUE}[+] Docker is installed${ENDCOLOR}"

echo -e "${BLUE}[-] Building containers${ENDCOLOR}"
docker compose build
if [ $? -ne 0 ]; then
    echo -e "${RED}[-] Failed to build containers${ENDCOLOR}" >&2
    exit $?
fi
echo -e "${BLUE}[+] Containers built${ENDCOLOR}"

echo -e "${BLUE}[-] Starting containers${ENDCOLOR}"
docker compose up -d
if [ $? -ne 0 ]; then
    echo -e "${RED}[-] Failed to start containers${ENDCOLOR}" >&2
    exit $?
fi
echo -e "${BLUE}[+] Containers started${ENDCOLOR}"