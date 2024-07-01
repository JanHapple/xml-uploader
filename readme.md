## CLI tool to process XML data to a database

### Overview
This tool provides a command-line programm that processes xml data to a configurable database. The database can be 
configured in the .env file to the database service of your choice with the DATABASE_URL. XML data can be processed from
local filesystem within the programm or from an external uri. To test the application there are feed.xml and feed1.xml files
in the root of the filesystem as well as in the 

### Start the program
To test the programm, you need to have docker running on your local environment. The programm is build up with DDEV for 
testing purposes. Please install [DDEV](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) to get started.
After setting up the environment, clone the repository and build the programm with:
```
ddev start
```

After building the environment of the programm, install all dependencies with:
```
ddev composer install
```

Than migrate the database schema with:
```
ddev php bin/console doctrine:migrations:migrate
```

After everything is set up, start trying the program.

### The command
You can run the Command with 
```
ddev php bin/console app:processXmlFile
```

You can use the following arguments and flags
```
ddev php bin/console app:processXmlFile filepath/uri
```
When you enter the command with a relative 
filepath or an valid uri (schema://host/path/filename.xml) to the xml file, the file will be directly processed, if possible.
Without the filepath or uri, you will be prompted to provide the correct path or uri to the file.

```
ddev php bin/console app:processXmlFile --truncate
```
Truncates the database entries before processing the file. 


### Tests 
The provided tests for the commands are reduced to the most essential due to the fact that 
these tests were my first experience with testing.

To run the tests you first have to create a testing database.
```
ddev php bin/console --env=test doctrine:database:create
```

After the testing database ist created, please migrate the database schema:
```
ddev php bin/console --env=test doctrine:migrations:migrate
```

After everything is set up, run the tests with the following command:
```
ddev php bin/phpunit
```