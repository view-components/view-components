Component Documentation
===

## Table of Contents 

- [CollectionView](#collectionview)
- [Compounds](#compounds)

## CollectionView

[CollectionView](https://github.com/view-components/view-components/blob/master/src/Component/CollectionView.php) is a component for rendering data collections.
 
CollectionView::render() iterates over its data collection,
injects data elements into children components and renders it for each data item.

## Compounds

View-components package contains few classes and interfaces for working with components composed from parts:

Class or Interface | Description
--- | ---
[Compound](https://github.com/view-components/view-components/blob/master/src/Component/Compound.php "ViewComponents\ViewComponents\Component\Compound") | Base class for components composed from parts
[PartInterface](https://github.com/view-components/view-components/blob/master/src/Base/Compound/PartInterface.php "ViewComponents\ViewComponents\Base\Compound\PartInterface") | Interface for compound part
[ContainerPartInterface](https://github.com/view-components/view-components/blob/master/src/Base/Compound/ContainerPartInterface.php "ViewComponents\ViewComponents\Base\Compound\ContainerPartInterface") | Interface for compound part
[Part](https://github.com/view-components/view-components/blob/master/src/Component/Part.php "ViewComponents\ViewComponents\Component\Part") | Wrapper that allows to use any component as compound part 

Compound parts are responsible for it's identification and location inside [Compound](https://github.com/view-components/view-components/blob/master/src/Component/Compound.php "ViewComponents\ViewComponents\Component\Compound").
Any part has "id" and "destination_parent_id" properties with corresponding getters and setters.
Value of  "destination_parent_id" should be equal to one of another part id's or Compound::ROOT_ID constant.

### Usage

#### Creating compound component

Constructor of [Compound](https://github.com/view-components/view-components/blob/master/src/Component/Compound.php "ViewComponents\ViewComponents\Component\Compound") accepts array of objects implementing [PartInterface](https://github.com/view-components/view-components/blob/master/src/Base/Compound/PartInterface.php "ViewComponents\ViewComponents\Base\Compound\PartInterface").

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