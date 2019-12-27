import java.util.Random

def notifyChangeViaSlackEmail(buildBranch,String buildStatus) {
    def sendSlack
    def sendEmail
    if( buildBranch == 'master' ){
        sendSlack = 1
        sendEmail = 1
    } else if ( buildBranch == 'develop' ) {
        sendSlack = 1
        sendEmail = 0
    } else {
        sendSlack = 0
        sendEmail = 0
    }

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
                message: "Erreur déploiement [failure] '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]' (<${env.BUILD_URL}|Open>) "
                )
            emailext (
                subject: "Jenkins - Erreur déploiements: Job '${env.JOB_NAME} ${env.GIT_BRANCH} [${env.BUILD_NUMBER}]'",
                to: 'poleweb@cargo-services.fr',
                body: """<p>Erreur déploiement [unstable] '${env.JOB_NAME} [${env.BUILD_NUMBER}]':</p>
                  <p>Verifier la console  &QUOT;<a href='${env.BUILD_URL}'>${env.JOB_NAME} [${env.BUILD_NUMBER}]</a>&QUOT;</p>""",
                recipientProviders: [[$class: 'DevelopersRecipientProvider']]
              )
        }
    }
    if( sendEmail == 1 ){
        if( buildStatus == 'success' ){
            sendChangeLogs()
        }
    }
}
@NonCPS
def sendChangeLogs() {
    def commitMessages = ""
    def changeLogSets = currentBuild.changeSets
    for (int i = 0; i < changeLogSets.size(); i++) {
        def entries = changeLogSets[i].items
        for (int j = 0; j < entries.length; j++) {
            def entry = entries[j]
            commitMessages = commitMessages + "<li style='font-family: Arial;'><b>${entry.msg}</b> - ${entry.author}</li>"
        }
    }
    emailext (
        subject: "[DEPLOY SUCCESS] ${env.JOB_NAME}",
        to: 'poleweb@cargo-services.fr',
        body: """
            <h1 style='font-family: Arial;'>${env.JOB_NAME}</h1>

            <hr />

            <p style='font-family: Arial;'>
                <u>Libellés des commits :</u>
                <ul style='font-family: Arial;'>
                    ${commitMessages}
                </ul>
            </p>

            <hr />

            <p style='font-family: Arial;'>
                <small>
                    <a href='${env.BUILD_URL}'>
                        Voir le déploiement sur Jenkins
                    </a>
                </small>
            </p>
        """,
        recipientProviders: [[$class: 'DevelopersRecipientProvider']]
      )
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
                    docker-compose pull
                    docker-compose build --pull
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
