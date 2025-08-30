pipeline {
    agent any

    environment {
       REPO = 'edy2010/php-app'
       DOCKER_TOKEN = credentials('dok-tok')
       PRJ_NAME = 'php'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    sh"""
                    docker build -t "${env.REPO}:${env.PRJ_NAME}-${env.BUILD_NUMBER}" .
                    """
                }
            }
        }

        stage('Push to Docker Hub') {
            steps {
                script {
                    sh"""
		            docker login -u edy2010 -p ${env.DOCKER_TOKEN}
			        docker push "${REPO}:${PRJ_NAME}-${env.BUILD_NUMBER}"
		            """
                }
            }
        }

        
    }
}
