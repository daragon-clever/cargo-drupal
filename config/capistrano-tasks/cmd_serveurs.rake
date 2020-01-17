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

# Apply patches
# ------------------------------------
desc "Patches"
namespace :patch do
    desc "Apply patch"
    task :apply do
        on release_roles :all do |host|
            last_release = capture(:ls, "-xt", releases_path).split.first
            last_release_path = releases_path.join(last_release)
            patch_name = '3035883-29-workaround.patch'
            module_name = 'recaptcha'
            patch_file = "#{last_release_path}/web/patches/"
            dest_patch_file = "#{last_release_path}/web/modules/contrib/#{module_name}/"

            execute "cp #{patch_file}#{patch_name} #{dest_patch_file}#{patch_name}"   #copy file on destination module
            execute "cd #{dest_patch_file} && git init && git apply -v #{patch_name}" #move to execute command git + init before set + apply patch
        end
    end
end
