# Guide for a Scalar directive



## General

### The class docblock

The directive should be commented and described in his class docblock. Because is it Scalar, you should scpecify an example-value with the tag @config-example-value.

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
 * @config-example-value 'my-value'
 *
 */
public class ExampleConfig extends AbstractScalarDirective {
```



### Multi-Scalar

If the directive is Multi, you should specify the @config-example-reference tag. Also in the class docblock.

```php
*
* @config-example-reference 'example.id'
*
```



