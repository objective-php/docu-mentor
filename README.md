# ObjectivePHP \ DocuMentor

## Project introduction
We always wanted to make our framework Objective PHP serviceable for every person who get interested getting an use of it.
We tried to write documentation in many ways but we choose to write a tool to generate a custom markdown documentation for every components.

 ## Installation

 ### Composer

 The easiest way to install the library and get ready to play with it is by using Composer. Run the following command :

 ```
 composer require objective-php/docu-mentor 
 ```
The will be accessible in ./vendor/bin

## Configuration directive documentation guide

[Here](Doc-guide.md)

## How to use

### Usage
```
php docu [OPTIONS]    

    -i, --init      Generate the docs/.md files 
    -c, --configs   Update the config-directive doc file
    -v, --verbose   Shows the errors
    -vv, -vvv       Shows the errors more expressly
    -f, --force     Overwrite the docs
    -h,-u, --help,--usage   
                    Show this message
     --config-dir=[path]
                    Specify a custom path for the configs   
     --docs-dir=[path]   
                    Specify a custom path for output directory   
 ```                 
 
### Examples:
Init the whole documentation:
``` bash
    php docu -ic
```
Rewrite the config doc:
``` bash
    php docu -c -v
```     
Rewrite and debug your config:
``` bash
    php docu -c -vvv
```
Reset the docs:
``` bash
    php docu -i --force 
```        
Custom pathes:
``` bash
    php docu -ic --config-dir=./docs/ --docs-dir=./Config  
```

## The whole documentation
Full documentation can be found at [objective-php.org](http://objective-php.org/)
