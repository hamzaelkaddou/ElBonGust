set -euo pipefail
DATE=$(date +%Y-%m-%d)
TIMESTAMP=$(date +%Y-%m-%d_%H%M%S)
BACKUP_DIR="/mnt/nas/elbongust/backups/${DATE}"
LOG_FILE="/var/log/elbongust/backup.log"
CONTAINERS_DIR="/opt/elbongust/srv"
MAIL_ADMIN="${MAIL_ADMIN:-admin@elbongust.cat}"
source "${CONTAINERS_DIR}/.env" 2>/dev/null || true
log() { echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"; }
error_exit() { log "ERROR: $*"; echo "ERROR backup ElBonGust: $*" | mail -s "[ElBonGust] ❌ Backup FALLAT ${DATE}" "$MAIL_ADMIN"; exit 1; }
log "========================================================"
log "Inici backup diari ElBonGust — ${DATE}"
log "========================================================"
mkdir -p "$BACKUP_DIR" || error_exit "No s'ha pogut crear el directori $BACKUP_DIR"
log "Fent backup de PostgreSQL (Odoo)..."
docker exec elbongust-db pg_dump \
    -U "${POSTGRES_USER:-odoo}" \
    --format=custom \
    --compress=9 \
    "${POSTGRES_DB:-odoo}" \
    > "${BACKUP_DIR}/odoo_db_${TIMESTAMP}.dump" \
    || error_exit "Fallada el backup de PostgreSQL"
log "PostgreSQL: OK ($(du -sh "${BACKUP_DIR}/odoo_db_${TIMESTAMP}.dump" | cut -f1))"
log "Eliminant còpies de més de 7 dies..."
find /mnt/nas/elbongust/backups/ -maxdepth 1 -type d -mtime +7 -exec rm -rf {} \; 2>/dev/null || true
log "Neteja: OK"
TOTAL_SIZE=$(du -sh "$BACKUP_DIR" | cut -f1)
log "========================================================"
log "Backup completat correctament"
log "Directori: $BACKUP_DIR"
log "Mida total: $TOTAL_SIZE"
log "========================================================"
echo "Backup diari completat correctament.
Data: ${DATE}
Mida total: ${TOTAL_SIZE}
Directori: ${BACKUP_DIR}" \
| mail -s "[ElBonGust] ✅ Backup OK ${DATE}" "$MAIL_ADMIN"