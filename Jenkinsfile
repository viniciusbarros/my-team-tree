pipeline {
  agent any
  stages {
    stage('Code Build') {
      steps {
        sh '''git clone git@github.com:viniciusbarros/my-team-tree.git;
cd my-team-tree;
git checkout master;
composer install;
'''
      }
    }
  }
}