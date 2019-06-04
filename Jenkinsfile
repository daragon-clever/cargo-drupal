import java.util.Random

def notifyChangeViaSlackEmail(buildBranch,String buildStatus) {
    def sendSlack
    def sendEmail
    if( buildBranch == 'master' ){
        sendSlack = 1
    } else if ( buildBranch == 'develop' ) {
        sendSlack = 1
    } else {
        sendSlack = 0
    }

    echo "notifyChangeViaSlackEmailtest buildBranch [${buildBranch}] [${buildStatus}] [${sendSlack}]"

    if( sendSlack == 1 ){
        if( buildStatus == 'success' ){
            slackSend (
                color: '#006400',
                channel: "#deployjenkinssuccess",
                message: "Déploiement  '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]' réussi"
                )
        } else {
            slackSend (
                color: '#FF0000',
                channel: "#deployjenkinsfalse",
                message: "Erreur déploiements [failure] '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]' (<${env.BUILD_URL}|Open>) "
                )
            emailext (
                subject: "Jenkins - Erreur déploiements: Job '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]'",
                to: 'poleweb@cargo-services.fr',
                body: """<p>Erreur déploiements [unstable] '${env.JOB_NAME} [${env.BUILD_NUMBER}]':</p>
                  <p>Verifier la console  &QUOT;<a href='${env.BUILD_URL}'>${env.JOB_NAME} [${env.BUILD_NUMBER}]</a>&QUOT;</p>""",
                recipientProviders: [[$class: 'DevelopersRecipientProvider']]
              )
        }
    }
}

pipeline {
    agent any

    options {
        disableConcurrentBuilds()
    }

    stages {
        stage('Build') {
            when {
                beforeAgent true
                anyOf {
                    branch 'master';
                    branch 'develop'
                }
            }
            steps {
                echo 'Building...'
                // send build started notifications
                //slackSend (color: '#FFFF00', message: "STARTED: Job '${env.JOB_NAME} [${env.BUILD_NUMBER}]' (${env.BUILD_URL})")

                sh '''
                    sed "s|{{ CHEMIN_LOCAL }}|$WORKSPACE/|" docker-compose.yml.dist > docker-compose.yml
                    docker-compose build
                '''
            }
        }
        stage('Deploy Prod') {
            when {
                beforeAgent true
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
            post {
                always {
                    sh "docker-compose down -v"
                }
            }
        }
        stage('Deploy PréProd') {
            when {
                beforeAgent true
                branch 'develop'
            }
            steps {
                echo 'Déploiement PréProd en cours'
                sh '''
                    docker-compose run --rm bundle install
                    docker-compose run --rm bundle exec cap preproduction deploy
                '''
            }
            post {
                always {
                    sh "docker-compose down -v"
                }
            }
        }
    }

    post {
        cleanup {
            cleanWs()
            deleteDir()
        }
        success {
            echo 'I succeeeded!'
            // send build success notifications
            notifyChangeViaSlackEmail(env.BRANCH_NAME,'success')

        }
        unstable {
            echo 'I am unstable :/'
            // send build success notifications
             notifyChangeViaSlackEmail(env.BRANCH_NAME,'unstable')
        }
        failure {
            echo 'I failed :('
            // send build success notifications
             notifyChangeViaSlackEmail(env.BRANCH_NAME,'failure')
        }
    }
}
