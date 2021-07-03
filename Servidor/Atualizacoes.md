# Atualizar automaticamente somente as atualizações de segurança num Ubuntu:

aptitude install unattended-upgrades

nano /etc/apt/apt.conf.d/10periodic

Excluir tudo e adicionar:
```bash
APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Download-Upgradeable-Packages "1";
APT::Periodic::AutocleanInterval "7";
APT::Periodic::Unattended-Upgrade "1";
```
Isso somente atualiza pacotes de segurança

## Atualização completa, de todos os pacotes:

apt-get update

apt-get upgrade

Atualize o servidor manualmente pelo menos uma vez por dia.


Como habilitar atualizações automáticas de segurança no Ubuntu 20.04

Por padrão o unattended-upgrades já vem instalado no Ubuntu 20.04

sudo apt update; sudo apt install -y unattended-upgrades

sudo systemctl status unattended-upgrades

sudo nano /etc/apt/apt.conf.d/50unattended-upgrades

Unattended-Upgrade::Automatic-Reboot "true";

Unattended-Upgrade::Allowed-Origins {
        "${distro_id}:${distro_codename}";
        "${distro_id}:${distro_codename}-security";
        
        "${distro_id}ESMApps:${distro_codename}-apps-security";
        "${distro_id}ESM:${distro_codename}-infra-security";        

Testar

sudo unattended-upgrades --dry-run

Logs

tail -f /var/log/unattended-upgrades/unattended-upgrades.log


Referências

https://phoenixnap.com/kb/automatic-security-updates-ubuntu
https://www.linuxbabe.com/ubuntu/automatic-security-update-unattended-upgrades-ubuntu

