pipeline {
    agent any

     triggers {
        githubPush()
    }


    environment {
        // Définir les variables d'environnement
        APP_NAME = 'isi-burger'
        DOCKER_IMAGE = "${APP_NAME}:${BUILD_NUMBER}"
    }

    stages {
        stage('Checkout') {
            steps {
                // Récupérer le code depuis GitHub (branche aliou_ndour_branch)
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/aliou_ndour_burger']],
                    userRemoteConfigs: [[url: 'https://github.com/LinhoDevops/gestion_restauration_laravel.git']]
                ])
                echo 'Code récupéré avec succès'
            }
        }

         stage('Installation de Composer locale') {
            steps {
                script {
                    def composerInstalled = sh(script: 'which composer || echo "not found"', returnStdout: true).trim()
                    if (composerInstalled.contains("not found")) {
                        sh '''
                        curl -sS https://getcomposer.org/installer | php
                        chmod +x composer.phar
                        mv composer.phar composer
                        export PATH=$PATH:$(pwd)
                        '''
                        echo "Composer installé localement"
                    }
                }
            }
        }

        stage('Installation des dépendances') {
            steps {
                script {
                    def composerInstalled = sh(script: 'which composer || echo "not found"', returnStdout: true).trim()
            if (!composerInstalled.contains("not found")) {
                        sh 'composer install --no-interaction --no-progress'
            } else {
                        sh './composer install --no-interaction --no-progress'
            }
                }
            }
        }

        stage('Configuration de l\'environnement') {
            steps {
                // Copier le fichier d'environnement
                sh 'cp .env.example .env'

                // Générer la clé d'application
                sh 'php artisan key:generate'

                echo 'Configuration de l\'environnement terminée'
            }
        }

        stage('Tests') {
            steps {
                // Exécuter les tests si vous en avez
              //  sh 'php artisan test'
                echo 'Tests exécutés avec succès'
            }
        }

        stage('Construction Docker') {
            steps {
                // Construire l'image Docker
                sh "docker build -t ${DOCKER_IMAGE} ."
                echo 'Image Docker construite avec succès'
            }
        }

        stage('Déploiement') {
            steps {
                // Arrêter les anciens conteneurs s'ils existent
                sh 'docker-compose down || true'

                // Mettre à jour l'image dans docker-compose.yml
                sh "sed -i 's|image: isi-burger:.*|image: ${DOCKER_IMAGE}|g' docker-compose.yml"

                // Lancer les conteneurs avec docker-compose
                sh 'docker-compose up -d'

                // Exécuter les migrations de base de données
                sh 'docker exec ${APP_NAME} php artisan migrate --force'

                echo 'Application déployée avec succès'
            }
        }
    }

    post {
        success {
            echo 'Pipeline exécuté avec succès! L\'application ISI BURGER est déployée.'
        }
        failure {
            echo 'Échec du pipeline. Veuillez vérifier les logs pour plus de détails.'
        }
    }
}
