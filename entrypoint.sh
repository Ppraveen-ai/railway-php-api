#!/bin/bash
# Replace Apache's port with Railway's $PORT at runtime
echo "Listen ${PORT}" > /etc/apache2/ports.conf
exec apache2-foreground
