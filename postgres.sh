export PGDATA=/var/lib/postgresql/current/data
rm -f $PGDATA/postmaster.pid
pg_ctl start
