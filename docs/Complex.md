# Guide for a Complex directive



## General

### The class docblock

The directive should be commented and described in his class docblock.

```php
<?php
/**
 * NOT HERE, here you can have the GNU licence, or project presentation 
 */

/**
 * This is the summary
 *
 * This directive is also used for the exemple, this is the description (or summary) of 
 * this directive
 * This is just the continuation maybe I Lorem Ipsum Dolores Esta may Andrian mateos diaz
 * catmarant
 *
 */
public class ExampleConfig extends AbstractComplexDirective {
```

### The properties

Each property should have a docblock with at least the @config-attribute tag. It should contain a summary, a description and the @config-example-value tag. 

```php
   /**
     * Service class name
     *
     * Define here the FQCN of the service.
     *
     * @config-attribute
     * @config-example-value 'Fully\\Qualified\\Class\\Name'
     * @var string
     */
    protected $class;
```

### Types

The type is automaticaly catched on the @var tag but can be overiden after the @config-attribute.

```php
    /**
     * Setters to call on service once instantiated
     *
     * Array of key/value pairs with keys being setter method names and values being
     * parameters to pass to setter
     * methods.
     *
     * @config-attribute hash
     * @var array
     */
    protected $setters;
```

### Multi-Complex

If the directive is Multi, you have to specify in the docblock of \$reference the @config-example-reference tag. 

```php
    /**
     * @config-example-reference "example.id"
     * @var string
     */
    protected $reference;
```

### 