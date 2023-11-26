#/bin/bash
set -e

cp .env.example .env

sed -i~ '/PG_.*/d' ./.env

BASE_IMAGE=innot20/wiamgroup-test-task/base
BASE_IMAGE_TAG=latest

PHP_IMAGE=innot20/wiamgroup-test-task
NGINX_IMAGE=innot20/wiamgroup-test-task/nginx

APP_TAG=latest # it can be commit hash when used in ci

# Build base php image
docker build -t $BASE_IMAGE:$APP_TAG -f docker/php/base/Dockerfile .

# Build main php image
docker build \
  -t $PHP_IMAGE:$APP_TAG \
  --build-arg BASE_IMAGE=$BASE_IMAGE \
  --build-arg BASE_IMAGE_TAG=$BASE_IMAGE_TAG \
  -f docker/php/Dockerfile .

# Build nginx image
docker build \
  -t $NGINX_IMAGE:$APP_TAG \
  --build-arg PHP_IMAGE=$PHP_IMAGE \
  --build-arg PHP_IMAGE_TAG=$APP_TAG \
  -f docker/nginx/Dockerfile .

docker compose -f docker-compose.prod.yml up -d

echo "Waiting connections with postgresql..."
until [ -z $(docker compose exec php ./yii deploy/check-connection) ]; do
  echo "Waiting..."
  sleep 5
done
echo "Successfully connected"

echo "Execute migrations"
docker compose exec php ./yii migrate --interactive=0

eval "$(grep ^ADMIN_TOKEN= .env)"

echo "\n\n"
echo "Deployed successfully"
echo "Main page url: http://127.0.0.1"
echo "Admin page url: http://127.0.0.1/Admin/image?token=${ADMIN_TOKEN}"