# ENI-Encheres.org

L’association « Les objets sont nos amis » désire monter une plateforme web pour permettre
la cession d’objets de seconde main sans échanges financiers. La valeur des articles sera
déterminée par un système d’enchères basée sur un nombre de points. Les points sont
gagnés en vendant des objets, puis peuvent être utilisés pour acquérir d’autres objets.

## Environnement de développement

### Pré-requis

- PHP 7.2.5
- Composer
- Symfony CLI
- Docker
- Docker-compose

Vous pouvez vérifier les pré-requis via la commande de la CLI Symfony:

```bash
symfony check:requirements
```

### Lancer l'environnement de développement

```bash
docker-compose up -d
symfony serve -d
```
