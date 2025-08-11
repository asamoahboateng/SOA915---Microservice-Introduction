#!/bin/bash

# List of your 4 target folders
FOLDERS=("app-queue" "nginx-proxy" "user-staff-manage" "main-website" "email-notification" "invoice-service" "nail-services-booking")

# Define the docker-compose command (can change to 'docker compose' if you're using v2 syntax)
DOCKER_COMPOSE_COMMAND="docker-compose up -d"

# Loop through each folder
for dir in "${FOLDERS[@]}"; do
  echo "🔍 Checking $dir..."

  # Check if docker-compose.yml exists in the root of the folder
  if [ -f "$dir/docker-compose.yml" ]; then
    echo "✅ Found docker-compose.yml in $dir"
    (cd "$dir" && $DOCKER_COMPOSE_COMMAND)

  # Check if docker-compose.yml exists in a subfolder named 'docker'
  elif [ -f "$dir/docker/docker-compose.yml" ]; then
    echo "✅ Found docker-compose.yml in $dir/docker"
    (cd "$dir/docker" && $DOCKER_COMPOSE_COMMAND)

  else
    echo "⚠️  No docker-compose.yml found in $dir or $dir/docker"
  fi

  echo "------------------------------------"
done
echo "🚀 All done!"