import java.util.Random

pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Building...'
                // send build started notifications
                //slackSend (color: '#FFFF00', message: "STARTED: Job '${env.JOB_NAME} [${env.BUILD_NUMBER}]' (${env.BUILD_URL})")

                sh '''
                    sed "s@{{ CHEMIN_LOCAL }}@$WORKSPACE/@" docker-compose.yml.dist > docker-compose.yml
                    docker-compose build
                '''
            }
        }
        stage('Deploy Prod') {
            when {
                branch 'master'
            }
            steps {
                input message: 'Ok pour le déploiement en production ? ', ok: 'Yes'

                echo 'Déploiement Prod en cours'
                sh '''
                    docker-compose run --rm bundle install
                    docker-compose run --rm bundle exec cap production deploy
                '''
            }
        }
        stage('Deploy PréProd') {
            when {
                branch 'develop'
            }
            steps {
                echo 'Déploiement PréProd en cours'
                sh '''
                    docker-compose run --rm bundle install
                    docker-compose run --rm bundle exec cap preproduction deploy
                '''
            }
        }
    }

    post {
        always {
            sh "docker-compose down -v"
        }
    }
}
