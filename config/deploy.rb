# config valid for current version and patch releases of Capistrano
lock "~> 3.10.2"

set :application, "drupal"
set :repo_url, "git@github.com:PoleWebCargo/drupal.git"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, "/home/www/sitedrupal_preprod/deployment"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
set :format_options, command_output: true, log_file: "var/logs/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
append :linked_files, "web/sites/sites.php", "web/sites/default/default.settings.php", "web/sites/turbocar/settings.php", "web/sites/ostaria/settings.php", "web/sites/yliades/settings.php", "web/sites/groupecargo/settings.php", "web/sites/blog-sitram/settings.php", "web/sites/facom/settings.php", "web/sites/comptoirdefamille/settings.php", "web/sites/cogex-epi/settings.php", "web/sites/cestdeuxeuros/settings.php", "web/sites/cogex/settings.php", "web/sites/gersequipement/settings.php", "web/sites/ope-sitram/settings.php", "drush/sites/web.site.yml", "web/sites/sitram/settings.php",

# Default value for linked_dirs is []
append :linked_dirs, "web/sites/turbocar/private","web/sites/turbocar/media", "web/sites/ostaria/private", "web/sites/ostaria/files", "web/sites/yliades/private", "web/sites/yliades/files", "web/sites/groupecargo/private", "web/sites/groupecargo/files", "web/sites/blog-sitram/private", "web/sites/blog-sitram/files", "web/sites/facom/private", "web/sites/facom/files", "web/sites/comptoirdefamille/private", "web/sites/comptoirdefamille/files", "web/sites/cogex-epi/private", "web/sites/cogex-epi/files", "web/sites/cestdeuxeuros/private", "web/sites/cestdeuxeuros/files", "web/sites/cogex/private", "web/sites/cogex/files", "web/sites/gersequipement/private", "web/sites/gersequipement/files", "web/sites/ope-sitram/private", "web/sites/ope-sitram/files", "web/sites/sitram/private", "web/sites/sitram/files"
# Configure file permissions
set :file_permissions_paths, [
    "web/sites/turbocar/media",
    "web/sites/turbocar/private",
    "web/sites/ostaria/private",
    "web/sites/ostaria/files",
    "web/sites/yliades/private",
    "web/sites/yliades/files",
    "web/sites/groupecargo/private",
    "web/sites/groupecargo/files",
    "web/sites/blog-sitram/private",
    "web/sites/blog-sitram/files",
    "web/sites/facom/private",
    "web/sites/facom/files",
    "web/sites/comptoirdefamille/private",
    "web/sites/comptoirdefamille/files",
    "web/sites/cogex-epi/private",
    "web/sites/cogex-epi/files",
    "web/sites/cestdeuxeuros/private",
    "web/sites/cestdeuxeuros/files",
    "web/sites/cogex/private",
    "web/sites/cogex/files",
    "web/sites/gersequipement/private",
    "web/sites/gersequipement/files",
    "web/sites/ope-sitram/private",
    "web/sites/ope-sitram/files",
    "web/sites/sitram/private",
    "web/sites/sitram/files",
    ]

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
set :keep_releases, 3

# Uncomment the following to require manually verifying the host key before first deploy.
set :ssh_options, verify_host_key: :secure

# Installing composer as part of a deployment
set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader --no-scripts'
namespace :deploy do
    after :starting, 'composer:install_executable'
    after :starting, :set_composer do
        SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"
    end
end
after 'deploy:symlink:release', 'patch:apply'
after 'patch:apply', 'servers:cmd:drush:updatebd'
