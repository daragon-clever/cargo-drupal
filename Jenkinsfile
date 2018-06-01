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
            echo 'always'
        }
        success {
            echo 'I succeeeded!'
            // send to email Déploiements Jenkins réussit
            slackSend (
                color: '#006400',
                channel: "#deployjenkinssuccess",
                message: "Déploiement  '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]' réussit"
                )
       }
        unstable {
            echo 'I am unstable :/'
            // send build success notifications
            slackSend (
                color: '#FF0000',
                channel: "#deployjenkinsfalse",
                message: "Erreur déploiements [unstable] '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]' (<${env.BUILD_URL}|Open>) "
                )
            emailext (
                subject: "Jenkins - Erreur déploiements: Job '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]'",
                to: 'poleweb@cargo-services.fr',
                body: """<p>Erreur déploiements [unstable] '${env.JOB_NAME} [${env.BUILD_NUMBER}]':</p>
                  <p>Verifier la console  &QUOT;<a href='${env.BUILD_URL}'>${env.JOB_NAME} [${env.BUILD_NUMBER}]</a>&QUOT;</p>""",
                recipientProviders: [[$class: 'DevelopersRecipientProvider']]
              )
         }
        failure {
            echo 'I failed :('
            // send build success notifications
            slackSend (
                color: '#FF0000',
                channel: "#deployjenkinsfalse",
                message: "Erreur déploiements [failure] '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]' (<${env.BUILD_URL}|Open>) "
                )
            emailext (
                subject: "Jenkins - Erreur déploiements: Job '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]'",
                to: 'poleweb@cargo-services.fr',
                body: """<p>Erreur déploiements [failure] '${env.JOB_NAME} [${env.BUILD_NUMBER}]':</p>
                  <p>Verifier la console  &QUOT;<a href='${env.BUILD_URL}'>${env.JOB_NAME} [${env.BUILD_NUMBER}]</a>&QUOT;</p>""",
                recipientProviders: [[$class: 'DevelopersRecipientProvider']]
              )
         }
    }
}
