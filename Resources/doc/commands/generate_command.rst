Generating a New Command Skeleton
================================

Usage
-----

The ``generate:command`` generates a new command structure in the specified bundle.

By default the command is run in the interactive mode and asks questions to
determine the bundle name, command class name, command name and description format:

.. code-block:: bash

    php app/console generate:command

To deactivate the interactive mode, use the `--no-interaction` option but don't
forget to pass all needed options:

.. code-block:: bash

    php app/console generate:bundle --bundle-name=AcmeBlogBundle --command-name=acme:do --command-class=AcmeDo --no-interaction

Available Options
-----------------

* ``--bundle-name``: The optional name of the bundle where the command will be created.

  .. code-block:: bash

        php app/console generate:bundle --bundle-name=AcmeBlogBundle

* ``--class-name``: The optional name for the command class. It must be a string. The suffix Command will be automatically added.

    .. code-block:: bash

        php app/console generate:bundle --class-name=AcmeDo

* ``--command-name``: The optional name for the command. It must be a string with a colon followed by another string.

    .. code-block:: bash

        php app/console generate:bundle --command-name=acme:do

* ``--command-description``: The optional description for the command. It must be a string. This string is presented when commands are listed.

    .. code-block:: bash

        php app/console generate:bundle --command-description="This command does this and that"

