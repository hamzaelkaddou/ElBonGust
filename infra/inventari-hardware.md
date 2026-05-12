# ElBonGust — Inventari de Hardware i Diagrama de Xarxa
# Fitxer: infra/inventari-hardware.md

## Hardware del sistema

| Element | Model / Especificació | Quantitat | IP | Ubicació |
|---------|----------------------|-----------|-----|---------|
| Servidor rack 1U | 4 nuclis, 8GB RAM, 2×SSD 256GB RAID1 | 1 | 192.168.10.10 | Sala tècnica - rack |
| SAI | APC Back-UPS 1500VA, 865W, autonomia ~15min | 1 | — | Sala tècnica - rack |
| Switch gestionat | 24 ports Gigabit, 802.1Q VLAN, PoE+ | 1 | — | Sala tècnica - rack |
| Router/Firewall | pfSense CE, 4 ports Gigabit | 1 | 192.168.10.1 | Sala tècnica - rack |
| Punt d'accés Wi-Fi | Dual band 2.4/5GHz, WPA3, multi-SSID | 2 | DHCP | Sostre menjador + terrassa |
| NAS backup | 4TB, RAID1, connexió Gigabit | 1 | 192.168.10.11 | Sala tècnica - prestatge |
| Tablet cambrer | iPad 10a gen. o Android 11" | 4 | DHCP VLAN20 | Sala + terrassa |
| Monitor TPV tàctil | 15", Full HD, touch capacitiu | 1 | 192.168.20.10 | Barra |
| Mini-PC TPV | Intel NUC o similar, 8GB RAM | 1 | 192.168.20.10 | Darrere barra |
| Impressora cuina | Tèrmica 80mm, tall automàtic, RJ45 | 2 | 192.168.20.30/31 | Cuina + Barra |
| Calaix portamonedes | Apertura per senyal RJ11 del TPV | 1 | — | Barra |
| Datàfon bancari | 4G + Ethernet, compatible Odoo IoT | 1 | DHCP VLAN20 | Barra |
| PC Gerent | Ordinador sobretaula o portàtil | 1 | 192.168.20.5 | Despatx |
| Codis QR taula | Vinils laminats, un per taula | 16 | — | Taules sala + terrassa |

## Diagrama de xarxa (representació ASCII)

```
                          INTERNET
                             │
                    ┌────────┴────────┐
                    │  Router/Firewall │
                    │  pfSense CE      │
                    │  192.168.10.1    │
                    └────────┬────────┘
                             │ (Trunk VLAN 10+20+30)
                    ┌────────┴────────┐
                    │ Switch gestionat│
                    │ 24p 802.1Q PoE+ │
                    └──┬──────┬──────┬┘
                       │      │      │
              VLAN10   │ VLAN20│ VLAN30│
           Servidors   │ Staff │Clients│
          192.168.10.x │ .20.x │ .30.x │
                       │      │      │
          ┌────────────┘      │      └──────────────────┐
          │                   │                         │
  ┌───────┴──────┐    ┌───────┴──────┐       ┌─────────┴────────┐
  │ Servidor     │    │ TPV Barra    │       │ Access Point     │
  │ Ubuntu 26.04 │    │ .20.10       │       │ SSID: ElBonGust  │
  │ .10.10       │    │              │       │ Clients (WPA3)   │
  │              │    │ Tauletes     │       │ .30.50–200 DHCP  │
  │ ┌──────────┐ │    │ .20.21–23    │       └──────────────────┘
  │ │          │ │    │              │
  │ │ Odoo     │ │    │ Impressores  │
  │ │ PosgreSQL│ │    │ .20.30–31    │
  │ │ MariaDB  │ │    │              │
  │ | PHP      | |    |  PC Gerent   │
  │ │ Nginx    | |    |  .20.5       │
  │ │          │ │    │              │
  │ └──────────┘ │    └──────────────┘
  └──────────────┘
          │
  ┌───────┴──────┐
  │ NAS Backup   │
  │ .10.11       │
  └──────────────┘
```

## Configuració del switch gestionat (VLANs)

| Port | Mode | VLANs permeses | Dispositiu connectat |
|------|------|----------------|---------------------|
| 1 | Trunk | 10, 20, 30  | Router/Firewall |
| 2 | Trunk | 10, 20, 30  | Servidor principal |
| 3 | Access | VLAN 10  | NAS backup |
| 4 | Access | VLAN 20  | TPV barra |
| 5 | Access | VLAN 20  | PC Gerent |
| 6–9 | Access | VLAN 20 | Impressores|
| 10–11 | Trunk | 20, 30  | Access Points Wi-Fi |
| 12–24 | Access | VLAN 20  | Dispositius staff |

## SSIDs Wi-Fi

| SSID | VLAN | Xifrat | Contrasenya | Ús |
|------|------|--------|-------------|-----|
| ElBonGust-Staff | VLAN 20 | WPA3-Personal | [contrasenya segura] | Personal, tauletes, TPV |
| ElBonGust-Guest | VLAN 30 | WPA3-Personal | [canviar periodicament] | Clients del restaurant |
