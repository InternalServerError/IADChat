# IADChat

Technical applicant test for IAD, developed with imposed technologies : PHP7.4 vanilla, jQuery and HTML5.

For convenience, two external libraries have been added : 

+ [ramsey/Uuid](https://github.com/ramsey/uuid)
+ [phpdotenv](https://github.com/vlucas/phpdotenv)

The project has been developed on Ubuntu 18.04. Tested on Firefox and Chrome.

**This project was tested and develop for Linux usage**

## Requirements

This project needs the followings in order to build correctly : 

+ make
+ docker
+ docker-compose

## Installation

For building the project, just run the following command on the root of the directory :

```bash
make install
```
+ **If during the composer install, Token is asked, just press ENTER**
+ After the installation completion, open your preferred web Browser and navigate to http://localhost/