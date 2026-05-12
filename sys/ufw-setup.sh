set -e
echo "=== Configurant UFW per a ElBonGust ==="

ufw --force reset

ufw default deny incoming     
ufw default allow outgoing    
ufw default deny routed       

ufw allow 2222/tcp comment 'SSH - administracio remota'

ufw allow 80/tcp  comment 'HTTP  - redirigit a HTTPS per Nginx'
ufw allow 443/tcp comment 'HTTPS - web publica + Nginx proxy'

ufw allow from 192.168.20.0/24 to any port 8069 proto tcp \
    comment 'Odoo POS - acces VLAN20 staff'

ufw deny from 192.168.30.0/24 to 192.168.10.0/24 \
    comment 'Blocar clients VLAN30 → servidors VLAN10'
ufw deny from 192.168.30.0/24 to 192.168.20.0/24 \
    comment 'Blocar clients VLAN30 → staff VLAN20'

ufw logging on
ufw logging medium

ufw --force enable

echo ""
echo "=== Estat final del firewall ==="
ufw status verbose

echo ""
echo "UFW configurat correctament per a ElBonGust."
