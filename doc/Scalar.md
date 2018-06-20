# Guide for a Scalar directive



## General:

### 1.The class docblock

The directive should be commented and described in his class docblock :

```php
<?php
/**
 * NOT HERE, here you can have the GNU licence, or project presentation 
 */

/**
 * This is the summary
 *
 *
 * This directive is also used for the exemple, this is the description (or summary) of   this directive
 * This is just the continuation maybe I Lorem Ipsum Dolores Esta may Andrian mateos doiaz catmarantt
 *
 */
public class ExampleConfig {
```

### 2.The KEY

The attribut \$key must be defined and be accessible from a getter (getKey()): 

```php
	protected $key = self::KEY;
```



## Specific

### 1.Le cas scalaire

Si la directive en plus d'être multi est multi scalaire, alors le docblock de l'attribut reference devra contenir le tag @config-example-value avec une valeur scalaire pour exemple

```php
    /**
     * @config-index "actionNamespace.id"
     * @config-example-value true
     * @var string 
     */
    protected $reference;
```

## Les exemples

**Si un @config-attribute ne possède pas @config-example-value, alors le programme va tenter de prendre la valeur attribuée directement à la propriété** 

Selon si la valeur est un string, un array ou un objet JSON :

### String
Le string entouré de quotes ou double-quotes ou non:

```php
     *
     * @config-example-value 'Fully\\Qualified\\Class\\Name'
     *
```

### Array
L'array sous sa forme classique, **La syntaxe courte ne fonctionnera pas** :

```php
     *
     * @config-example-value array('first_value' , 'second_value')
     *
```

### Objet JSON 
L'objet JSON :

```php
     *
     * @config-example-value {"user_name": "Mocks username"}
     *
```


### Boolean
Le boolean sans quotes :

```php
     *
     * @config-example-value false
     *
```

### Les exemples peuvent s'écrire sur plusieurs lignes :

```php
     *
     * @config-example-value {
     * @config-example-value "user_name": "Mocks username",
     * @config-example-value "brother_name": "Mocks brothername"
     * @config-example-value }
     *
     *
     * @config-example-value array( 'first_value', 
     * @config-example-value        'second_value' )
     *
     *
     * @config-example-value Start of a stri 
     * @config-example-value ng, end of a string
     *
```