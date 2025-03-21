pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'isi-burger-app'
        DOCKER_TAG = "${GIT_BRANCH == 'main' ? 'latest' : GIT_COMMIT.substring(0,7)}"
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install'
                sh 'npm install'
            }
        }

        stage('Run Tests') {
            steps {
                sh 'php artisan test'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    docker.build("${DOCKER_IMAGE}:${DOCKER_TAG}")
                }
            }
        }

        stage('Deploy') {
            when {
                branch 'main'
            }
            steps {
                script {
                    // Exemple de déploiement (à personnaliser)
                    sh 'docker-compose down'
                    sh 'docker-compose up -d'
                }
            }
        }
    }

    post {
        success {
            echo 'Pipeline completed successfully!'
        }
        failure {
            echo 'Pipeline failed.'
        }
    }
}
