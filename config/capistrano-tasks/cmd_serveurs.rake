desc "Servers cmd(s)"
namespace :servers do
	namespace :cmd do
	desc "Drush cmd(s)"
        namespace :drush do
            desc "Servers cmd drush cmd update bd all sites |drush @site updatebd|"
            task :updatebd do
                on roles(:db) do |host|
                      execute "#{fetch(:deploy_to)}/../scripts/drushcmd updatebd"
                end
            end
        end
	end
end
