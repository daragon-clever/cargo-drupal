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
append :linked_files, "web/sites/sites.php", "web/sites/turbocar/settings.php", "web/sites/ostaria/settings.php", "drush/sites/web.site.yml"

# Default value for linked_dirs is []  
append :linked_dirs, "web/sites/turbocar/private", "web/sites/ostaria/private", "web/sites/ostaria/files/config_wz5XjfX-1NHbr27qRCy9WbvgUd_Qv6iDiRXrhr4jkLXBsP7Pui0ZdGZBciqKqQxzBsfyCvPlfA"

# Configure file permissions
set :file_permissions_paths, [
    "web/sites/turbocar/private",
    "web/sites/turbocar/private",
    "web/sites/ostaria/files/config_wz5XjfX-1NHbr27qRCy9WbvgUd_Qv6iDiRXrhr4jkLXBsP7Pui0ZdGZBciqKqQxzBsfyCvPlfA"
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

    # TODO Améliorer et remplacer par les vraies tâches drush site-alias
    after :updated, :clear_cache do
        invoke "drupal:updatedb:web"
        #invoke "drupal:drush, @web cr"
    end
end
