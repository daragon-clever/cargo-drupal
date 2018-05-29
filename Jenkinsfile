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
