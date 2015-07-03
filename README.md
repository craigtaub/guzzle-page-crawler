
#Sainsburys product crawler

Setup

    make clean
    make install

Run

    php scripts/run.php

Test

    make test

Todo

    - Complete tests
    - Ran out of time to add error handling
    - For now Controller (integration) tests make actual request to data, this should be swapped for dynamic mechanism building fixtures.
    - Build Fake and Fail HTTP clients for proper request testing.
    - Add PHPCS dependencies and make block.
    - Add Travis job for `build status` and `test coverage` badges.
