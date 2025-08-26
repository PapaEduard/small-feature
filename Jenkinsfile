pipeline {
    agent any

    environment {
        // Переменные окружения
        DOCKERHUB_CREDENTIALS = 'dockerhub-creds'
        IMAGE_NAME           = 'edy2010/index.php'
        GIT_BRANCH           = "${env.BRANCH_NAME ?: 'main'}"
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: "${env.GIT_BRANCH}", url: 'https://github.com/PapaEduard/small-feature.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    dockerImage = docker.build("${IMAGE_NAME}:${env.BUILD_NUMBER}")
                }
            }
        }

        stage('Push to Docker Hub') {
            steps {
                script {
                    docker.withRegistry('https://registry.hub.docker.com', "${DOCKERHUB_CREDENTIALS}") {
                        dockerImage.push()
                        dockerImage.push('latest')
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                sshagent (credentials: ['ssh-deploy-creds']) {
                    sh """
                      ssh -o StrictHostKeyChecking=no deployer@your.server.com \\
                      'docker pull ${IMAGE_NAME}:latest && \\
                       docker stop php-app || true && \\
                       docker rm php-app || true && \\
                       docker run -d --name php-app -p 80:80 ${IMAGE_NAME}:latest'
                    """
                }
            }
        }
    }
}
