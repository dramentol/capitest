set   :application, "Capitest"
set   :domain,      "grupoelements.net"
set   :deploy_to,   "/var/www/vhosts/test.grupoelements.net"

set   :user,        "deploy"

set   :scm,           :git
set   :repository,    "git@github.com:dramentol/capitest.git"

set   :shared_files,      ["app/config/parameters.yml"]
set   :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set   :use_composer, true

# permissions
set   :writable_dirs,      ["app/cache", "app/logs", "app/spool"]

role  :web,           domain
role  :app,           domain, :primary => true

set   :use_sudo,      false
set   :keep_releases, 3


# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL
