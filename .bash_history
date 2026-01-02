systemctl restart apache2
systemctl status postfix
systemctl status dovecot
systemctl status apache2
uit
systemctl status dovecot
uit
journalctl -u dovecot --since "5 minutes ago"
journalctl -u postfix --since "5 minutes ago"
journalctl -u dovecot --since "2025-12-24 09:30:00" --no-pager | grep -iE "auth-worker|sql: query:|passdb out" | tail -80
doveadm user 'toni@acoradoor.com'
nano /etc/dovecot/dovecot-sql.conf.ext
systemctl restart dovecot
doveadm user 'toni@acoradoor.com'
doveadm auth test 'toni@acoradoor.com' 'toni1'
journalctl -u dovecot --since "2025-12-24 09:30:00" --no-pager | grep -i "sql: query:" | tail -20
grep -Rni 'auth_debug_passwords' /etc/dovecot
nano /etc/dovecot/conf.d/10-logging.conf
systemctl restart dovecot
doveconf -n | grep '^auth_debug_passwords'
grep -n 'auth_debug_passwords' /etc/dovecot/conf.d/10-logging.conf
doveconf auth_debug_passwords
doveconf -n
grep -Rni '^\s*auth_debug\s*=' /etc/dovecot
grep -Rni '^\s*auth_verbose\s*=' /etc/dovecot
nano /etc/dovecot/conf.d/10-logging.conf
systemctl restart dovecot
doveconf auth_verbose auth_debug auth_debug_passwords
doveconf -n | sed -n '/^service auth {/,/^}/p'
nano /etc/dovecot/conf.d/10-master.conf
systemctl restart dovecot
ls -l /var/spool/postfix/private/auth
postconf -n | egrep '^(smtpd_sasl_type|smtpd_sasl_path|smtpd_sasl_auth_enable|smtpd_tls_auth_only|broken_sasl_auth_clients|smtpd_sasl_security_options)'
nano /etc/postfix/main.cf
postfix check
systemctl restart postfix
postconf -n | egrep '^(smtpd_sasl_type|smtpd_sasl_path|smtpd_sasl_auth_enable|smtpd_tls_auth_only|broken_sasl_auth_clients|smtpd_sasl_security_options)'
grep -nE '^(submission|smtps)' -A15 /etc/postfix/master.cf
nano /etc/postfix/main.cf 
postfix check
systemctl restart postfix
postconf -n | egrep '^(smtpd_tls_cert_file|smtpd_tls_key_file|smtpd_tls_security_level)'
grep -n 'submission' /etc/postfix/master.cf | head -50
grep -n 'smtps' /etc/postfix/master.cf | head -50
nano /etc/postfix/master.cf
postfix check
systemctl restart postfix
ss -ltnp | grep -E ':(25|587)\b'
apt update
apt install -y swaks
swaks --to toni@acoradoor.com   --from toni@acoradoor.com   --server 127.0.0.1 --port 587   --auth LOGIN --auth-user toni@acoradoor.com --auth-password 'toni1'   --tls
swaks --to toni@acoradoor.com   --from toni@acoradoor.com   --server 127.0.0.1 --port 587   --auth   --auth-user toni@acoradoor.com --auth-password 'toni1'   --tls
postconf -n | egrep '^(myhostname|mydestination|mynetworks|inet_interfaces|smtpd_relay_restrictions|smtpd_recipient_restrictions)'
nano /etc/postfix/main.cf
postfix check
systemctl restart postfix
postconf myhostname mydomain myorigin mydestination
grep -n '^\s*myorigin\s*=' /etc/postfix/main.cf
nano /etc/postfix/main.cf
postfix check
systemctl restart postfix
postconf myorigin
postconf -n | egrep '^(virtual_|transport_maps|local_recipient_maps|relay_domains|mailbox_transport)'
postmap -q acoradoor.com mysql:/etc/postfix/mysql-virtual-mailbox-domains.cf
postmap -q toni@acoradoor.com mysql:/etc/postfix/mysql-virtual-mailbox-maps.cf
postmap -q toni@acoradoor.com mysql:/etc/postfix/mysql-virtual-alias-maps.cf
ls -l /var/spool/postfix/private/dovecot-lmtp
ls -la /var/vmail/acoradoor.com/toni
ls -la /var/vmail/acoradoor.com/toni/Maildir
swaks --server 127.0.0.1 --port 25   --from prueba@externo.test   --to toni@acoradoor.com
find /var/vmail/acoradoor.com/toni/Maildir/new -type f -maxdepth 1 -ls
ufw status verbose
ip -4 route get 1.1.1.1 | awk '{print $7; exit}'
curl -4 ifconfig.me
apt update
apt install -y curl dnsutils netcat-openbsd
curl -4 ifconfig.me
dig +short A mail.acoradoor.com
curl -4 ifconfig.me
curl -4 https://api.ipify.org
dig +short A mail.acoradoor.com
dig +short A mail.acoradoor.com
dig +short MX acoradoor.com
openssl s_client -connect mail.acoradoor.com:587 -starttls smtp -servername mail.acoradoor.com -brief
openssl s_client -connect mail.acoradoor.com:993 -servername mail.acoradoor.com -crlf -quiet
ls -l /etc/opendkim/keys/acoradoor.com
cat /etc/opendkim/keys/acoradoor.com/*.txt
apt update
apt install -y opendkim opendkim-tools
mkdir -p /etc/opendkim/keys/acoradoor.com
opendkim-genkey -D /etc/opendkim/keys/acoradoor.com -d acoradoor.com -s default
chown -R opendkim:opendkim /etc/opendkim
chmod 750 /etc/opendkim/keys/acoradoor.com
chmod 640 /etc/opendkim/keys/acoradoor.com/default.private
tee /etc/opendkim/key.table >/dev/null <<'EOF'
default._domainkey.acoradoor.com acoradoor.com:default:/etc/opendkim/keys/acoradoor.com/default.private
EOF

tee /etc/opendkim/signing.table >/dev/null <<'EOF'
*@acoradoor.com default._domainkey.acoradoor.com
EOF

tee /etc/opendkim/trusted.hosts >/dev/null <<'EOF'
127.0.0.1
localhost
mail.acoradoor.com
acoradoor.com
EOF

nano /etc/opendkim.conf
systemctl enable --now opendkim
systemctl restart opendkim
systemctl status opendkim --no-pager -l
journalctl -xeu opendkim --no-pager | tail -200
 nl -ba /etc/opendkim.conf | sed -n '45,65p'
nano /etc/opendkim.conf
systemctl restart opendkim
systemctl status opendkim --no-pager -l
grep -n '^Socket' /etc/opendkim.conf
ss -xlpn | grep -i opendkim || true
nano /etc/postfix/main.cf
postfix check
systemctl restart postfix
postconf -n | egrep 'milter'
cat /etc/opendkim/keys/acoradoor.com/default.txt
dig +short TXT default._domainkey.acoradoor.com
opendkim-testkey -d acoradoor.com -s default -vvv
dig +short TXT acoradoor.com
dig +short TXT _dmarc.acoradoor.com
dig +short TXT _dmarc.acoradoor.com
dig +short MX acoradoor.com
dig +short A mail.acoradoor.com
dig +short -x 188.77.213.72
systemctl status apache2 --no-pager -l || true
systemctl status nginx --no-pager -l || true
ss -ltnp | egrep ':(80|443)\s' || true
systemctl enable --now apache2
systemctl status apache2 --no-pager -l
echo "ServerName mail.acoradoor.com" | sudo tee /etc/apache2/conf-available/servername.conf
a2enconf servername
systemctl reload apache2
dpkg -l | grep -i roundcube
ls -la /etc/roundcube 2>/dev/null || true
ls -la /var/lib/roundcube 2>/dev/null || true
ls -la /etc/apache2/conf-enabled | grep -i roundcube || true
ls -la /etc/apache2/sites-enabled
curl -I http://127.0.0.1/roundcube/ || true
curl -I http://127.0.0.1/ || true
tail -200 /var/log/roundcube/errors.log 2>/dev/null || true
tail -200 /var/log/apache2/error.log
sed -n '1,200p' /etc/apache2/conf-available/roundcube.conf
 sed -n '1,200p' /etc/roundcube/apache.conf
 tee /etc/apache2/conf-available/roundcube-alias.conf >/dev/null <<'EOF'
Alias /roundcube /var/lib/roundcube/public_html

<Directory /var/lib/roundcube/public_html/>
  Options +FollowSymLinks
  AllowOverride All
  Require all granted
</Directory>
EOF

a2enconf roundcube-alias
systemctl reload apache2
curl -I http://127.0.0.1/roundcube/
grep -nE "default_host|default_port|smtp_server|smtp_port|smtp_user|smtp_pass|smtp_auth_type|smtp_helo_host" /etc/roundcube/config.inc.php
ss -ltnp | egrep ':(143|993|587)\s'
nano /etc/roundcube/config.inc.php
systemctl reload apache2
tail -200 /var/log/roundcube/errors.log 2>/dev/null || true
tail -200 /var/log/apache2/error.log
/etc/roundcube/config.inc.php
nano /etc/roundcube/config.inc.php
systemctl reload apache2
grep -n "auto_create_user" /etc/roundcube/config.inc.php
tail -200 /var/log/roundcube/errors.log 2>/dev/null || tru
tail -50 /var/log/roundcube/errors.log
ls -la /var/lib/roundcube/config
ls -la /var/lib/roundcube/config/config.inc.php
grep -n "auto_create_user" /var/lib/roundcube/config/config.inc.php
apache2ctl -S
apache2ctl -M | grep -E 'php|mpm|rewrite|alias'
grep -n "db_dsnw" /etc/roundcube/config.inc.php
sed -n '1,120p' /etc/roundcube/debian-db.php
ls -la /usr/share/roundcube/SQL/mysql.initial.sql 
/usr/share/roundcube/SQL/mysql.sql 2>/dev/null || true
dpkg-reconfigure roundcube-core
mysql roundcube -e "SHOW TABLES;"
nano /etc/roundcube/config.inc.php
systemctl restart apache2
tail -50 /var/log/roundcube/errors.log
tail -n 5 /var/log/roundcube/errors.log
date
openssl s_client -connect 127.0.0.1:993 -servername mail.acoradoor.com -quiet
nano /etc/roundcube/config.inc.php
systemctl restart apache2
tail -n 5 /var/log/roundcube/errors.log
grep -nE "imap_host|default_host|imap_port|auto_create_user" 
grep -nE "imap_host|default_host|imap_port|auto_create_user|smtp_host|smtp_server" /etc/roundcube/config.inc.php
nano /etc/roundcube/config.inc.php
systemctl restart apache2
tail -50 /var/log/roundcube/errors.log
ss -ltnp | grep ':993'
php -m | grep -i openssl
sudo -u www-data php -r '$fp=@fsockopen("ssl://127.0.0.1",993,$e,$s,5); var_dump($fp,$e,$s); if($fp) fclose($fp);'
aa-status | sed -n '1,200p'
journalctl -k --since "30 minutes ago" | grep -i apparmor | tail -50
ps aux | grep apache2
apt-get install -y strace
sudo -u www-data strace -f -e trace=network,file,process php -r '$fp=@fsockopen("ssl://127.0.0.1",993,$e,$s,5); var_dump($fp,$e,$s); if($fp) fclose($fp);'
nano /etc/php/8.2/apache2/php.ini
nano /etc/php/8.4/apache2/php.ini
/etc/php/8.4/cli/php.ini
nano /etc/php/8.4/cli/php.ini
nano /etc/php/8.4/cli/php.ini
sudo -u www-data php -r '$fp=@fsockopen("ssl://127.0.0.1",993,$e,$s,5); var_dump($fp,$e,$s); if($fp) fclose($fp);'
ls -l /etc/ssl/certs/ca-certificates.crt
mkdir -p /usr/lib/ssl
ln -sf /etc/ssl/certs/ca-certificates.crt /usr/lib/ssl/cert.pem
ln -sf /etc/ssl/certs/ca-certificates.crt /usr/lib/ssl/cert.pem
systemctl restart apache2
sudo -u www-data php -r '$fp=@fsockopen("ssl://127.0.0.1",993,$e,$s,5); var_dump($fp,$e,$s); if($fp) fclose($fp);'
sudo -u www-data php -d error_reporting=E_ALL -d display_errors=On -r 'set_error_handler(function($se,$sm){echo "\nPHP WARNING: $sm\n";}); $fp=@fsockopen("ssl://127.0.0.1",993,$e,$s,5); var_dump($fp,$e,$s); if($fp) fclose($fp);'
sudo -u www-data php -r '$fp=@fsockopen("tcp://127.0.0.1",993,$e,$s,5); var_dump($fp,$e,$s); if($fp) fclose($fp);'
nano /etc/hosts
echo "127.0.0.1 mail.acoradoor.com" | sudo tee -a /etc/hosts
nano /etc/hosts
nano /etc/roundcube/config.inc.php
systemctl restart apache2
host mail.acoradoor.com
openssl s_client -connect mail.acoradoor.com:993 -servername 
mail.acoradoor.com -quiet
openssl s_client -connect mail.acoradoor.com:993 -servername mail.acoradoor.com -quiet
tail -50 /var/log/roundcube/errors.log
openssl s_client -connect 127.0.0.1:993 -crlf -quiet
tail -n 10 /var/log/roundcube/errors.log
grep -ni auto_create_user /etc/roundcube/config.inc.php
grep -ni default_host /etc/roundcube/config.inc.php
grep -ni smtp_server /etc/roundcube/config.inc.php
ls -l /etc/roundcube/  # así vemos si hay ficheros *.dpkg-old o *.dpkg-dist que puedan sobrescribir config
systemctl restart apache2
rm -f /var/log/roundcube/errors.log
cat /var/log/roundcube/errors.log
mysql roundcube -e "SELECT username, mail_host FROM users;"
grep -i auto_create_user /etc/roundcube/defaults.inc.php
nano /etc/roundcube/config.inc.php
systemctl restart apache2
host mail.acoradoor.com
nano /etc/apache2/sites-available/mail.acoradoor.com.conf
a2ensite mail.acoradoor.com.conf
systemctl reload apache2
apachectl configtest
systemctl status apache2.service
journalctl -xeu apache2.service | tail -40
a2enmod ssl
systemctl reload apache2
certbot --apache -d mail.acoradoor.com
apt update
apt install python3-certbot-apache
certbot --apache -d mail.acoradoor.com
systemctl reload apache2
dig +short TXT acoradoor.com
apt install opendkim opendkim-tools
mkdir -p /etc/opendkim/keys/acoradoor.com
cd /etc/opendkim/keys/acoradoor.com
opendkim-genkey -s mail -d acoradoor.com
chown opendkim:opendkim mail.private
cd
nano /etc/opendkim.conf
nano /etc/opendkim.conf
mkdir -p /var/spool/postfix/opendkim
chown opendkim:postfix /var/spool/postfix/opendkim
nano /etc/default/opendkim
systemctl restart opendkim
systemctl status opendkim
nano /etc/postfix/main.cf
systemctl restart postfix
systemctl status postfix
journalctl -xeu postfix | tail -40
cat /etc/opendkim/keys/acoradoor.com/mail.txt
nano /etc/opendkim.conf
nano /etc/default/opendkim
nano /etc/postfix/main.cf
chown opendkim:postfix /var/spool/postfix/opendkim
chown opendkim:postfix /var/spool/postfix/opendkim
chmod 750 /var/spool/postfix/opendkim
nano /etc/opendkim/TrustedHosts
nano /etc/opendkim.conf
nano /etc/opendkim.conf
nano /etc/opendkim/KeyTable
nano /etc/opendkim/SigningTable
systemctl restart opendkim
systemctl restart postfix
nano /etc/opendkim.conf
nano /etc/default/opendkim
nano /etc/opendkim.conf
nano /etc/opendkim.conf
nano /etc/opendkim/KeyTable
nano /etc/opendkim/KeyTable
nano /etc/opendkim/SigningTable
nano /etc/opendkim/TrustedHosts
nano /etc/postfix/main.cf
chown -R opendkim:opendkim /etc/opendkim/keys/
chown opendkim:postfix /var/spool/postfix/opendkim
chmod 750 /var/spool/postfix/opendkim
systemctl restart opendkim
systemctl restart postfix
ls -l /var/spool/postfix/opendkim
journalctl -xeu opendkim | tail -40
journalctl -xeu postfix | tail -40
chown opendkim:postfix /var/spool/postfix/opendkim/opendkim.sock
chmod 660 /var/spool/postfix/opendkim/opendkim.sock
chown opendkim:postfix /var/spool/postfix/opendkim
chmod 770 /var/spool/postfix/opendkim
systemctl restart opendkim
systemctl restart postfix
ls -l /var/spool/postfix/opendkim/opendkim.sock
journalctl -xeu opendkim | tail -40
journalctl -xeu postfix | tail -40
systemctl stop postfix
systemctl stop opendkim
rm -f /var/spool/postfix/opendkim/opendkim.sock
rmdir /var/spool/postfix/opendkim
 mkdir -p /var/spool/postfix/opendkim
chown opendkim:postfix /var/spool/postfix/opendkim
chmod 770 /var/spool/postfix/opendkim
nano /etc/opendkim.conf
systemctl start opendkim
ls -l /var/spool/postfix/opendkim/opendkim.sock
 systemctl start postfix
ls -l /var/spool/postfix/opendkim/opendkim.sock
systemctl stop opendkim
systemctl stop postfix
rm -f /var/spool/postfix/opendkim/opendkim.sock
chown -R opendkim:postfix /var/spool/postfix/opendkim
chmod 770 /var/spool/postfix/opendkim
nano /etc/opendkim.conf
/etc/default/opendkim
nano /etc/default/opendkim
systemctl start opendkim
systemctl start postfix
ls -l /var/spool/postfix/opendkim/opendkim.sock
nano /etc/opendkim.conf
systemctl stop opendkim
rm -f /var/spool/postfix/opendkim/opendkim.sock
chown opendkim:postfix /var/spool/postfix/opendkim
chmod 770 /var/spool/postfix/opendkim
systemctl start opendkim
ls -l /var/spool/postfix/opendkim/opendkim.sock
chmod 660 /var/spool/postfix/opendkim/opendkim.sock
ls -l /var/spool/postfix/opendkim/opendkim.sock
systemctl restart opendkim
systemctl restart postfix
journalctl -xeu postfix | tail -40
journalctl -xeu opendkim | tail -40
nano /etc/opendkim/KeyTable
ls -l /etc/opendkim/keys/acoradoor.com/mail.private
systemctl restart opendkim
systemctl restart postfix
dig +short TXT mail._domainkey.acoradoor.com
nslookup -type=TXT mail._domainkey.acoradoor.com
dig +short TXT mail._domainkey.acoradoor.com
nslookup -type=TXT mail._domainkey.acoradoor.com
nslookup -type=TXT mail._domainkey.acoradoor.com
nslookup -type=TXT mail._domainkey.acoradoor.com
dig +short TXT mail._domainkey.acoradoor.com
dig +short NS acoradoor.com
dig +short NS acoradoor.com
dig +short NS acoradoor.com
dig +short TXT mail._domainkey.acoradoor.com
dig +short TXT mail._domainkey.acoradoor.com
dig +short TXT mail._domainkey.acoradoor.com
dig +short TXT mail._domainkey.acoradoor.com
dig +short TXT mail._domainkey.acoradoor.com
chown -R acoradoor:www-data /var/www/html
chmod -R 775 /var/www/html
chown -R acoradoor:www-data /var/www/html/correo
chmod -R 775 /var/www/html/correo
mv /home/tuusuario/acoradooradmin /var/www/html/
mv /home/acoradoor/acoradooradmin /var/www/html/
mv /home/acoradoor/acoradooradmin1 /var/www/html/
mv /home/acoradoor/acoradoor /var/www/html/
mv /home/acoradoor/acoradooradmin1 /var/www/html/
chown -R www-data:www-data /var/www/html/acoradooradmin
chown -R www-data:www-data /var/www/html/acoradooradmin1
chown -R www-data:www-data /var/www/html/acoradoor
mv /home/acoradoor/nuve.acoradoor /var/www/html/
chown -R www-data:www-data /var/www/html/nuve.acoradoor
find /var/www/html/acoradooradmin -type d -exec chmod 755 {} \;
find /var/www/html/acoradooradmin1 -type d -exec chmod 755 {} \;
find /var/www/html/acoradoor -type d -exec chmod 755 {} \;
find /var/www/html/nuve.acoradoor -type d -exec chmod 755 {} \;
find /var/www/html/acoradooradmin -type f -exec chmod 644 {} \;
find /var/www/html/acoradooradmin1 -type f -exec chmod 644 {} \
find /var/www/html/acoradoor -type f -exec chmod 644 {} \;
find /var/www/html/acoradoor -type f -exec chmod 644 {} \;
find /var/www/html/html/nuve.acoradoor -type f -exec chmod 644 {} \;
find /var/www/html/nuve.acoradoor -type f -exec chmod 644 {} \;
cd '/var/www/html/acoradooradmin' 
git init
cd
apt update
apt install git
git config --global user.name "acoradoor"
git config --global user.email "acoradoor@gmail.com"
git init
git remote add origin https://github.com/Acoradoor/erp-gestion-empresa
cd '/var/www/html/acoradooradmin' 
git init
git remote add origin https://github.com/Acoradoor/erp-gestion-empresa
git add 
git config --global --add safe.directory /var/www/html/acoradooradmin
git add
git add 
git commit -m "tu mensaje indicando los cambios"
git add .
git commit -m "Primer commit completo: añadir todo el código y estructura del proyecto"
git push
git remote add origin https://github.com/Acoradoor/erp-gestion-empresa
git push -u origin master
git push -u origin master
git push -u origin master
git push -u origin master
git push -u origin master
git push -u origin main
git push -u origin master
git push origin --delete main
apt update
apt install python3 python3-pip
apt install nodejs npm
cd
node -v
npm -v
pip install open-interpreter
apt install pipx
pipx install open-interpreter
apt install rustc cargo
apt install build-essential python3-dev
pipx install open-interpreter
apt install python3.11 python3.11-venv python3.11-dev
apt install -y build-essential libssl-dev zlib1g-dev libbz2-dev libreadline-dev libsqlite3-dev wget curl llvm libncurses5-dev libncursesw5-dev xz-utils tk-dev libffi-dev liblzma-dev git
curl https://pyenv.run | bash
export PATH="$HOME/.pyenv/bin:$PATH"
eval "$(pyenv init -)"
eval "$(pyenv virtualenv-init -)"
source ~/.bashrc
pyenv install 3.11.7
pyenv virtualenv 3.11.7 openinterpreter-venv
pyenv activate openinterpreter-venv
# Confirmar Python correcto:
python --version  # Debe decir Python 3.11.7
# Instala open-interpreter
pip install --upgrade pip
pip install open-interpreter
interpreter --web
pyenv activate openinterpreter-venv
pip install --upgrade pip
pip install git+https://github.com/OpenInterpreter/open-interpreter.git
interpreter --help
interpreter --web
interpreter --server
pip install fastapi uvicorn
install "starlette>=0.37.2,<0.38.0"
pip install "starlette>=0.37.2,<0.38.0"
interpreter --server
pip install "fastapi<0.111.0"
pip show fastapi
pip show starlette
interpreter --server
cd
git clone https://github.com/OpenInterpreter/web.git
cd web
npm install
npm run dev
ping github.com
curl https://github.com/
git
git clone https://github.com/Acoradoor/app.git
cd app
git rm -rf .
rm -rf *
rm -rf .[^.]* 2>/dev/null
cp -r /var/www/html/acoradooradmin5/* .
cp -r /var/www/html/acoradooradmin5/.[^.]* .
ls
git add .
git commit -m "Repo completamente reemplazado por nueva versión"
git push origin main
git branch
git push origin master
git push origin master
git push origin master
git push origin master
git push origin master
git push origin master
git remote -v
git remote set-url origin https://github.com/Acoradoor/app.git
git remote -v
git push origin master --force
exit
