Component Documentation
===

## Table of Contents 

- [CollectionView](#collectionview)
- [Compounds](#compounds)
## CollectionView

CollectionView is a component for rendering data collections.
 
CollectionView::render() iterates over its data collection,
injects data elements into children components and renders it for each data item.

## Compounds

View-components package contains few classes and interfaces for working with components composed from parts:

Class | Description
 --- | ---
 ViewComponents\ViewComponents\Component\Compound | Base class for components composed from parts
 ViewComponents\ViewComponents\Base\Compound\PartInterface | Interface for compound part
 ViewComponents\ViewComponents\Base\Compound\Container\PartInterface | Interface for compound part
 ViewComponents\ViewComponents\Component\Part | Wrapper that allows to use any component as compound part 

Base class for components composed from parts.
Compound parts must implement PartInterface.

### Usage

#### Creating compound component

Compound constructor accepts array of objects implementing PartInterface.

#### Example

```php
use ViewComponents\ViewComponents\Component\Compound;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Html\TagWithText;

$panel = new Tag('div', ['class' => 'panel panel-success']);
$header  = new Tag('div', ['class' => 'panel-heading'], []);
$caption = new TagWithText('b', 'Panel Header');
$body    = new TagWithText('div', 'Panel Body', ['class' => 'panel-body']);
$footer  = new TagWithText('div', 'Panel Footer', ['class' => 'panel-footer']);

$compound = new Compound([
    new Part($panel, 'panel'),
    new Part($header, 'header', 'panel'),
    new Part($caption, 'caption', 'header'),
    new Part($body, 'body', 'panel'),
    new Part($footer, 'footer', 'panel'),
]);
echo $compound;
```

See similar code in demo application: 
[code](https://github.com/view-components/view-components/blob/master/tests/webapp/Controller.php#L252)
[demo](http://view-components.herokuapp.com/index.php/demo6)