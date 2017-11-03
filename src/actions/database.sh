echo "[******] Run the following command to see Docker’s network range [This is optional].";
echo "ip a | grep docker | grep inet";

echo "[******] Execute the follow command in host for configure your database. Save the IPAddress returned.";
echo "[sudo] docker inspect database-mysql | grep IPAddress";

echo "[******] Get the IPAddress and execute the follow command in your host.";
echo "mysql -u root -h <ip_address_returned> -p12345678 < /tmp/src/actions/database/script_inicial.sql";