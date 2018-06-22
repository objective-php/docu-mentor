# Guide for Example-Values

## By type

### String

The string can be surrounded by quotes or double-quotes or nothing:

```php
     *
     * @config-example-value 'Fully\\Qualified\\Class\\Name'
     *
```

### Array

The array has to be written in long syntax, **Shot syntax will not work** :

```php
     *
     * @config-example-value array('first_value' , 'second_value')
     *
```

### JSON Object

In valid JSON :

```php
     *
     * @config-example-value {"user_name": "Mocks username"}
     *
```

### Boolean

The boolean without quotes :

```php
     *
     * @config-example-value false
     *
```

## Note

### Multiple line

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

### Fallback value

For config-attributes, if @config-example-value is not specified, it try to get the value of the attribute.

```php
   /**
     * String without the example-value
     *
     * This one takes automatically the default value for the doc
     *
     * @config-attribute
     *
     * @var string
     */
    protected $anyString = 'MyDefaultString';
```



