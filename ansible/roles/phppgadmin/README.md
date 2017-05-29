phpPgAdmin
=========

Install phpPgAdmin for PostgreSQL.

Requirements
------------

Ubuntu trusty with the package python-pycurl and python-software-properties installed.

Role Variables
--------------
---
# defaults file for phppgadmin

    phppgadmin_template_src_file: phppgadmin_config.inc.php.j2 # Path of a Jinja2 formatted template on the local server. This can be a relative or absolute path.
    phppgadmin_version: master # REL_5-1-0, REL_4-2
    
    # If extra login security is true, then logins via phpPgAdmin with no password or certain usernames (pgsql, postgres, root, administrator) will be denied.
    # Only set this false once you have read the FAQ and understand how to change PostgreSQL's pg_hba.conf to enable passworded local connections.
    phppgadmin_extra_login_security: true 
Dependencies
------------

- [PostgreSQL](https://gitlab.mobidev.biz/ansible/pgsql)

License
-------

MIT

Author Information
------------------

[MobiDev](http://mobidev.biz/).
