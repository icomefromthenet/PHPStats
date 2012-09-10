for f in `ls /etc/apache2/modsecurity-crs/base_rules/`;
    do
      ln -s /etc/apache2/modsecurity-crs/base_rules/$f /etc/apache2/modsecurity-crs/activated_rules/$f ;
    done
exit 0;