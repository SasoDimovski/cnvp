#!/bin/bash

set -e
echo "In entrypoint.sh"
cd /var/www/
exec "$@"
