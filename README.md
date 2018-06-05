# ObjectivePHP \ DocuMentor
## Disclaimer

This document is written in globish, the flavour of English we're trying to use in France. We know how bad our english is, please don't pay too much attention to it :)

Although we're thinking to this library for a while now, its implementation is still in early stage, and for the next coming months, you'll probably see a few code and a lot of changes in it. This means that if you're interested in this project, you're more than welcome to try it, contribute to it, make proposals for it, but please don't use it in production projects for now!

## Project introduction
We always wanted to make our framework Objective-Php serviceable for every person who get interested getting an use of it.
We tried to write documentation in many ways but we choose to write a tool to generate a custom markdown documentation for every components.

 ## Installation

 ### Composer

 The easiest way to install the library and get ready to play with it is by using Composer. Run the following command :

 ```
 composer require --dev objective-php/docu-mentor:dev-master 
 ```

## Configuration directive documentation guide

[Here](Doc-guide.md)

## Usage

Docu-mentor - Objective-php's doc generator 

Usage: docu [OPTIONS] 

    -i, --init    Generate the docs/.md files 
    -c, --configs Generate or update the config-directive doc file
    -v, --verbose Shows the errors
    -f, --force   Overwrite the docs
    -h, --help    Show this message
 
Examples:

    Init the whole documentation:

        docu -ic

    Rewrite the config doc:

        docu -c 
    
    Reset the docs:

        docu -i --force 
 

Full documentation can be found at http://objective-php.org/

