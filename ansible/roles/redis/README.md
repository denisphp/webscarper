Redis
=========

Install Redis. Redis is an open source (BSD licensed), in-memory data structure store, used as database, cache and message broker.    
Official site: <http://redis.io/>

Requirements
------------

Ubuntu trusty with the package python-pycurl and python-software-properties installed.

Role Variables
--------------

Available variables are listed below, along with default values (see [defaults/main.yml](defaults/main.yml)):

    redis_conf_src_file: redis.conf.j2 # Path of a Jinja2 formatted template on the local server. This can be a relative or absolute path.
    redis_upstart_src_file: upstart_redis.conf.j2 # Path of a Jinja2 formatted template on the local server. This can be a relative or absolute path.
    redis_version: 3.0.6

Dependencies
------------

None.

License
-------

MIT

Author Information
------------------

[MobiDev](http://mobidev.biz/).
