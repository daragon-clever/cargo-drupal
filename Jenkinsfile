import java.util.Random

pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Building...'
                sh '''
                    sed "s@{{ CHEMIN_LOCAL }}@$WORKSPACE/@" docker-compose.yml.dist > docker-compose.yml
                    docker-compose build
                '''
            }
        }
        stage('TEST') {
            when {
                branch 'feature/deploy'
            }
            steps {
                input message: 'You REALLY want to build?', ok: 'Yes'

                echo "Java rocks ?"
            }
        }
        stage('Deploy') {
            when {
                branch 'develop'
            }
            steps {
                echo 'Deploying....'
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
