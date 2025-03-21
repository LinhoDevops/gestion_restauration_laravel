#!/bin/bash

# Couleurs pour les messages
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fonctions
print_success() {
    echo -e "${GREEN}$1${NC}"
}

print_error() {
    echo -e "${RED}$1${NC}"
}

print_warning() {
    echo -e "${YELLOW}$1${NC}"
}

# Vérifier si Docker est installé
if ! [ -x "$(command -v docker)" ]; then
  print_error "Erreur: Docker n'est pas installé."
  exit 1
fi

# Vérifier si Docker Compose est installé
if ! [ -x "$(command -v docker-compose)" ]; then
  print_error "Erreur: Docker Compose n'est pas installé."
  exit 1
fi

# Menu principal
show_menu() {
    echo "========================================================"
    echo "         ISI BURGER - Script de Déploiement"
    echo "========================================================"
    echo "1. Déployer l'application"
    echo "2. Arrêter l'application"
    echo "3. Redémarrer l'application"
    echo "4. Vérifier l'état des services"
    echo "5. Exécuter les migrations de base de données"
    echo "6. Créer un utilisateur administrateur"
    echo "7. Afficher les logs de l'application"
    echo "8. Nettoyer les volumes Docker non utilisés"
    echo "9. Quitter"
    echo "========================================================"
    echo -n "Votre choix: "
}

# Déployer l'application
deploy_app() {
    print_warning "Déploiement de l'application en cours..."

    # Construire l'image Docker
    docker build -t isi-burger:latest .

    # Lancer les conteneurs avec docker-compose
    docker-compose up -d

    # Vérifier si les conteneurs sont en cours d'exécution
    if [ $(docker-compose ps -q | wc -l) -eq 3 ]; then
        print_success "Déploiement réussi!"
    else
        print_error "Erreur lors du déploiement. Vérifiez les logs avec: docker-compose logs"
    fi
}

# Arrêter l'application
stop_app() {
    print_warning "Arrêt de l'application en cours..."
    docker-compose down
    print_success "Application arrêtée."
}

# Redémarrer l'application
restart_app() {
    print_warning "Redémarrage de l'application en cours..."
    docker-compose restart
    print_success "Application redémarrée."
}

# Vérifier l'état des services
check_status() {
    echo "État des services:"
    docker-compose ps
}

# Exécuter les migrations
run_migrations() {
    print_warning "Exécution des migrations de base de données..."
    docker exec isi-burger php artisan migrate --force
    print_success "Migrations exécutées."
}

# Créer un administrateur
create_admin() {
    print_warning "Création d'un utilisateur administrateur..."

    # Demander les informations de l'administrateur
    read -p "Nom d'utilisateur: " admin_name
    read -p "Email: " admin_email
    read -s -p "Mot de passe: " admin_password
    echo ""

    # Créer l'administrateur via Artisan
    docker exec isi-burger php artisan tinker --execute="
        \$user = new \App\Models\User();
        \$user->name = '$admin_name';
        \$user->email = '$admin_email';
        \$user->password = bcrypt('$admin_password');
        \$user->is_admin = true;
        \$user->save();
        echo 'Administrateur créé avec succès!';
    "
}

# Afficher les logs
show_logs() {
    docker-compose logs -f
}

# Nettoyer les volumes Docker
clean_volumes() {
    print_warning "Nettoyage des volumes Docker non utilisés..."
    docker volume prune -f
    print_success "Volumes nettoyés."
}

# Boucle principale
while true; do
    show_menu
    read choice

    case $choice in
        1) deploy_app ;;
        2) stop_app ;;
        3) restart_app ;;
        4) check_status ;;
        5) run_migrations ;;
        6) create_admin ;;
        7) show_logs ;;
        8) clean_volumes ;;
        9) exit 0 ;;
        *) print_error "Choix invalide!" ;;
    esac

    echo ""
    read -p "Appuyez sur Entrée pour continuer..."
    clear
done
