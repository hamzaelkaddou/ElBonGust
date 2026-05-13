# 1. Resum executiu

## Versió en català

Aquesta memòria recull tot el treball que he fet durant aquest curs per al projecte intermodular d'SMX2. El projecte consisteix en dissenyar i implementar tot l'ecosistema tecnològic d'un restaurant d'alta gastronomia anomenat **ElBonGust**. La idea va començar com una cosa relativament simple: muntar un sistema informàtic per a un restaurant, i ha acabat sent un projecte que toca pràcticament totes les coses que hem anat aprenent durant aquests dos anys de cicle, des del cablejat físic fins a l'aplicació final que faran servir els cambrers cada nit.

**ElBonGust** és un restaurant que existeix com a context fictici per al projecte. Es va obrir el 2018. El restaurant té quaranta places a la sala interior, vint més a la terrassa d’estiu i una barra. La seva especialitat és la cuina catalana contemporània amb producte de la llotja de Palamós, sobretot la gamba, que és el seu plat estrella. Després d’uns anys funcionant amb un sistema completament artesanal (agendes de paper per a les reserves, comandes cantades a la cuina, TPV bàsic sense connectar), han decidit posar-se al dia.

La meva proposta tècnica gira al voltant d’un servidor central amb **Ubuntu Server 26.04 LTS**, sobre el qual s’inclou **Odoo 17** com a ERP i punt de venda, una web pública, **MariaDB** i **PHP** per a un sistema de contactes a mida que he programat (és la tasca obligatòria del projecte). La xarxa l’he organitzada en tres VLANs ben separades: servidors, personal i clients, per garantir el rendiment i la seguretat. Sobre aquesta arquitectura hi ha un sistema de càmeres IP, punts d’accés Wi-Fi WPA3, tauletes per als cambrers i un sistema de codis QR a les taules per a la carta digital.

El resultat és un sistema integrat, modular i escalable que respon a les necessitats reals del restaurant i, alhora, permet créixer en el futur sense haver de tirar res a terra. La memòria documenta el procés de presa de decisions, les alternatives que vaig considerar, els problemes que han anat sorgint pel camí i com els he anat resolent. He intentat que sigui una documentació útil de veritat, no només un tràmit per aprovar el projecte.

---

## English version

This report collects all the work I have done during this course for the SMX2 intermodular project. The project consists of designing and implementing the entire technological ecosystem of a haute cuisine restaurant called **ElBonGust**. The idea started as something relatively simple: setting up an IT system for a restaurant, and has ended up being a project that touches practically everything we have learned during these two years of the cycle, from physical wiring to the final application that waiters will use every night.

**ElBonGust** is a fictional restaurant used as the context for the project. It opened in 2018. The restaurant has forty seats in the indoor dining room, twenty more on the summer terrace, and a bar. Its specialty is contemporary Catalan cuisine using products from the Palamós fish market, especially shrimp, which is its signature dish. After a few years running a completely manual system (paper reservation books, orders shouted to the kitchen, a basic POS not connected to anything), they have decided to modernize.

My technical proposal revolves around a central server with **Ubuntu Server 26.04 LTS**, on which I deploy **Odoo 17** as ERP and point of sale, a public website, **MariaDB**, and **PHP** for a custom contact system that I developed (this is the mandatory part of the project). I organized the network into three well-separated VLANs: servers, staff, and customers, to ensure performance and security. On top of this architecture there is an IP camera system, WPA3 Wi-Fi access points, tablets for waiters, and a QR code system on tables for the digital menu.

The result is an integrated, modular, and scalable system that meets the real needs of the restaurant while allowing future growth without rebuilding everything from scratch. The report documents the decision-making process, the alternatives considered, the problems encountered along the way, and how they were solved. The goal was to create genuinely useful documentation, not just a formality to pass the project.
