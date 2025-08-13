#!/bin/bash
set -e

REPO_URL="https://github.com/megahardtechnologies2025-cloud/megda-stack.git"
TARGET_DIR="/opt/megda-stack"
HOSTNAME_WANTED="megda"   # => megda.local

echo "[1/6] Install Docker, Compose, Avahi, Git"
sudo apt-get update
sudo apt-get install -y docker.io docker-compose avahi-daemon libnss-mdns git
sudo systemctl enable --now docker
sudo systemctl enable --now avahi-daemon

echo "[2/6] Set hostname to '${HOSTNAME_WANTED}' for mDNS"
if [ "$(hostname)" != "${HOSTNAME_WANTED}" ]; then
  sudo hostnamectl set-hostname "${HOSTNAME_WANTED}"
  sudo systemctl restart avahi-daemon
fi

echo "[3/6] Clone repo"
sudo mkdir -p "${TARGET_DIR}"
if [ ! -d "${TARGET_DIR}/.git" ]; then
  sudo git clone "${REPO_URL}" "${TARGET_DIR}"
else
  sudo git -C "${TARGET_DIR}" pull --rebase
fi
cd "${TARGET_DIR}"

echo "[4/6] Prepare docker-compose stack"
# Ensure folders exist
mkdir -p php-app mysql-init

# Copy PHP application into the Docker volume mount folder
cp -r megda/* php-app/

# Copy SQL seed file into MySQL initialization folder
cp MegDA.sql mysql-init/

# Create docker-compose.yml if not exists
if [ ! -f docker-compose.yml ]; then
cat > docker-compose.yml <<'EOF'
version: '3.8'
services:
  web:
    image: php:8.2-apache
    container_name: megda_web
    volumes:
      - ./php-app:/var/www/html
    ports:
      - "80:80"
    depends_on:
      - db
    networks:
      - megda_net

  db:
    image: mysql:8.0
    container_name: megda_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: rootpass
      MYSQL_DATABASE: megda
      MYSQL_USER: megdauser
      MYSQL_PASSWORD: megdapass
    ports:
      - "3306:3306"
    volumes:
      - ./mysql-data:/var/lib/mysql
      - ./mysql-init:/docker-entrypoint-initdb.d
    networks:
      - megda_net

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: megda_phpmyadmin
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: rootpass
    ports:
      - "8080:80"
    depends_on:
      - db
    networks:
      - megda_net

networks:
  megda_net:
    driver: bridge
EOF
fi

# Start the stack
sudo docker compose up -d --build

echo "[5/6] Install IP watcher service"
sudo cp scripts/watch_ip_change.sh /usr/local/bin/watch_ip_change.sh
sudo chmod +x /usr/local/bin/watch_ip_change.sh

sudo bash -c 'cat >/etc/systemd/system/megda-ipwatch.service <<EOF
[Unit]
Description=Megda IP Change Watcher (restart Avahi on IP change)
After=network-online.target avahi-daemon.service
Wants=network-online.target

[Service]
Type=simple
ExecStart=/usr/local/bin/watch_ip_change.sh
Restart=always

[Install]
WantedBy=multi-user.target
EOF'
sudo systemctl daemon-reload
sudo systemctl enable --now megda-ipwatch.service

IP_NOW=$(hostname -I | awk '{print $1}')
echo "[6/6] Done!"
echo "---------------------------------------"
echo "mDNS hostname  : ${HOSTNAME_WANTED}.local"
echo "Current IP     : ${IP_NOW}"
echo "App URL        : http://${HOSTNAME_WANTED}.local"
echo "phpMyAdmin     : http://${HOSTNAME_WANTED}.local:8080"
echo "MySQL Host     : db"
echo "MySQL User     : megdauser"
echo "MySQL Pass     : megdapass"
echo "---------------------------------------"
