#!/bin/bash

# Couleurs pour les messages
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fonctions
print_success() {
    echo -e "${GREEN}$1${NC}"
}

print_error() {
    echo -e "${RED}$1${NC}"
}

print_warning() {
    echo -e "${YELLOW}$1${NC}"
}

echo "========================================================"
echo "    Configuration du webhook GitHub-Jenkins"
echo "========================================================"

# Demander les informations nécessaires
read -p "URL Jenkins (ex: http://localhost:8080): " jenkins_url
read -p "Nom d'utilisateur Jenkins: " jenkins_user
read -s -p "Mot de passe/Token Jenkins: " jenkins_token
echo ""
read -p "Nom d'utilisateur GitHub: " github_user
read -s -p "Token GitHub (avec permissions 'repo' et 'admin:repo_hook'): " github_token
echo ""
read -p "Nom du dépôt GitHub: " repo_name
read -p "Nom de la branche (ex: aliou_ndour_branch): " branch_name

# Vérifier que Jenkins est accessible
print_warning "Vérification de l'accès à Jenkins..."
jenkins_status=$(curl -s -o /dev/null -w "%{http_code}" ${jenkins_url})

if [ $jenkins_status -eq 200 ]; then
    print_success "Jenkins est accessible (HTTP 200)"
else
    print_error "Erreur: Jenkins n'est pas accessible (HTTP ${jenkins_status})"
    exit 1
fi

# Créer un job Jenkins via l'API
print_warning "Création du job Jenkins..."

# XML de configuration pour le job Jenkins
cat > job_config.xml << EOF
<?xml version='1.1' encoding='UTF-8'?>
<flow-definition plugin="workflow-job@2.40">
  <actions/>
  <description>Pipeline pour le projet ISI BURGER</description>
  <keepDependencies>false</keepDependencies>
  <properties>
    <org.jenkinsci.plugins.workflow.job.properties.PipelineTriggersJobProperty>
      <triggers>
        <com.cloudbees.jenkins.GitHubPushTrigger>
          <spec></spec>
        </com.cloudbees.jenkins.GitHubPushTrigger>
      </triggers>
    </org.jenkinsci.plugins.workflow.job.properties.PipelineTriggersJobProperty>
  </properties>
  <definition class="org.jenkinsci.plugins.workflow.cps.CpsScmFlowDefinition" plugin="workflow-cps@2.90">
    <scm class="hudson.plugins.git.GitSCM" plugin="git@4.7.1">
      <configVersion>2</configVersion>
      <userRemoteConfigs>
        <hudson.plugins.git.UserRemoteConfig>
          <url>https://github.com/${github_user}/${repo_name}.git</url>
        </hudson.plugins.git.UserRemoteConfig>
      </userRemoteConfigs>
      <branches>
        <hudson.plugins.git.BranchSpec>
          <name>*/${branch_name}</name>
        </hudson.plugins.git.BranchSpec>
      </branches>
      <doGenerateSubmoduleConfigurations>false</doGenerateSubmoduleConfigurations>
      <submoduleCfg class="list"/>
      <extensions/>
    </scm>
    <scriptPath>Jenkinsfile</scriptPath>
    <lightweight>true</lightweight>
  </definition>
  <triggers/>
  <disabled>false</disabled>
</flow-definition>
EOF

# Créer le job Jenkins
job_create=$(curl -s -X POST -u "${jenkins_user}:${jenkins_token}" "${jenkins_url}/createItem?name=isi-burger" --data-binary @job_config.xml -H "Content-Type: application/xml")

if [ -z "$job_create" ]; then
    print_success "Job Jenkins créé avec succès"
else
    print_error "Erreur lors de la création du job Jenkins: ${job_create}"
    print_warning "Remarque: Si le job existe déjà, vous pouvez ignorer cette erreur."
fi

# Configurer le webhook GitHub
print_warning "Configuration du webhook GitHub..."

# Créer le webhook GitHub
webhook_payload='{
  "name": "web",
  "active": true,
  "events": ["push"],
  "config": {
    "url": "'${jenkins_url}'/github-webhook/",
    "content_type": "json",
    "insecure_ssl": "0"
  }
}'

webhook_create=$(curl -s -X POST -u "${github_user}:${github_token}" -d "${webhook_payload}" "https://api.github.com/repos/${github_user}/${repo_name}/hooks")

if echo "${webhook_create}" | grep -q "\"id\""; then
    webhook_id=$(echo "${webhook_create}" | grep -o '"id": [0-9]*' | head -1 | cut -d' ' -f2)
    print_success "Webhook GitHub créé avec succès (ID: ${webhook_id})"
else
    print_error "Erreur lors de la création du webhook GitHub: ${webhook_create}"
    print_warning "Remarque: Si le webhook existe déjà, vous pouvez le vérifier manuellement."
fi

print_warning "Tester le webhook..."
print_warning "Pour tester le webhook, vous pouvez faire un push sur votre branche ${branch_name}:"
echo "git add ."
echo "git commit -m \"Test webhook GitHub-Jenkins\""
echo "git push origin ${branch_name}"

print_success "Configuration terminée!"
print_warning "N'oubliez pas de vérifier les logs Jenkins pour vous assurer que tout fonctionne correctement."

# Nettoyage
rm -f job_config.xml
