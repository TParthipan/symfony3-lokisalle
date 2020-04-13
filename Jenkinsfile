pipeline {
    agent none
    environment {
        CI = 'true'
    }
    stages {
        stage('checkout'){
            deleteDir()
            checkout scm
        }
        stage('Stop Container'){
            sh 'docker ps | grep -E "workflow_|p0|elk-monitoring" -v | awk -F " " \'{if(NR>1)print $1}\' | xargs docker kill | xargs docker rm || true'
            sh 'docker system prune -f'        
        }
        stage("build develop") {
        agent any
            when {
                branch 'develop'
            }
            steps {
                script {
                    def imageApache = stage('Build apache'){
                        docker.build('server-apache-dev', '--no-cache -f build/docker/apache/Dockerfile .')
                    }
                    def imageSql = stage('Build mysql'){
                        docker.build('server-mysql-dev', '--no-cache -f build/docker/mysql/Dockerfile .')
                
                    }
                stage('Run Container mysql'){
                        containerSqlDev=imageSql.run('--name server-mysql-dev -v /home/projet/fatboar/dev/mysql:/var/lib/mysql --network=web')
                    }
                    stage('Run Container apache'){
                        containerApacheDev=imageApache.run('--name server-apache-dev --link server-mysql-dev:mysql --network=web')
                    }
                    stage('push'){
                            docker.withRegistry('https://nexus.fatboar-game.fun:8082','885ef60c-9352-489a-bd1c-e4b695747c21'){
                            imageApache.push('latest')
                            imageSql.push('latest')
                        }
                    }
                }
            }
        }
    }
}
