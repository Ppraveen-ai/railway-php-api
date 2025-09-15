#!/bin/bash
# Use Railway's dynamic $PORT at runtime
if [ -z "$PORT" ]; then
  echo "Error: PORT not set"
  exit 1
fi

# Rewrite Apache to listen on Railway's assigned port
echo "Listen ${PORT}" > /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

echo "Apache will listen on port ${PORT}"
exec apache2-foreground
