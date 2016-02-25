dropdb  homiq-promienko
createdb  -E UTF8 homiq-promienko
rm -f homiq-promienko.sql
gzip -d homiq-promienko.sql.gz
psql -d homiq-promienko -f homiq-promienko.sql
gzip homiq-promienko.sql
