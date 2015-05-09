file=backup/`date +homiq-%Y-%m-%d-%H-%M.tar`
tar -czf $file *.php *.db *.ini *.sh
